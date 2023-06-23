<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Recipe;
use Illuminate\Http\Request;

class KitchenStaffPlanController extends Controller
{
    public function index()
    {
        $menu = Recipe::with('plans')->get();
        $plans = Plan::with('recipe')->get();

        return view('dashboard.pages.kitchen_staff.menu_planner', [
            'plans' => $plans,
        ]);
    }
}
