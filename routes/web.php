<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\StaffTableController;

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
    Route::patch('/recipe/update', [RecipeController::class, 'update'])->name('recipe.update');
    Route::patch('/recipe/toggleOnMenu', [RecipeController::class, 'toggleOnMenu'])->name('recipe.toggle_on_menu');
    Route::get('/recipe/delete/{id}', [recipeController::class, 'destroy'])->name('recipe.destroy');

    //manager staff
    Route::get('/staff', [StaffController::class, 'index'])->name('staff');
    Route::post('/staff/store', [StaffController::class, 'store'])->name('staff.store');
    Route::patch('/staff/update', [StaffController::class, 'update'])->name('staff.update');
    Route::patch('/staff/toggleStatus', [StaffController::class, 'toggleStatus'])->name('staff.toggle_status');
    Route::patch('/staff/assignTable', [StaffController::class, 'assignTable'])->name('staff.assign_table');
    Route::get('/staff/delete/{id}', [StaffController::class, 'destroy'])->name('staff.destroy');

    //manager table
    Route::get('/table', [TableController::class, 'index'])->name('table');
    Route::post('/table/store', [TableController::class, 'store'])->name('table.store');
    Route::patch('/table/update', [TableController::class, 'update'])->name('table.update');
    Route::patch('/table/toggleStatus', [TableController::class, 'toggleStatus'])->name('table.toggle_status');
    Route::patch('/table/updateAttendant', [TableController::class, 'updateAttendant'])->name('table.update_attendant');
    Route::get('/table/delete/{id}', [TableController::class, 'destroy'])->name('table.destroy');

});

Route::group(['middleware' => ['auth', 'auth.staff'], 'prefix' => 'staff', 'as' => 'staff.'], function () {
    //staff table
    Route::get('/table', [StaffTableController::class, 'index'])->name('table');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
