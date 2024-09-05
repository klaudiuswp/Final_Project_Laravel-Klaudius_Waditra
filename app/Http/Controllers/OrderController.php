<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Kategori;
use App\Models\Order;
use App\Models\Produk;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;

class OrderController extends Controller
{
    public function report()
    {
        $orders = Order::with(['user', 'produk'])->get();

        $total_orders = count($orders);
        $total_revenue = 0;
        $orders_formatted = [];
        foreach ($orders as $order) {
            array_push($orders_formatted, [
                'id' => $order->id,
                'product_name' => $order->produk->name,
                'category_name' => Kategori::find($order->produk->kategori_id)->name,
                'quantity' => $order->quantity,
                'total_price' => $order->total_price,
                'customer_name' => $order->user->name,
                'order_date' => $order->order_date,
            ]);

            $total_revenue += $order->total_price;
        };

        return response()->json([
            'status' => 'success',
            'message' => 'Order report generated successfully',
            'data' => [
                'total_orders' => $total_orders,
                'total_revenue' => $total_revenue,
                'orders' => $orders_formatted,
                // 'orders' => $orders,
            ]
        ], 200);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::guard('api')->user();

        $orders = Order::where('user_id', $user->id)
            ->with(['user', 'produk'])
            ->get();

        $formatted_order = [];
        foreach ($orders as $order) {
            array_push($formatted_order, [
                'id' => $order->id,
                'product_id' => $order->produk->id,
                'quantity' => $order->quantity,
                'total_price' => $order->total_price,
                'customer_name' => $order->user->name,
                'customer_address' => $order->user->address,
                'created_at' => $order->created_at,
                'updated_at' => $order->updated_at,
            ]);
        };

        return response()->json([
            'status' => 'success',
            'message' => 'Orders retrieved successfully',
            'data' => $formatted_order,
            // [
            //     'id' => $orders
            // ]
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderRequest $request)
    {
        $validator = Validator::make($request->all(), [
            'produk_id' => 'required|integer|min:1|exists:produk,id',
            'quantity' => 'required|min:1|integer'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $total_price = Produk::find($request->produk_id)->price * $request->quantity;

        $user = Auth::user();

        $order = Order::create([
            'user_id' => $user->id,
            'produk_id' => $request->produk_id,
            'quantity' => $request->quantity,
            'total_price' => $total_price,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Order created successfully',
            'data' => [
                'id' => $order->id,
                'product_id' => $order->produk_id,
                'quantity' => $order->quantity,
                'total_price' => $order->total_price,
                'customer_name' => $user->name,
                'customer_address' => $user->address,
                'created_at' => $order->created_at,
                'updated_at' => $order->updated_at,
            ]
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderRequest $request, $id)
    {
        $order = Order::find($id);
        if (!$order) {
            return response()->json(['message' => 'Order not found.'], 400);
        }
        $validator = Validator::make($request->all(), [
            'produk_id' => 'required|integer|min:1|exists:produk,id',
            'quantity' => 'required|min:1|integer'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $total_price = Produk::find($request->produk_id)->price * $request->quantity;

        $user = Auth::user();

        $order->update([
            'user_id' => $user->id,
            'produk_id' => $request->produk_id,
            'quantity' => $request->quantity,
            'total_price' => $total_price,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Order updated successfully',
            'data' => [
                'id' => $order->id,
                'product_id' => $order->produk_id,
                'quantity' => $order->quantity,
                'total_price' => $order->total_price,
                'customer_name' => $user->name,
                'customer_address' => $user->address,
                'created_at' => $order->created_at,
                'updated_at' => $order->updated_at
            ]
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $order = Order::find($id);
        if (!$order) {
            return response()->json([
                'status' => 'Gagal',
                'message' => 'Order not found'
            ], 400);
        }
        $order->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Order deleted successfully'
        ], 200);
    }
}
