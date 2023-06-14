<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Recipe;
use Illuminate\Http\Request;

class RecipeController extends Controller
{
    public function index()
    {
        return view('dashboard.pages.manager.recipe',[
            'recipes' => Recipe::all(),
            'categories' => Recipe::distinct('category')->pluck('category'),
            'ingredients' => Inventory::all(),
        ]);
    }

    public function store(Request $request){
        // Check if recipe has parent recipe
        $has_parent_recipe = isset($request->has_parent) ? 1 : 0;
        // If recipe has parent recipe, store as child recipe else store as normal recipe
        return $has_parent_recipe ? $this->storeChildRecipe($request) : $this->storeNormalRecipe($request);
    }

    private function storeChildRecipe($request){
        $request->validate([
            'recipe_name' => 'required | unique:recipes',
            'price' => 'required',
            'production_cost' => 'required',
            'parent_item_id' => 'required',
            'for_people' => 'required | numeric | min:1',
            'discount' => 'nullable',
        ]);

        $parent_recipe = Recipe::find($request->parent_item_id);
        $parent_recipe->has_child = 1;
        $parent_recipe->save();

        $recipe = new Recipe();
        $recipe->recipe_name = $request->recipe_name;
        $recipe->category = $parent_recipe->category;
        $recipe->price = $request->price;
        $recipe->discount = $request->discount;
        $recipe->parent_id = $request->parent_item_id;
        $recipe->quantity_multiplier = $request->for_people;
        $recipe->production_cost = $request->production_cost;
        $recipe->save();

        return redirect()->route('manager.recipe')->with('success', 'Recipe added successfully');
    }

    private function storeNormalRecipe($request){
        $request->validate([
            'recipe_name' => 'required | unique:recipes',
            'price' => 'required',
            'production_cost' => 'required',
            'discount' => 'nullable',
        ]);

        $recipe = new Recipe();
        $recipe->recipe_name = $request->recipe_name;
        $recipe->category = $request->category;
        $recipe->price = $request->price;
        $recipe->discount = $request->discount;
        $recipe->production_cost = $request->production_cost;
        $recipe->save();

        return redirect()->route('manager.recipe')->with('success', 'Recipe added successfully');
    }

    public function update(Request $request){
        $request->validate([
                'recipe_name' => 'required',
                'category' => 'nullable',
                'price' => 'required',
                'VAT' => 'nullable',
                'discount' => 'nullable',
                'production_cost' => 'required',
            ]);

        $recipe = Recipe::find($request->id);
        $recipe->recipe_name = $request->recipe_name;
        $recipe->category = $request->category;
        $recipe->price = $request->price;
        $recipe->VAT = $request->VAT;
        $recipe->discount = $request->discount;
        $recipe->production_cost = $request->production_cost;
        $recipe->save();

        return redirect()->route('manager.recipe')->with('success', 'Recipe updated successfully');
    }

    public function toggleOnMenu(Request $request){
        $recipe = Recipe::find($request->id);
        $on_menu = $recipe->on_menu;
        $recipe->on_menu = $on_menu ? 0 : 1;
        $recipe->save();

        return response()->json([
            'onMenu' => $recipe->on_menu,
            'recipeName' => $recipe->recipe_name,
        ]);
    }

    public function destroy($id){
        $recipe = Recipe::find($id);
        $recipe->delete();

        if($recipe->has_child){
            $child_recipes = Recipe::where('parent_id', $id)->get();
            foreach($child_recipes as $child_recipe){
                $child_recipe->delete();
            }
        }

        return redirect()->route('manager.recipe')->with('success', 'Recipe deleted successfully');
    }
}
