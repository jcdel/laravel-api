<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Order;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::all();

        return response()->json([
            'error' => false,
            'orders'  => $orders,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\OrderRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OrderRequest $request)
    {
        $inventory = Order::create($request->all());

        return response()->json([
            'error' => false,
            'order'  => $order,
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = Order::find($id);
        
        return response()->json([
            'error' => false,
            'order'  => $orders,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\OrderRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(OrderRequest $request, $id)
    {
        $order = Order::find($id);

        $order->order_notes = $request->input('order_notes');

        $order->save();
        
        return response()->json([
            'error' => false,
            'order'  => $order,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $orders = Order::find($id);
        $orders->delete();

        return response()->json([
            'error' => false,
            'message'  => "The Order with the id $orders->id has successfully been deleted.",
        ], 200);
    }
}
