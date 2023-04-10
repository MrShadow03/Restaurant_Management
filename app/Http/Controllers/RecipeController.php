<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\Request;

class RecipeController extends Controller
{
    public function index()
    {
        return view('dashboard.pages.manager.recipe',[
            'recipes' => Recipe::all(),
            'categories' => Recipe::distinct('category')->pluck('category'),
        ]);
    }

    public function store(Request $request){
        $request->validate([
                'recipe_name' => 'required | unique:recipes',
                'category' => 'nullable',
                'price' => 'required',
                'VAT' => 'nullable',
            ]);

        $recipe = new Recipe();
        $recipe->recipe_name = $request->recipe_name;
        $recipe->category = $request->category;
        $recipe->price = $request->price;
        $recipe->VAT = $request->VAT;
        $recipe->save();

        return redirect()->route('manager.recipe')->with('success', 'Recipe added successfully');

    }

    public function update(Request $request){
        $request->validate([
                'recipe_name' => 'required',
                'category' => 'nullable',
                'price' => 'required',
                'VAT' => 'nullable',
            ]);

        $recipe = Recipe::find($request->id);
        $recipe->recipe_name = $request->recipe_name;
        $recipe->category = $request->category;
        $recipe->price = $request->price;
        $recipe->VAT = $request->VAT;
        $recipe->save();

        return redirect()->route('manager.recipe')->with('success', 'Recipe updated successfully');
    }

    public function toggleOnMenu(Request $request){
        $recipe = Recipe::find($request->id);
        $recipe->on_menu = isset($request->on_menu) ? 1 : 0;
        $recipe->save();

        return redirect()->route('manager.recipe')->with('success', 'Recipe updated successfully');
    }

    public function destroy($id){
        $recipe = Recipe::find($id);
        $recipe->delete();

        return redirect()->route('manager.recipe')->with('success', 'Recipe deleted successfully');
    }
}
