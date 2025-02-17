<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{


    public function getOrders($shopId, $userId)
    {
        $orders = Order::where('shop_id', $shopId)
                       ->where('user_id', $userId)
                       ->get();

        return response()->json($orders);
    }



    /**
     * Store a new order (API: POST /api/orders)
     */
    public function store(Request $request)
    {
        // Validate request data
        $validator = Validator::make($request->all(), [
            'user_id'       =>'required',
            'shop_id'       =>'required',

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
            'payment_method'=> 'required|in:cash_on_delivery,online_payment',
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

        // Create the order
        $order = Order::create([
            'user_id'        => $request->user_id,  // Optional: if logged in
            'shop_id'        => $request->shop_id,  // Optional: if logged in
            'name'           => $request->name,
            'email'          => $request->email,
            'phone'          => $request->phone,
            'address'        => $request->address,
            'division'       => $request->division,
            'district'       => $request->district,
            'upazila'        => $request->upazila,
            'promo_code'     => $request->promo_code,
            'total_price'    => $request->total_price,
            'delivery_charge'=> $request->delivery_charge,
            'payment_method' => $request->payment_method,
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
