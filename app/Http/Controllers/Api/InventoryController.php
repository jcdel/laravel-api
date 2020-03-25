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
            'sucess' => true,
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
            'success' => true,
            'inventory' => $inventory
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
        $inventory = Inventory::find($id);

        if(!$inventory)
            return response()->json([
                'success' => false,
                'message'  => 'record not found'
            ], 404);
        
        return response()->json([
            'success' => true,
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
        $inventory = Inventory::find($id);

        if(!$inventory)
            return response()->json([
                'success' => false,
                'message'  => 'record not found',
            ], 404);

        $inventoryData = [
            'item' => $request->item,
            'description' => $request->description,
            'quantity_at_hand' => $request->quantity_at_hand,
            'price' => $request->price,
        ];

        $inventory = $inventory->update($inventoryData);
        
        return response()->json([
            'sucess' => true,
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

        if(!$inventory)
            return response()->json([
                'success' => false,
                'message'  => "record not found",
            ], 404);

        $inventory->delete();

        return response()->json([
            'success' => true,
            'message'  => "The Inventory with the id $inventory->id has successfully been deleted.",
        ], 200);
    }
}
