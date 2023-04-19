<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Table;
use Illuminate\Http\Request;

class KitchenStaffOrderController extends Controller
{
    public function index(){
        $tables = Table::with(['orders.recipe','oldestOrder'])->get();
        return view('dashboard.pages.kitchen_staff.orders', [
            'tables' => $tables,
        ]);
    }

    public function changeStatus(Request $request){
        $order = Order::find($request->order_id);
        $order->status = $request->status;
        $order->save();

        return response()->json([
            'message' => 'success',
            'order_id' => $request->order_id,
            'table_id' => $order->table_id,
            'recipe_id' => $order->recipe_id,
            'status' => $request->status
        ]);
    }
}
