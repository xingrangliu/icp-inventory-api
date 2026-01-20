<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Http\Resources\OrderResource;



class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
public function index()
{
    $orders = Order::with('orderItems.product')->paginate(10);
    return OrderResource::collection($orders);
}

    /**
     * Store a newly created resource in storage.
     */
public function store(Request $request)
{
    $data = $request->validate([
        'user_id' => 'required|exists:users,id',
        'items' => 'required|array|min:1',
        'items.*.product_id' => 'required|exists:products,id',
        'items.*.quantity' => 'required|integer|min:1',
    ]);

    try {
        $order = DB::transaction(function() use ($data) {
            // Create order
            $order = Order::create([
                'user_id' => $data['user_id'],
                'status' => 'Pending',
            ]);

            foreach($data['items'] as $item){
                $product = Product::lockForUpdate()->findOrFail($item['product_id']);

                if ($product->stock_quantity < $item['quantity']){
                    throw new \Exception("Insufficient stock for {$product->name}");
                }

                $product->stock_quantity -= $item['quantity'];
                $product->save();

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'price' => $product->price,
                ]);
            }

            $order->status = 'Completed';
            $order->save();

            // Always return order from transaction
            return $order;
        });

        // $order is guaranteed to be an object here
        return new OrderResource($order->load('orderItems.product'));

    } catch (\Exception $e) {
        return response()->json([
            'message' => $e->getMessage()
        ], 400);
    }
}

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
        $order->load('items.product');
        return new OrderResource($order);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
            $data = $request->validate([
        'status' => 'required|in:Pending,Completed,Cancelled',
        ]);

         $order->status = $data['status'];
         $order->save();

    return new OrderResource($order->load('orderItems.product'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
        $order->delete();
        return response()->json(['message'=>'Order deleted']);
    }
}
