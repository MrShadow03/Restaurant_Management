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
            'product_name' => 'required | unique:inventories',
            'quantity' => 'required',
            'total_cost' => 'required',
            'measurement_unit' => 'required | in:kg,pcs,ltr',
        ]);



        $product = new Inventory();
        $product->product_name = $request->product_name;
        $product->available_units = $request->quantity;
        $product->unit_cost = $request->total_cost / $request->quantity;
        $product->total_cost = $request->total_cost;
        $product->measurement_unit = $request->measurement_unit;
        $product->last_added = now();
        $product->save();

        return redirect()->back()->with('success', 'Product added successfully');
    }

    public function update(Request $request){
        $request->validate([
            'product_name' => 'required',
            'measurement_unit' => 'required | in:kg,pcs,ltr',
        ]);

        $product = Inventory::find($request->id);
        $product->product_name = $request->product_name;
        $product->measurement_unit = $request->measurement_unit;
        $product->save();

        return redirect()->back()->with('success', 'Product updated successfully');
    }

    public function add(Request $request){
        $request->validate([
            'quantity' => 'required',
            'total_cost' => 'required',
        ]);

        $product = Inventory::find($request->id);
        $product->available_units += $request->quantity;
        $product->unit_cost = ($product->total_cost + $request->total_cost) / $product->available_units;
        $product->total_cost += $request->total_cost;
        $product->last_added = now();
        $product->save();

        return redirect()->back()->with('success', 'Product added successfully');
    }

    public function subtract(Request $request){
        $request->validate([
            'quantity' => 'required',
        ]);

        $product = Inventory::find($request->id);
        $product->available_units -= $request->quantity;
        $product->total_cost -= $product->unit_cost * $request->quantity;
        $product->save();

        return redirect()->back()->with('success', 'Product subtracted successfully');
    }

    public function destroy($id){
        $product = Inventory::find($id);
        $product->delete();

        return redirect()->back()->with('success', 'Product deleted successfully');
    }
}
