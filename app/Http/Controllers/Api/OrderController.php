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
    // public function updateStatus(Request $request, $id)
    // {
    //     $validated = $request->validate([
    //         'order_status' => 'required|string|in:pending,processing,shipped,delivered,canceled',
    //     ]);

    //     $order = Order::with('orderItems')->find($id);

    //     if (!$order) {
    //         return response()->json(['message' => 'Order not found'], 404);
    //     }

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

    //     $order->order_status = $validated['order_status'];
    //     $order->save();

    //     Mail::to($order->email)->send(new OrderStatusUpdated($order));

    //     return response()->json([
    //         'message' => 'Order status updated successfully',
    //         'order' => $order
    //     ], 200);
    // }


    public function updateStatus(Request $request, $id)
    {
        // Validate the order status
        $validated = $request->validate([
            'order_status' => 'required|string|in:pending,processing,shipped,delivered,canceled',
            'city_id' => 'required',
            'zone_id' => 'required',
            'area_id' => 'required',
            'item_box' => 'required',
            'item_weight' => 'required',
            'total_price' => 'required',
        ]);

        // Fetch the order and its items
        $order = Order::with('orderItems')->find($id);

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        // Only proceed if the status is 'shipped'
        if ($validated['order_status'] === 'shipped') {
            // Fetch courier credentials from the database
            $courierSetting = CourierSetting::where('user_id', $order->user_id)->first();

            if ($courierSetting) {
                // Step 1: Issue an access token using cURL
                $curl = curl_init();
                curl_setopt_array($curl, [
                    CURLOPT_URL => $courierSetting->base_url . '/aladdin/api/v1/issue-token',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "POST",
                    CURLOPT_POSTFIELDS => json_encode([
                        'client_id' => $courierSetting->client_id,
                        'client_secret' => $courierSetting->client_secret,
                        'grant_type' => 'password',
                        'username' => $courierSetting->username,
                        'password' => $courierSetting->password,
                    ]),
                    CURLOPT_HTTPHEADER => [
                        "Content-Type: application/json"
                    ],
                ]);

                $response = curl_exec($curl);
                $err = curl_error($curl);
                curl_close($curl);

                // Log cURL errors if any
                if ($err) {
                    Log::error('cURL Error:', ['error' => $err]);
                    return response()->json([
                        'error' => 'cURL Error #: ' . $err,
                    ], 500);
                }

                $tokenResponse = json_decode($response, true);

                // Log the access token response
                Log::info('Access Token Response:', ['response' => $tokenResponse]);

                if (isset($tokenResponse['access_token'])) {
                    $accessToken = $tokenResponse['access_token'];
                } else {
                    return response()->json([
                        'error' => 'Failed to get access token',
                        'response' => $response,
                    ], 500);
                }

                // Step 2: Create the order using the access token and Pathao API
                $recipientCity = $validated['city_id'];  // Assuming you have city_id in your order table
                $recipientZone = $validated['zone_id'];  // Assuming you have zone_id in your order table
                $recipientArea = $validated['area_id'];  // Assuming you have area_id in your order table

                // Prepare the data to be sent to Pathao
                $orderData = [
                    'store_id' => $courierSetting->store_id,  // Get from DB
                    'merchant_order_id' => $order->order_id,
                    'recipient_name' => $order->name,
                    'recipient_phone' => $order->phone,
                    'recipient_address' => $order->address,
                    'recipient_city' => $recipientCity,
                    'recipient_zone' => $recipientZone,
                    'recipient_area' => $recipientArea,
                    'delivery_type' => 48,  // Update if necessary
                    'item_type' => 2,  // Update if necessary
                    'special_instruction' => 'Need to deliver before 5 PM',
                    'item_quantity' => $order->orderItems->sum('quantity'),
                    'item_weight' => $validated['item_weight'],  // Can calculate dynamically
                    'item_description' => $validated['item_description'] || "Please Delivery This product on time",
                    // 'amount_to_collect' => $order->total_price + $order->delivery_charge,
                    'amount_to_collect' => $validated['total_price'],
                ];

                // Log the order data being sent to Pathao API
                Log::info('Courier Order Data:', $orderData);

                $orderResponse = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $accessToken,
                ])->post($courierSetting->base_url . '/aladdin/api/v1/orders', $orderData);

                // Log the response from the courier API
                Log::info('Courier API Response:', ['response' => $orderResponse->body()]);

                if ($orderResponse->successful()) {
                    // Update order status to "Shipped" if courier API call is successful
                    $order->update(['order_status' => 'shipped']);
                } else {
                    // Log the error response from the courier API
                    Log::error('Courier API Error:', ['response' => $orderResponse->body()]);
                    return response()->json([
                        'error' => 'Courier API failed. Please try again later.',
                        'response' => $orderResponse->body(),
                        'status_code' => $orderResponse->status(),
                    ], 500);
                }
            } else {
                return response()->json([
                    'error' => 'Courier settings not found for the user.',
                ], 404);
            }
        } else {
            // For other order status updates, just update the order status
            $order->order_status = $validated['order_status'];
            $order->save();
        }

        // Handle the 'delivered' status for product inventory
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

        // Send the updated order status via email
        Mail::to($order->email)->send(new OrderStatusUpdated($order));

        return response()->json([
            'message' => 'Order status updated successfully',
            'order' => $order
        ], 200);
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

    // curiar test api
    // public function store(Request $request)
    // {
    //     // Validate request data
    //     $validator = Validator::make($request->all(), [
    //         'user_id'       => 'required',
    //         'shop_id'       => 'required',
    //         'name'          => 'required|string|max:255',
    //         'email'         => 'required|email|max:255',
    //         'phone'         => 'required|string|max:20',
    //         'address'       => 'required|string',
    //         'division'      => 'required|string',
    //         'district'      => 'required|string',
    //         'upazila'       => 'required|string',
    //         'promo_code'    => 'nullable|string',
    //         'total_price'   => 'required|numeric',
    //         'delivery_charge' => 'required|numeric',
    //         'payment_method' => 'required|in:cash_on_delivery,online_payment',
    //         'cart_items'    => 'required|array',
    //         'cart_items.*.product_id' => 'required|exists:products,id',
    //         'cart_items.*.product_name' => 'required|string',
    //         'cart_items.*.quantity' => 'required|integer|min:1',
    //         'cart_items.*.price' => 'required|numeric',
    //         'cart_items.*.size' => 'nullable|string',
    //         'cart_items.*.color' => 'nullable|string',
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json(['error' => $validator->errors()], 400);
    //     }

    //     // Generate unique order ID
    //     do {
    //         $randomNumber = rand(100000, 999999);
    //         $existingOrder = Order::where('order_id', 'BT-' . $randomNumber)->first();
    //     } while ($existingOrder);

    //     // Create the order
    //     $order = Order::create([
    //         'user_id'        => $request->user_id,
    //         'shop_id'        => $request->shop_id,
    //         'name'           => $request->name,
    //         'email'          => $request->email,
    //         'phone'          => $request->phone,
    //         'address'        => $request->address,
    //         'division'       => $request->division,
    //         'district'       => $request->district,
    //         'upazila'        => $request->upazila,
    //         'promo_code'     => $request->promo_code,
    //         'total_price'    => $request->total_price,
    //         'delivery_charge' => $request->delivery_charge,
    //         'payment_method' => $request->payment_method,
    //         'order_id'       => 'BT-' . $randomNumber,
    //         'order_status'   => 'pending',
    //     ]);

    //     // Insert each cart item into order_items table
    //     foreach ($request->cart_items as $item) {
    //         OrderItem::create([
    //             'order_id'      => $order->id,
    //             'product_id'    => $item['product_id'],
    //             'product_name'  => $item['product_name'],
    //             'quantity'      => $item['quantity'],
    //             'price'         => $item['price'],
    //             'size'          => $item['size'] ?? null,
    //             'color'         => $item['color'] ?? null,
    //         ]);
    //     }

    //     // Fetch courier credentials from the database
    //     $courierSetting = CourierSetting::where('user_id', $request->user_id)->first();

    //     if ($courierSetting) {
    //         // Step 1: Issue an access token
    //         $tokenResponse = Http::asForm()->post('https://courier-api-sandbox.pathao.com/aladdin/api/v1/issue-token', [
    //             'client_id'     => $courierSetting->client_id,  // Get from DB
    //             'client_secret' => $courierSetting->client_secret,  // Get from DB
    //             'username'      => $courierSetting->username,  // Get from DB
    //             'password'      => $courierSetting->password,  // Get from DB
    //             'grant_type'    => 'password',
    //         ]);

    //         if (!$tokenResponse->successful()) {
    //             return response()->json(['error' => 'Failed to get access token'], 500);
    //         }

    //         $accessToken = $tokenResponse->json()['access_token'];  // Get access token from response

    //         // Step 2: Create order using the access token
    //         $response = Http::withHeaders([
    //             'Authorization' => 'Bearer ' . $accessToken,
    //         ])->post('https://courier-api-sandbox.pathao.com/aladdin/api/v1/create-order', [
    //             'order_id'       => $order->order_id,
    //             'address'        => $order->address,
    //             'customer_name'  => $order->name,
    //             'product_details' => $request->cart_items,
    //             'total_price'    => $order->total_price,
    //             'delivery_charge' => $order->delivery_charge,
    //             // Include any additional fields required by Pathao's API
    //         ]);

    //         if ($response->successful()) {
    //             // Update order status to "Shipped" if courier API call is successful
    //             $order->update(['order_status' => 'shipped']);
    //         } else {
    //             return response()->json([
    //                 'error' => 'Courier API failed. Please try again later.',
    //             ], 500);
    //         }
    //     } else {
    //         return response()->json([
    //             'error' => 'Courier settings not found for the user.',
    //         ], 404);
    //     }

    //     return response()->json([
    //         'message' => 'Order placed successfully and sent to courier!',
    //         'order_id' => $order->id
    //     ], 201);
    // }

    // curiar live api

    // public function store(Request $request)
    // {
    //     // Validate request data
    //     $validator = Validator::make($request->all(), [
    //         'user_id'       => 'required',
    //         'shop_id'       => 'required',
    //         'name'          => 'required|string|max:255',
    //         'email'         => 'required|email|max:255',
    //         'phone'         => 'required|string|max:20',
    //         'address'       => 'required|string',
    //         'division'      => 'required|string',
    //         'district'      => 'required|string',
    //         'upazila'       => 'required|string',
    //         'promo_code'    => 'nullable|string',
    //         'total_price'   => 'required|numeric',
    //         'delivery_charge' => 'required|numeric',
    //         'payment_method' => 'required|in:cash_on_delivery,online_payment',
    //         'cart_items'    => 'required|array',
    //         'cart_items.*.product_id' => 'required|exists:products,id',
    //         'cart_items.*.product_name' => 'required|string',
    //         'cart_items.*.quantity' => 'required|integer|min:1',
    //         'cart_items.*.price' => 'required|numeric',
    //         'cart_items.*.size' => 'nullable|string',
    //         'cart_items.*.color' => 'nullable|string',
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json(['error' => $validator->errors()], 400);
    //     }

    //     // Generate unique order ID
    //     do {
    //         $randomNumber = rand(100000, 999999);
    //         $existingOrder = Order::where('order_id', 'BT-' . $randomNumber)->first();
    //     } while ($existingOrder);

    //     // Create the order
    //     $order = Order::create([
    //         'user_id'        => $request->user_id,
    //         'shop_id'        => $request->shop_id,
    //         'name'           => $request->name,
    //         'email'          => $request->email,
    //         'phone'          => $request->phone,
    //         'address'        => $request->address,
    //         'division'       => $request->division,
    //         'district'       => $request->district,
    //         'upazila'        => $request->upazila,
    //         'promo_code'     => $request->promo_code,
    //         'total_price'    => $request->total_price,
    //         'delivery_charge' => $request->delivery_charge,
    //         'payment_method' => $request->payment_method,
    //         'order_id'       => 'BT-' . $randomNumber,
    //         'order_status'   => 'pending',
    //     ]);

    //     // Insert each cart item into order_items table
    //     foreach ($request->cart_items as $item) {
    //         OrderItem::create([
    //             'order_id'      => $order->id,
    //             'product_id'    => $item['product_id'],
    //             'product_name'  => $item['product_name'],
    //             'quantity'      => $item['quantity'],
    //             'price'         => $item['price'],
    //             'size'          => $item['size'] ?? null,
    //             'color'         => $item['color'] ?? null,
    //         ]);
    //     }

    //     // Fetch courier credentials from the database
    //     $courierSetting = CourierSetting::where('user_id', $request->user_id)->first();

    //     if ($courierSetting) {
    //         // Step 1: Issue an access token using cURL
    //         $curl = curl_init();
    //         curl_setopt_array($curl, [
    //             CURLOPT_URL => $courierSetting->base_url . '/aladdin/api/v1/issue-token',
    //             CURLOPT_RETURNTRANSFER => true,
    //             CURLOPT_ENCODING => "",
    //             CURLOPT_MAXREDIRS => 10,
    //             CURLOPT_TIMEOUT => 30,
    //             CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    //             CURLOPT_CUSTOMREQUEST => "POST",
    //             CURLOPT_POSTFIELDS => json_encode([
    //                 'client_id' => $courierSetting->client_id,
    //                 'client_secret' => $courierSetting->client_secret,
    //                 'grant_type' => 'password',
    //                 'username' => $courierSetting->username,
    //                 'password' => $courierSetting->password,
    //             ]),
    //             CURLOPT_HTTPHEADER => [
    //                 "Content-Type: application/json"
    //             ],
    //         ]);

    //         $response = curl_exec($curl);
    //         $err = curl_error($curl);
    //         curl_close($curl);

    //         if ($err) {
    //             return response()->json([
    //                 'error' => 'cURL Error #: ' . $err,
    //             ], 500);
    //         } else {
    //             $tokenResponse = json_decode($response, true);

    //             if (isset($tokenResponse['access_token'])) {
    //                 $accessToken = $tokenResponse['access_token'];
    //             } else {
    //                 return response()->json([
    //                     'error' => 'Failed to get access token',
    //                     'response' => $response,
    //                 ], 500);
    //             }
    //         }

    //         // Step 2: Create order using the access token
    //         $orderResponse = Http::withHeaders([
    //             'Authorization' => 'Bearer ' . $accessToken,
    //         ])->post($courierSetting->base_url . '/aladdin/api/v1/create-order', [
    //             'order_id'       => $order->order_id,
    //             'address'        => $order->address,
    //             'customer_name'  => $order->name,
    //             'product_details' => $request->cart_items,
    //             'total_price'    => $order->total_price,
    //             'delivery_charge' => $order->delivery_charge,
    //         ]);

    //         if ($orderResponse->successful()) {
    //             // Update order status to "Shipped" if courier API call is successful
    //             $order->update(['order_status' => 'shipped']);
    //         } else {
    //             return response()->json([
    //                 'error' => 'Courier API failed. Please try again later.',
    //                 'response' => $orderResponse->body(),
    //                 'status_code' => $orderResponse->status(),
    //             ], 500);
    //         }
    //     } else {
    //         return response()->json([
    //             'error' => 'Courier settings not found for the user.',
    //         ], 404);
    //     }

    //     return response()->json([
    //         'message' => 'Order placed successfully and sent to courier!',
    //         'order_id' => $order->id
    //     ], 201);
    // }


    // public function store(Request $request)
    // {
    //     // Validate request data
    //     $validator = Validator::make($request->all(), [
    //         'user_id'       => 'required',
    //         'shop_id'       => 'required',
    //         'name'          => 'required|string|max:255',
    //         'email'         => 'required|email|max:255',
    //         'phone'         => 'required|string|max:20',
    //         'address'       => 'required|string',
    //         'division'      => 'required|string',
    //         'district'      => 'required|string',
    //         'upazila'       => 'required|string',
    //         'promo_code'    => 'nullable|string',
    //         'total_price'   => 'required|numeric',
    //         'delivery_charge' => 'required|numeric',
    //         'payment_method' => 'required|in:cash_on_delivery,online_payment',
    //         'cart_items'    => 'required|array',
    //         'cart_items.*.product_id' => 'required|exists:products,id',
    //         'cart_items.*.product_name' => 'required|string',
    //         'cart_items.*.quantity' => 'required|integer|min:1',
    //         'cart_items.*.price' => 'required|numeric',
    //         'cart_items.*.size' => 'nullable|string',
    //         'cart_items.*.color' => 'nullable|string',
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json(['error' => $validator->errors()], 400);
    //     }

    //     // Generate unique order ID
    //     do {
    //         $randomNumber = rand(100000, 999999);
    //         $existingOrder = Order::where('order_id', 'BT-' . $randomNumber)->first();
    //     } while ($existingOrder);

    //     // Create the order
    //     $order = Order::create([
    //         'user_id'        => $request->user_id,
    //         'shop_id'        => $request->shop_id,
    //         'name'           => $request->name,
    //         'email'          => $request->email,
    //         'phone'          => $request->phone,
    //         'address'        => $request->address,
    //         'division'       => $request->division,
    //         'district'       => $request->district,
    //         'upazila'        => $request->upazila,
    //         'promo_code'     => $request->promo_code,
    //         'total_price'    => $request->total_price,
    //         'delivery_charge' => $request->delivery_charge,
    //         'payment_method' => $request->payment_method,
    //         'order_id'       => 'BT-' . $randomNumber,
    //         'order_status'   => 'pending',
    //     ]);

    //     // Insert each cart item into order_items table
    //     foreach ($request->cart_items as $item) {
    //         OrderItem::create([
    //             'order_id'      => $order->id,
    //             'product_id'    => $item['product_id'],
    //             'product_name'  => $item['product_name'],
    //             'quantity'      => $item['quantity'],
    //             'price'         => $item['price'],
    //             'size'          => $item['size'] ?? null,
    //             'color'         => $item['color'] ?? null,
    //         ]);
    //     }

    //     // Fetch courier credentials from the database
    //     $courierSetting = CourierSetting::where('user_id', $request->user_id)->first();

    //     if ($courierSetting) {
    //         // Step 1: Issue an access token using cURL
    //         $curl = curl_init();
    //         curl_setopt_array($curl, [
    //             CURLOPT_URL => $courierSetting->base_url . '/aladdin/api/v1/issue-token',
    //             CURLOPT_RETURNTRANSFER => true,
    //             CURLOPT_ENCODING => "",
    //             CURLOPT_MAXREDIRS => 10,
    //             CURLOPT_TIMEOUT => 30,
    //             CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    //             CURLOPT_CUSTOMREQUEST => "POST",
    //             CURLOPT_POSTFIELDS => json_encode([
    //                 'client_id' => $courierSetting->client_id,
    //                 'client_secret' => $courierSetting->client_secret,
    //                 'grant_type' => 'password',
    //                 'username' => $courierSetting->username,
    //                 'password' => $courierSetting->password,
    //             ]),
    //             CURLOPT_HTTPHEADER => [
    //                 "Content-Type: application/json"
    //             ],
    //         ]);

    //         $response = curl_exec($curl);
    //         $err = curl_error($curl);
    //         curl_close($curl);

    //         if ($err) {
    //             return response()->json([
    //                 'error' => 'cURL Error #: ' . $err,
    //             ], 500);
    //         } else {
    //             $tokenResponse = json_decode($response, true);

    //             if (isset($tokenResponse['access_token'])) {
    //                 $accessToken = $tokenResponse['access_token'];
    //             } else {
    //                 return response()->json([
    //                     'error' => 'Failed to get access token',
    //                     'response' => $response,
    //                 ], 500);
    //             }
    //         }

    //         // Step 2: Create order using the access token and Pathao API

    //         $orderResponse = Http::withHeaders([
    //             'Authorization' => 'Bearer ' . $accessToken,
    //         ])->post($courierSetting->base_url . '/aladdin/api/v1/orders', [
    //             'store_id' => $courierSetting->merchant_store_id,  // Get from DB
    //             'merchant_order_id' => $order->order_id,
    //             'recipient_name' => $order->name,
    //             'recipient_phone' => $order->phone,
    //             'recipient_address' => $order->address,
    //             'recipient_city' => $courierSetting->city_id,  // Get from DB
    //             'recipient_zone' => $courierSetting->zone_id,  // Get from DB
    //             'recipient_area' => $courierSetting->area_id,  // Get from DB
    //             'delivery_type' => 48,  // You can update this if necessary
    //             'item_type' => 2,  // You can update this if necessary
    //             'special_instruction' => 'Need to Delivery before 5 PM',
    //             'item_quantity' => count($request->cart_items),
    //             'item_weight' => "0.5",  // You can calculate weight dynamically if needed
    //             'item_description' => "this is a Cloth item, price- " . $order->total_price,
    //             'amount_to_collect' => $order->total_price + $order->delivery_charge,
    //         ]);

    //         if ($orderResponse->successful()) {
    //             // Update order status to "Shipped" if courier API call is successful
    //             $order->update(['order_status' => 'shipped']);
    //         } else {
    //             return response()->json([
    //                 'error' => 'Courier API failed. Please try again later.',
    //                 'response' => $orderResponse->body(),
    //                 'status_code' => $orderResponse->status(),
    //             ], 500);
    //         }
    //     } else {
    //         return response()->json([
    //             'error' => 'Courier settings not found for the user.',
    //         ], 404);
    //     }

    //     return response()->json([
    //         'message' => 'Order placed successfully and sent to courier!',
    //         'order_id' => $order->id
    //     ], 201);
    // }





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
