<?php

namespace App\Http\Controllers\Api;

use App\Models\Order;

use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Mail\OrderStatusUpdated;
use App\Models\Shop;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

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
        ]);

        $order = Order::find($id);

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        // Check if the status is changing to "delivered"
        if ($order->order_status !== 'delivered' && $validated['order_status'] === 'delivered') {
            foreach ($order->orderItems as $item) {
                $product = Product::find($item->product_id);
                if ($product) {
                    $product->quantity -= $item->quantity;
                    $product->save();
                }
            }
        }

        $order->order_status = $validated['order_status'];
        $order->save();

        Mail::to($order->email)->send(new OrderStatusUpdated($order));

        return response()->json(['message' => 'Order status updated successfully', 'order' => $order], 200);
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