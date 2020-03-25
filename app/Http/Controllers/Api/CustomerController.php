<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $customer = Customer::create($request->all());

        return response()->json([
            'error' => false,
            'customer' => $customer
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
        $customer = Customer::with('orders', 'orders.details')->find($id);

        return response()->json([
            'error' => false,
            'customer' => $customer
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $customerData = [
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'address' => $request->input('address'),
        ];

        $customer = Customer::where('id', $id)->update($customerData);
        
        return response()->json([
            'error' => false,
            'customer'  => $customer,
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
        $customer->delete();

        return response()->json([
            'error' => false,
            'message'  => "The customer with the id $customer->id has been successfully deleted.",
        ], 200);
    }

    public function order(Request $request, $id){
        $customer = Customer::find($id);

        $order = $customer->orders()->create([
            'order_date' => Carbon::now(),
            'order_notes' => $request->input('order_notes'),
        ]);
        
        $items = $request->input('items');

        foreach($items as $item){
            $order->details()->create([
                'inventory_id' => $item['inventory_id'],
                'quantity' => $item['quantity'],
            ]);
        }
        
        return response()->json([
            'error' => false,
            'order'  => $order,
        ], 200);
    }
}
