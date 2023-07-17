<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use Illuminate\Http\Request;
use App\Models\InventoryReport;
use Illuminate\Support\Facades\DB;
use App\Models\BusinessInformation;

class InventoryController extends Controller
{
    public function index()
    {
        $products = Inventory::orderBy('last_added', 'asc')->get();
        foreach($products as $product){
            $product->is_sufficient = $product->available_units > $product->warning_unit;
        }

        return view('dashboard.pages.manager.inventory', [
            'products' => $products,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_name' => 'required | unique:inventories',
            'quantity' => 'required',
            'total_cost' => 'required',
            'measurement_unit' => 'required | in:kg,pcs,ltr',
            'warning_unit' => 'nullable | numeric',
        ]);

        $product = new Inventory();
        $product->product_name = $request->product_name;
        $product->available_units = $request->quantity;
        $product->warning_unit = $request->warning_unit;
        $product->unit_cost = $request->total_cost / $request->quantity;
        $product->total_cost = $request->total_cost;
        $product->measurement_unit = $request->measurement_unit;
        $product->last_added = now();
        $product->save();

        //create a report
        $report = new InventoryReport();
        $report->inventory_id = $product->id;
        $report->quantity = request()->quantity;
        $report->product_name = $product->product_name;
        $report->cost = request()->total_cost;
        $report->measurement_unit = $product->measurement_unit;
        $report->activity = 'added';
        $report->done_manually = Auth()->user()->name;
        $report->save();

        return redirect()->back()->with('success', 'Product added successfully');
    }

    public function update(Request $request){
        $request->validate([
            'product_name' => 'required',
            'measurement_unit' => 'required | in:kg,pcs,ltr',
            'warning_unit' => 'nullable | numeric',
        ]);

        $product = Inventory::find($request->id);
        $product->product_name = $request->product_name;
        $product->warning_unit = $request->warning_unit;
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

        //create a report
        $report = new InventoryReport();
        $report->inventory_id = $product->id;
        $report->quantity = request()->quantity;
        $report->product_name = $product->product_name;
        $report->cost = request()->total_cost;
        $report->measurement_unit = $product->measurement_unit;
        $report->activity = 'added';
        $report->done_manually = Auth()->user()->name;
        $report->save();

        return redirect()->back()->with('success', 'Product added successfully');
    }

    public function subtract(Request $request){
        $request->validate([
            'quantity' => 'required',
        ]);

        $product = Inventory::find($request->id);

        if($product->available_units < $request->quantity){
            return redirect()->back()->with('error', 'You cannot subtract more than available units');
        }

        $product->available_units -= $request->quantity;
        $product->total_cost -= $product->unit_cost * $request->quantity;
        $product->save();

        //create a report
        $report = new InventoryReport();
        $report->inventory_id = $product->id;
        $report->quantity = request()->quantity;
        $report->product_name = $product->product_name;
        $report->cost = $product->unit_cost * request()->quantity;
        $report->measurement_unit = $product->measurement_unit;
        $report->activity = 'subtracted';
        $report->done_manually = Auth()->user()->name;
        $report->save();


        return redirect()->back()->with('success', 'Product subtracted successfully');
    }

    public function destroy($id){
        $product = Inventory::find($id);
        $product->delete();

        return redirect()->back()->with('success', 'Product deleted successfully');
    }

    public function shoppingList(){
        $products = Inventory::where('available_units', '<=', DB::raw('warning_unit'))->get();
        return view('dashboard.pages.manager.shopping_list', [
            'products' => $products,
            'business_details' => BusinessInformation::first(),
        ]);
    }
}
