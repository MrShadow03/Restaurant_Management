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
        dd($request->all());
        $has_parent = isset($request->has_parent) ? 1 : 0;
        $request->validate([
                'recipe_name' => 'required | unique:recipes',
                'category' => 'nullable',
                'price' => 'required',
                'production_cost' => 'required',
            ]);

        if($has_parent){

        }

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

        return redirect()->route('manager.recipe')->with('success', 'Recipe deleted successfully');
    }
}
