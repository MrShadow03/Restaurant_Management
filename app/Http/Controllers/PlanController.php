<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Recipe;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    public function index()
    {
        return view('dashboard.pages.manager.menu_planner', [
            'recipes' => Recipe::all(),
        ]);
    }

    public function getMenu(Request $request){
        $menu = Recipe::all();

        $menu = $menu->map(function($item){
            $item->orderCount = 0;
            return $item;
        });
        
        return response()->json($menu);
    }
}
