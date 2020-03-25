<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\InventoryRequest;
use App\Inventory;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $inventories = Inventory::all();

        return response()->json([
            'error' => false,
            'inventories' => $inventories
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\InventoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(InventoryRequest $request)
    {
        $inventory = Inventory::create($request->all());

        return response()->json([
            'error' => false,
            'inventory' => $inventory
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
        $inventory = Inventory::find($id);
        
        return response()->json([
            'error' => false,
            'inventory'  => $inventory
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\InventoryRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(InventoryRequest $request, $id)
    {
        $inventoryData = [
            'item' => $request->input('item'),
            'description' => $request->input('description'),
            'quantity_at_hand' => $request->input('quantity_at_hand'),
            'price' => $request->input('price'),

        ];

        $inventory = Inventory::where('id', $id)->update($inventoryData);
        
        return response()->json([
            'error' => false,
            'inventory'  => $inventory,
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
        $inventory = Inventory::find($id);
        $inventory->delete();

        return response()->json([
            'error' => false,
            'message'  => "The Inventory with the id $inventory->id has successfully been deleted.",
        ], 200);
    }
}
