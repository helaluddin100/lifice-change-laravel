<?php

namespace App\Http\Controllers\Api;

use App\Models\Shop;

use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Models\CourierSetting;
use App\Mail\OrderStatusUpdated;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{

    public function generateInvoice($orderId)
    {
        $order = Order::find($orderId);

        if (!$order) {
            return response()->json(['error' => 'Order not found'], 404);
        }

        $shop = Shop::find($order->shop_id);

        $orderItems = OrderItem::where('order_id', $orderId)->get();

        $orderItemsWithProductDetails = $orderItems->map(function ($item) {
            $product = Product::with('images')->find($item->product_id);

            if ($product) {
                $item->product_details = $product;

                $item->product_image = $product->images && $product->images->isNotEmpty()
                    ? asset('storage/' . $product->images->first()->image_path)
                    : null;
            } else {
                $item->product_details = null;
                $item->product_image = null;
            }

            return $item;
        });

        $pdf = PDF::loadView('invoices.invoice', [
            'order' => $order,
            'shop' => $shop,
            'order_items' => $orderItemsWithProductDetails,
        ]);

        return $pdf->download('invoice.pdf');
    }



    public function updateStatus(Request $request, $id)
    {
        // Validate the order status
        $validated = $request->validate([
            'order_status' => 'required|string|in:pending,processing,shipped,delivered,canceled',
            'total_price' => 'required',
            'courier_type' => 'required',
            'city_id' => $request->courier_type == 1 ? 'required' : 'nullable',
            'zone_id' => $request->courier_type == 1 ? 'required' : 'nullable',
            'area_id' => $request->courier_type == 1 ? 'required' : 'nullable',
            'item_weight' => $request->courier_type == 1 ? 'required' : 'nullable',
            'item_description' => $request->courier_type == 1 ? 'required' : 'nullable',
            'special_instruction' => $request->courier_type == 1 ? 'required' : 'nullable',
            'item_type' => 'nullable', // This field is always nullable
        ]);

        $order = Order::with('orderItems')->find($id);
        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        if ($validated['order_status'] == 'shipped' && in_array($validated['courier_type'], [1, 2])) {
            $courierSetting = CourierSetting::where([
                ['user_id', $order->user_id],
                ['courier_id', $validated['courier_type']]
            ])->first();

            if (!$courierSetting) {
                return response()->json(['message' => 'Courier settings not found'], 404);
            }
        }

        // Handle product stock when order is delivered
        if ($order->order_status !== 'delivered' && $validated['order_status'] === 'delivered') {
            foreach ($order->orderItems as $item) {
                $product = Product::find($item->product_id);
                if ($product) {
                    $product->quantity = max(0, $product->quantity - $item->quantity);
                    $product->sold_count = $product->sold_count + $item->quantity;
                    $product->save();
                }
            }
        }

        // If the courier type is 2 (Steadfast), send the request to Steadfast API
        if ($validated['courier_type'] == 2 && $validated['order_status'] == 'shipped') {
            $response = $this->sendOrderToSteadfast($order, $request, $courierSetting);
            if ($response['status'] !== 200) {
                return response()->json(['message' => 'Failed to place order with Steadfast'], 500);
            }
        } elseif ($validated['courier_type'] == 1 && $validated['order_status'] == 'shipped') {
            // Handle Pathao API logic for courier_type == 1
            $response = $this->sendOrderToPathao($order, $request, $courierSetting);
            if ($response['status'] !== 200) {
                return response()->json(['message' => 'Failed to place order with Pathao'], 500);
            }
        }
        // For other order status updates, just update the order status
        $order->order_status = $validated['order_status'];
        $order->save();

        if ($order->order_status == 'shipped') {
            // Send the updated order status via email
            Mail::to($order->email)->send(new OrderStatusUpdated($order));
        }
        return response()->json([
            'message' => 'Order status updated successfully',
            'order' => $order
        ], 200);
    }

    public function sendOrderToSteadfast($order, $request, $courierSetting)
    {
        // Steadfast API URL and Authentication
        $apiUrl = 'https://portal.packzy.com/api/v1/create_order';
        $apiKey = $courierSetting->client_id;
        $secretKey =  $courierSetting->client_secret;

        // Prepare the data for the Steadfast API request
        $data = [
            'invoice' => $order->order_id,
            'recipient_name' => $order->name,
            'recipient_phone' => $order->phone,
            'recipient_address' => $order->address,
            'cod_amount' => $order->total_price,
            'note' => $request->special_instruction ?? "Please deliver this product on time",
            'item_weight' => $request->item_weight,
            'item_description' => $request->item_description ?? "Please deliver this product on time",
        ];

        // Make the POST request to Steadfast API using Guzzle or Http Client
        try {
            $response = Http::withHeaders([
                'Api-Key' => $apiKey,
                'Secret-Key' => $secretKey,
                'Content-Type' => 'application/json',
            ])->post($apiUrl, $data);

            $responseData = $response->json();

            // Check if the response is successful
            if ($response->successful()) {
                return ['status' => 200, 'message' => 'Order placed successfully'];
            } else {
                Log::error('Failed to place order with Steadfast', $responseData);
                return ['status' => 500, 'message' => 'Failed to place order with Steadfast'];
            }
        } catch (\Exception $e) {
            // If there's an error, log the error and return the error message
            Log::error('Exception occurred while placing order with Steadfast', ['error' => $e->getMessage()]);
            return ['status' => 500, 'message' => $e->getMessage()];
        }
    }

    public function sendOrderToPathao($order, $request, $courierSetting)
    {
        // Pathao API URL for token and orders
        $baseUrl = 'https://api-hermes.pathao.com/aladdin/api/v1/';
        $apiUrl = $baseUrl . 'orders';  // Adjust API URL if needed

        // Prepare the data to get access token
        $tokenData = [
            'client_id' => $courierSetting->client_id,
            'client_secret' => $courierSetting->client_secret,
            'grant_type' => 'password',
            'username' => $courierSetting->username,
            'password' => $courierSetting->password,
        ];

        // Request to get access token
        $client = new \GuzzleHttp\Client();
        try {
            // Fetch the access token
            $tokenResponse = $client->post($baseUrl . 'issue-token', [
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
                'json' => $tokenData,
            ]);

            // Get the response body and decode the JSON
            $tokenResponseData = json_decode($tokenResponse->getBody()->getContents(), true);

            if (!isset($tokenResponseData['access_token'])) {
                Log::error('Failed to get access token from Pathao', $tokenResponseData);
                return ['status' => 500, 'message' => 'Failed to get access token from Pathao'];
            }

            // Access token
            $accessToken = $tokenResponseData['access_token'];

            // Prepare the data for placing the order with Pathao
            $orderData = [
                'store_id' => $courierSetting->store_id,
                'merchant_order_id' => $order->order_id,
                'recipient_name' => $order->name,
                'recipient_phone' => $order->phone,
                'recipient_address' => $order->address,
                'recipient_city' => $request->city_id,  // From request
                'recipient_zone' => $request->zone_id,  // From request
                'recipient_area' => $request->area_id,  // From request
                'delivery_type' => 48,  // You can adjust this
                'item_type' => $request->item_type ?? 2,  // Default item type if not set
                'special_instruction' => $request->special_instruction ?? "Please deliver this product on time",
                'item_quantity' => $order->orderItems->sum('quantity'),
                'item_weight' => $request->item_weight,  // From request
                'item_description' => $request->item_description ?? "Please deliver this product on time",
                'amount_to_collect' => (int) $order->total_price,
            ];

            // Make the POST request to Pathao API
            $response = $client->post($apiUrl, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $accessToken,
                    'Content-Type' => 'application/json',
                ],
                'json' => $orderData,
            ]);

            // Parse the response
            $responseData = json_decode($response->getBody()->getContents(), true);

            // Log the Pathao API response
            Log::info('Pathao API Response:', ['response' => $responseData]);

            // Check if the response is successful
            if (isset($responseData['code']) && $responseData['code'] === 200) {
                // Successful order creation response
                return ['status' => 200, 'message' => 'Order placed successfully'];
            } else {
                // Log the error response for troubleshooting
                Log::error('Failed to place order with Pathao', $responseData);
                return ['status' => 500, 'message' => 'Failed to place order with Pathao', 'response' => $responseData];
            }
        } catch (\Exception $e) {
            // If there's an error, log the error and return the error message
            Log::error('Exception occurred while placing order with Pathao', ['error' => $e->getMessage()]);
            return ['status' => 500, 'message' => $e->getMessage()];
        }
    }




    public function getSingleOrder($orderId)
    {
        $order = Order::find($orderId);

        if (!$order) {
            return response()->json(['error' => 'Order not found'], 404);
        }

        $orderItems = OrderItem::where('order_id', $orderId)->get();

        $orderItemsWithProductDetails = $orderItems->map(function ($item) {
            $product = Product::with('images')->find($item->product_id);

            if ($product) {
                $item->product_details = $product;

                $item->product_image = $product->images && $product->images->isNotEmpty()
                    ? asset('storage/' . $product->images->first()->image_path)
                    : null;
            } else {
                $item->product_details = null;
                $item->product_image = null;
            }

            return $item;
        });

        return response()->json([
            'order' => $order,
            'order_items' => $orderItemsWithProductDetails,
        ]);
    }






    public function getOrders($shopId, $userId, $status = null)
    {
        $query = Order::where('shop_id', $shopId)
            ->where('user_id', $userId);

        // If status is provided, filter by status
        if ($status) {
            $query->where('order_status', $status);
        }

        $orders = $query->orderBy('created_at', 'desc')->get();

        return response()->json($orders);
    }



    /**
     * Store a new order (API: POST /api/orders)
     */
    public function store(Request $request)
    {
        // Validate request data
        $validator = Validator::make($request->all(), [
            'user_id'       => 'required',
            'shop_id'       => 'required',

            'name'          => 'required|string|max:255',
            'email'         => 'required|email|max:255',
            'phone'         => 'required|string|max:20',
            'address'       => 'required|string',
            'division'      => 'required|string',
            'district'      => 'required|string',
            'upazila'       => 'required|string',
            'promo_code'    => 'nullable|string',
            'total_price'   => 'required|numeric',
            'delivery_charge' => 'required|numeric',
            'payment_method' => 'required|in:cash_on_delivery,online_payment',
            'cart_items'    => 'required|array',
            'cart_items.*.product_id' => 'required|exists:products,id',
            'cart_items.*.product_name' => 'required|string',
            'cart_items.*.quantity' => 'required|integer|min:1',
            'cart_items.*.price' => 'required|numeric',
            'cart_items.*.size' => 'nullable|string',
            'cart_items.*.color' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        do {
            $randomNumber = rand(100000, 999999);
            $existingOrder = Order::where('order_id', 'BT-' . $randomNumber)->first();
        } while ($existingOrder);

        // Create the order
        $order = Order::create([
            'user_id'        => $request->user_id,
            'shop_id'        => $request->shop_id,
            'name'           => $request->name,
            'email'          => $request->email,
            'phone'          => $request->phone,
            'address'        => $request->address,
            'division'       => $request->division,
            'district'       => $request->district,
            'upazila'        => $request->upazila,
            'promo_code'     => $request->promo_code,
            'total_price'    => $request->total_price,
            'delivery_charge' => $request->delivery_charge,
            'payment_method' => $request->payment_method,
            'order_id'       => 'BT-' . $randomNumber,
            'order_status'   => 'pending',
        ]);

        // Insert each cart item into order_items table
        foreach ($request->cart_items as $item) {
            OrderItem::create([
                'order_id'      => $order->id,
                'product_id'    => $item['product_id'],
                'product_name'  => $item['product_name'],
                'quantity'      => $item['quantity'],
                'price'         => $item['price'],
                'size'          => $item['size'] ?? null,
                'color'         => $item['color'] ?? null,
            ]);
        }

        return response()->json([
            'message' => 'Order placed successfully!',
            'order_id' => $order->id
        ], 201);
    }



    /**
     * Fetch all orders (API: GET /api/orders)
     */
    public function index()
    {
        $orders = Order::with('items')->latest()->get();
        return response()->json($orders);
    }

    /**
     * Fetch a single order (API: GET /api/orders/{id})
     */
    public function show($id)
    {
        $order = Order::with('items')->find($id);

        if (!$order) {
            return response()->json(['error' => 'Order not found'], 404);
        }

        return response()->json($order);
    }

    /**
     * Update order status (API: PUT /api/orders/{id})
     */
    public function update(Request $request, $id)
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json(['error' => 'Order not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'order_status' => 'required|in:pending,processing,shipped,delivered,canceled',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $order->update(['order_status' => $request->order_status]);

        return response()->json(['message' => 'Order status updated successfully']);
    }

    /**
     * Delete an order (API: DELETE /api/orders/{id})
     */
    public function destroy($id)
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json(['error' => 'Order not found'], 404);
        }

        $order->delete();

        return response()->json(['message' => 'Order deleted successfully']);
    }
}
