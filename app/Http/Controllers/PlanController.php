<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Plan;
use App\Models\Order;
use App\Models\Recipe;
use App\Models\Inventory;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    public function index()
    {
        $menu = Recipe::with('plans')->get();
        $plans = Plan::with('recipe')->get();

        return view('dashboard.pages.manager.menu_planner', [
            'recipes' => $menu,
            'plans' => $plans,
        ]);
    }

    public function store(Request $request){
        $recipe_id = $request->recipe_id;
        $quantity = $request->quantity; //20
        $date = $request->day == 'today' ? date('Y-m-d') : Carbon::now()->addDay()->format('Y-m-d');

        //check if the recipe is already in the plan
        $plan = Plan::where('recipe_id', $recipe_id)->where('date', $date)->first();
        if($plan){
            $plan_quantity = $plan->quantity; //10
            $requested_more = $quantity > $plan_quantity ? true : false; //true
            $difference = abs($quantity - $plan_quantity); //10

            //if the requested quantity is less than the existing quantity then update the plan and inventory
            if(!$requested_more){ //false
                //if requested quantity is 0 then delete the plan
                if($quantity == 0){
                    $plan->delete();

                    $this->updateInventory($recipe_id, $difference, false);

                    return response()->json([
                        'status' => 'warning',
                        'message' => 'Plan is deleted.',
                        'data' => $plan,
                    ]);
                }else{
                    $plan->quantity = $quantity;
                    $plan->save();

                    $this->updateInventory($recipe_id, $difference, false);

                    return response()->json([
                        'status' => 'success',
                        'message' => 'The plan is updated.',
                        'data' => $plan,
                    ]);
                }
            }

            //if the requested quantity is more than the existing quantity then check if the ingredients are available in the inventory
            $stock_availability = $this->checkStockAvailability($recipe_id, $difference);

            //if all the ingredients are not available in the inventory
            if($stock_availability['status'] === 'error'){
                return response()->json($stock_availability);
            }

            //update the plan and inventory
            $plan->quantity = $quantity;
            $plan->save();

            $this->updateInventory($recipe_id, $difference);

            return response()->json([
                'status' => 'success',
                'message' => 'The plan is updated.',
                'data' => $plan,
            ]);

        }else{
            if($quantity == 0){
                return response()->json([
                    'status' => 'error',
                    'message' => 'Please select a quantity greater than 0.',
                ]);
            }
        }

        //check if all the ingredients are available in the inventory
        $stock_availability = $this->checkStockAvailability($recipe_id, $quantity);

        //if all the ingredients are not available in the inventory
        if($stock_availability['status'] === 'error'){
            return response()->json($stock_availability);
        }

        //if all the ingredients are available in the inventory then update or create the plan
        $plan = Plan::updateOrCreate(
            ['recipe_id' => $recipe_id, 'date' => $date],
            ['quantity' => $quantity]
        );

        //update the inventory
        $this->updateInventory($recipe_id, $quantity);

        return response()->json([
            'status' => 'success',
            'message' => 'The plan is created.',
            'data' => $plan,
        ]);
    }

    public function getPlanCount(Request $request){
        $date = $request->day == 'today' ? date('Y-m-d') : Carbon::now()->addDay()->format('Y-m-d');

        $plan = Plan::where('date', $date)->get(['recipe_id', 'quantity']);

        return response()->json($plan);
    }

    protected function checkStockAvailability($recipe_id, $recipe_quantity){
        $recipe = Recipe::find($recipe_id);
        $ingredients = $recipe->inventories;

        $availability = true;
        $unavailable_ingredients = [];

        foreach ($ingredients as $ingredient){
            $inventory = Inventory::find($ingredient->id);
            $inventory_quantity = $inventory->available_units;
            $required_quantity = $ingredient->pivot->quantity * $recipe_quantity;

            if($inventory_quantity < $required_quantity){
                $availability = false;
                $unavailable_ingredients[$inventory->product_name] = [
                    'id' => $inventory->id,
                    'name' => $inventory->product_name,
                    'requiredQuantity' => $required_quantity.' '.$inventory->measurement_unit,
                    'availableQuantity' => $inventory_quantity.' '.$inventory->measurement_unit,
                    'requiredMore' => $required_quantity - $inventory_quantity.' '.$inventory->measurement_unit,
                ];
            }
        }

        if(!$availability){
            return [
                'status' => 'error',
                'message' => 'Some ingredients are not available in the inventory.',
                'data' => $unavailable_ingredients,
                'recipeId' => $recipe_id,
            ];
        }

        return [
            'status' => 'success',
            'message' => 'All ingredients are available in the inventory.',
            'data' => $unavailable_ingredients,
            'recipeId' => $recipe_id,
        ];
    }

    protected function updateInventory($recipe_id, $recipe_quantity, $subtract = true){
        $recipe = Recipe::find($recipe_id);
        $ingredients = $recipe->inventories;

        foreach ($ingredients as $ingredient){
            $inventory = Inventory::find($ingredient->id);
            $inventory_quantity = $inventory->available_units;
            $required_quantity = $ingredient->pivot->quantity * $recipe_quantity;

            if($subtract)
                $inventory->available_units = $inventory_quantity - $required_quantity;
            else
                $inventory->available_units = $inventory_quantity + $required_quantity;
            
            $inventory->save();
        }
    }
}
