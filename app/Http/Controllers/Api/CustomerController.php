<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerRequest;
use App\Http\Requests\OrderRequest;
use App\Customer;
use Carbon\Carbon;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = Customer::all();

        return response()->json([
            'error' => false,
            'customers' => $customers
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\CustomerRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CustomerRequest $request)
    {
        $customer = Customer::create($request->all());

        return response()->json([
            'error' => false,
            'customer' => $customer
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $customer = Customer::with('orders', 'orders.details')->find($id);
        
        if(!$customer)
            return response()->json([
                'success' => false,
                'message' => 'record not found'
            ], 404);

        return response()->json([
            'success' => true,
            'customer' => $customer
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\CustomerRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CustomerRequest $request, $id)
    {
        $customer = Customer::find($id);

        if(!$customer)
            return response()->json([
                'success' => false,
                'message' => 'record not found'
            ], 404);

        $customerData = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'address' => $request->address,
        ];

        $customer->update($customerData);

        return response()->json([
            'success' => true,
            'customer' => $customer
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
        $customer = Customer::find($id);

        if(!$customer)
            return response()->json([
                'success' => false,
                'message'  => "record not found",
            ], 404);

        $customer->delete();

        return response()->json([
            'success' => true,
            'message'  => "The customer with the id $customer->id has been successfully deleted.",
        ], 200);
    }

    /**
     * Create Order
     *
     * @param  \App\Http\Requests\OrderRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function order(OrderRequest $request, $id)
    {
        $customer = Customer::find($id);
        
        if(!$cutomer)
            return response()->json([
                'success' => false,
                'message'  => 'record not found',
            ], 404);

        $order = $customer->orders()->create([
            'order_date' => Carbon::now(),
            'order_notes' => $request->order_notes,
        ]);
        
        $items = $request->input('items');

        foreach($items as $item){
            $order->details()->create([
                'inventory_id' => $item['inventory_id'],
                'quantity' => $item['quantity'],
            ]);
        }
        
        return response()->json([
            'success' => true,
            'order'  => $order,
        ], 200);
    }
}
