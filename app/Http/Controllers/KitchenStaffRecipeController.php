<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\Request;

class KitchenStaffRecipeController extends Controller
{
    public function index(){
        return view('dashboard.pages.kitchen_staff.recipe', [
            'recipes' => Recipe::where('on_menu',  '1')->get(),
        ]);
    }

    public function toggleAvailability(Request $request){
        $recipe = Recipe::find($request->recipe_id);
        $is_available = $recipe->is_available;
        $recipe->is_available = $is_available ? 0 : 1;
        $recipe->save();

        return response()->json([
            'success' => true,
            'message' => 'Recipe updated successfully',
            'is_available' => Recipe::find($request->recipe_id)->is_available,
            'recipe_id' => $recipe->id,
            'recipe_name' => $recipe->recipe_name,
        ]);
    }
}
