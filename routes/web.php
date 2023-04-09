<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InventoryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/user_panel', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::group(['middleware' => ['auth', 'auth.admin'], 'prefix' => 'admin', 'as' => 'admin.'], function () {
    //manager inventory
    Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory');
    Route::post('/inventory/store', [InventoryController::class, 'store'])->name('inventory.store');
});

Route::group(['middleware' => ['auth', 'auth.manager'], 'prefix' => 'manager', 'as' => 'manager.'], function () {
    //manager inventory
    Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory');
    Route::post('/inventory/store', [InventoryController::class, 'store'])->name('inventory.store');
    Route::put('/inventory/update', [InventoryController::class, 'update'])->name('inventory.update');
    Route::put('/inventory/add', [InventoryController::class, 'add'])->name('inventory.add');
    Route::put('/inventory/subtract', [InventoryController::class, 'subtract'])->name('inventory.subtract');
    Route::get('/inventory/delete/{id}', [InventoryController::class, 'destroy'])->name('inventory.destroy');

    //manager recipe
    Route::get('/recipe', [RecipeController::class, 'index'])->name('recipe');
    Route::post('/recipe/store', [RecipeController::class, 'store'])->name('recipe.store');
    Route::get('/recipe/delete/{id}', [recipeController::class, 'destroy'])->name('recipe.destroy');


});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
