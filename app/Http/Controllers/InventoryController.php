<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index()
    {
        return view('dashboard.pages.manager.inventory', [
            'products' => Inventory::all(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_name' => 'required',
            'quantity' => 'required',
            'unit_cost' => 'required',
            'measurement_unit' => 'required | in:kg,pcs,ltr',
        ]);



        $product = new Inventory();
        $product->product_name = $request->product_name;
        $product->available_units = $request->quantity;
        $product->unit_cost = $request->unit_cost;
        $product->total_cost = $request->quantity * $request->unit_cost;
        $product->measurement_unit = $request->measurement_unit;
        $product->last_added = now();
        $product->save();

        return redirect()->back()->with('success', 'Product added successfully');
    }
}
