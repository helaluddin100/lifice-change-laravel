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
        $validated = $request->validate([
            'order_status' => 'required|string|in:pending,processing,shipped,delivered,canceled',
            'courier_type' => 'required',

        ]);

        $order = Order::with('orderItems')->find($id);
        $courierSetting = CourierSetting::where('user_id', $order->user_id)
            ->where('courier_id', $validated['courier_type'])
            ->first();
        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
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
        if ($validated['courier_type'] == 2) {
            $response = $this->sendOrderToSteadfast($order, $request, $courierSetting);
            if ($response['status'] !== 200) {
                return response()->json(['message' => 'Failed to place order with Steadfast'], 500);
            }
        }

        // Update order status
        $order->order_status = $validated['order_status'];
        $order->save();

        // Send email notification about the status update
        Mail::to($order->email)->send(new OrderStatusUpdated($order));

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
            'note' => 'Delivery within 3 PM',
            'item_weight' => '2',  // Assuming item weight is fixed, you can modify it
            'item_description' => "Order ID: {$order->order_id}, Total Price: {$order->total_price}",
        ];

        // Make the POST request to Steadfast API
        $client = new \GuzzleHttp\Client();
        try {
            $response = $client->post($apiUrl, [
                'headers' => [
                    'Api-Key' => $apiKey,
                    'Secret-Key' => $secretKey,
                    'Content-Type' => 'application/json',
                ],
                'json' => $data,
            ]);

            // Parse the response
            $responseData = json_decode($response->getBody()->getContents(), true);
            return $responseData;
        } catch (\Exception $e) {
            // If there's an error, return the error message
            return ['status' => 500, 'message' => $e->getMessage()];
        }
    }

    // public function updateStatus(Request $request, $id)
    // {
    //     // Validate the order status
    //     $validated = $request->validate([
    //         'order_status' => 'required|string|in:pending,processing,shipped,delivered,canceled',
    //         'total_price' => 'required',
    //         'courier_type' => 'required',

    //         // Conditional validation: Apply validation for courier_type == 1
    //         'city_id' => $request->courier_type == 1 ? 'required' : 'nullable',
    //         'zone_id' => $request->courier_type == 1 ? 'required' : 'nullable',
    //         'area_id' => $request->courier_type == 1 ? 'required' : 'nullable',
    //         'item_weight' => $request->courier_type == 1 ? 'required' : 'nullable',
    //         'item_description' => $request->courier_type == 1 ? 'required' : 'nullable',
    //         'special_instruction' => $request->courier_type == 1 ? 'required' : 'nullable',
    //         'item_type' => 'nullable', // This field is always nullable
    //     ]);


    //     // Fetch the order and its items
    //     $order = Order::with('orderItems')->find($id);

    //     if (!$order) {
    //         return response()->json(['message' => 'Order not found'], 404);
    //     }

    //     // Only proceed if the status is 'shipped'
    //     if ($validated['courier_type'] == 1 && $validated['order_status'] == 'shipped') {
    //         // Fetch courier credentials from the database
    //         $courierSetting = CourierSetting::where('user_id', $order->user_id)->first();
    //         $base_url = 'https://api-hermes.pathao.com';
    //         if ($courierSetting) {
    //             // Step 1: Issue an access token using cURL
    //             $curl = curl_init();
    //             curl_setopt_array($curl, [
    //                 CURLOPT_URL => $base_url . '/aladdin/api/v1/issue-token',
    //                 CURLOPT_RETURNTRANSFER => true,
    //                 CURLOPT_ENCODING => "",
    //                 CURLOPT_MAXREDIRS => 10,
    //                 CURLOPT_TIMEOUT => 30,
    //                 CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    //                 CURLOPT_CUSTOMREQUEST => "POST",
    //                 CURLOPT_POSTFIELDS => json_encode([
    //                     'client_id' => $courierSetting->client_id,
    //                     'client_secret' => $courierSetting->client_secret,
    //                     'grant_type' => 'password',
    //                     'username' => $courierSetting->username,
    //                     'password' => $courierSetting->password,
    //                 ]),
    //                 CURLOPT_HTTPHEADER => [
    //                     "Content-Type: application/json"
    //                 ],
    //             ]);

    //             $response = curl_exec($curl);
    //             $err = curl_error($curl);
    //             curl_close($curl);

    //             // Log cURL errors if any
    //             if ($err) {
    //                 Log::error('cURL Error:', ['error' => $err]);
    //                 return response()->json([
    //                     'error' => 'cURL Error #: ' . $err,
    //                 ], 500);
    //             }

    //             $tokenResponse = json_decode($response, true);

    //             // Log the access token response
    //             Log::info('Access Token Response:', ['response' => $tokenResponse]);

    //             if (isset($tokenResponse['access_token'])) {
    //                 $accessToken = $tokenResponse['access_token'];
    //             } else {
    //                 return response()->json([
    //                     'error' => 'Failed to get access token',
    //                     'response' => $response,
    //                 ], 500);
    //             }

    //             $recipientCity = $validated['city_id'];
    //             $recipientZone = $validated['zone_id'];
    //             $recipientArea = $validated['area_id'];

    //             // Prepare the data to be sent to Pathao
    //             $orderData = [
    //                 'store_id' => $courierSetting->store_id,
    //                 'merchant_order_id' => $order->order_id,
    //                 'recipient_name' => $order->name,
    //                 'recipient_phone' => $order->phone,
    //                 'recipient_address' => $order->address,
    //                 'recipient_city' => $recipientCity,
    //                 'recipient_zone' => $recipientZone,
    //                 'recipient_area' => $recipientArea,
    //                 'delivery_type' => 48,
    //                 'item_type' => $validated['item_type'] ?? 2,
    //                 'special_instruction' => $validated['special_instruction'] ?? "Please Delivery This product on time",
    //                 'item_quantity' => $order->orderItems->sum('quantity'),
    //                 'item_weight' => $validated['item_weight'],
    //                 'item_description' => $validated['item_description'] ?? "Please Delivery This product on time",
    //                 'amount_to_collect' => (int) $order->total_price,
    //                 // 'amount_to_collect' => (int) $validated['total_price'],
    //             ];

    //             // Log the order data being sent to Pathao API
    //             Log::info('Courier Order Data:', $orderData);

    //             $orderResponse = Http::withHeaders([
    //                 'Authorization' => 'Bearer ' . $accessToken,
    //             ])->post($base_url . '/aladdin/api/v1/orders', $orderData);

    //             // Log the response from the courier API
    //             Log::info('Courier API Response:', ['response' => $orderResponse->body()]);

    //             if ($orderResponse->successful()) {
    //                 // Update order status to "Shipped" if courier API call is successful
    //                 $order->update(['order_status' => 'shipped']);
    //             } else {
    //                 // Log the error response from the courier API
    //                 Log::error('Courier API Error:', ['response' => $orderResponse->body()]);
    //                 return response()->json([
    //                     'error' => 'Courier API failed. Please try again later.',
    //                     'response' => $orderResponse->body(),
    //                     'status_code' => $orderResponse->status(),
    //                 ], 500);
    //             }
    //         } else {
    //             return response()->json([
    //                 'error' => 'Courier settings not found for the user.',
    //             ], 404);
    //         }
    //     } else {
    //         // For other order status updates, just update the order status
    //         $order->order_status = $validated['order_status'];
    //         $order->save();
    //     }

    //     // Handle the 'delivered' status for product inventory
    //     if ($order->order_status !== 'delivered' && $validated['order_status'] === 'delivered') {
    //         foreach ($order->orderItems as $item) {
    //             $product = Product::find($item->product_id);
    //             if ($product) {
    //                 $product->quantity = max(0, $product->quantity - $item->quantity);
    //                 $product->sold_count = $product->sold_count + $item->quantity;
    //                 $product->save();
    //             }
    //         }
    //     }

    //     // Send the updated order status via email
    //     Mail::to($order->email)->send(new OrderStatusUpdated($order));

    //     return response()->json([
    //         'message' => 'Order status updated successfully',
    //         'order' => $order
    //     ], 200);
    // }





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
