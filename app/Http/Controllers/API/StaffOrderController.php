<?php

namespace App\Http\Controllers\API;

use App\Models\Order;
use App\Models\Table;
use App\Models\Recipe;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StaffOrderController extends Controller
{
    public function getMenu(Request $request){
        $menu = Recipe::where('on_menu', 1)->get();
        $table_id = $request->table_id;

        $menu = $menu->map(function($item) use ($table_id){
            $item->orderCount = Order::where('recipe_id', $item->id)->where('table_id', $table_id)->sum('quantity');
            return $item;
        });
        
        return response()->json($menu);
    }

    public function storeOrder(Request $request){
        $alreadyOrdered = Order::where('table_id', $request->table_id)
            ->where('recipe_id', $request->recipe_id)
            ->first();

        if($alreadyOrdered && request()->quantity == 0){
            $alreadyOrdered->delete();

            return response()->json([
                'message' => 'deleted',
                'recipe_id' => $request->recipe_id,
                'table_id' => $request->table_id
            ]);
        }
        
        //if only quantity is 0 then return
        if(request()->quantity == 0){
            return response()->json([
                'message' => 'empty',
                'recipe_id' => $request->recipe_id,
                'table_id' => $request->table_id
            ]);
        }

        Order::updateOrCreate(
            [
                'table_id' => $request->table_id,
                'recipe_id' => $request->recipe_id,
            ],
            [
                'quantity' => $request->quantity,
                'user_id' => auth()->user()->id,
            ]
        );

        return response()->json([
            'message' => 'done',
            'recipe_id' => $request->recipe_id,
            'table_id' => $request->table_id
        ]);
    }

    public function getOrders(Request $request){
        $orders = Order::where('table_id', $request->table_id)->get();

        //if there is no order then make the table status free
        if($orders->count() == 0){
            $table = Table::find($request->table_id);
            $table->status = 'free';
            $table->save();
        }else{
            $table = Table::find($request->table_id);
            $table->status = 'occupied';
            $table->save();
        }

        $orders = $orders->map(function($item){
            $item->recipe_name = $item->recipe->recipe_name;
            $item->price = $item->recipe->price;
            $item->total_price = $item->recipe->price * $item->quantity;
            return $item;
        });

        return response()->json(['orders' => $orders]);
    }
}
