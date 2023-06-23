<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\StaffTableController;
use App\Http\Controllers\API\StaffOrderController;
use App\Http\Controllers\ManagerProfileController;
use App\Http\Controllers\KitchenStaffPlanController;
use App\Http\Controllers\KitchenStaffOrderController;
use App\Http\Controllers\KitchenStaffRecipeController;
use App\Http\Controllers\BusinessInformationController;

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
    return redirect()->route('login');
});

Route::get('/user_panel', function () {
    return view('dashboard');
})->middleware(['auth', 'verified', 'redirect'])->name('dashboard');

Route::group(['middleware' => ['auth', 'auth.admin'], 'prefix' => 'admin', 'as' => 'admin.'], function () {
    //admin Home
    Route::get('/home', function(){ return redirect()->route('admin.inventory'); })->name('home');
    //admin inventory
    Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory');
    Route::post('/inventory/store', [InventoryController::class, 'store'])->name('inventory.store');
});

Route::group(['middleware' => ['auth', 'auth.manager'], 'prefix' => 'manager', 'as' => 'manager.'], function () {
    //manager Home
    Route::get('/home', function(){ return redirect()->route('manager.dashboard'); })->name('home');

    //dashboard
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

    //manager settings
    Route::get('/setting', [BusinessInformationController::class, 'index'])->name('setting');
    Route::post('/setting/update', [BusinessInformationController::class, 'update'])->name('setting.update');

    //manager profile
    Route::post('/profile/update', [ManagerProfileController::class, 'update'])->name('profile.update');
    
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
    Route::post('/recipe/toggleOnMenu', [RecipeController::class, 'toggleOnMenu'])->name('recipe.toggle_on_menu');
    Route::get('/recipe/delete/{id}', [recipeController::class, 'destroy'])->name('recipe.destroy');
    
    //manager recipe
    Route::get('/menu_planner', [PlanController::class, 'index'])->name('menu_planner');

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
    Route::get('/table/destroy/{id}', [TableController::class, 'destroy'])->name('table.destroy');
    
    //manager order
    Route::get('/api/getOrders/{table_id}', [StaffOrderController::class, 'getOrders'])->name('api.get_orders');
    
    //manager receipt
    Route::get('/receipt/{invoice_id}', [TableController::class, 'receipt'])->name('receipt');
    
    //manager payment controller
    Route::post('/payment', [PaymentController::class, 'payment'])->name('payment');

    //manager planning
    Route::post('/api/storePlan', [PlanController::class, 'store'])->name('api.store_plan');
    Route::get('/api/getPlanCount/{day}', [PlanController::class, 'getPlanCount'])->name('api.get_plan_count');
});

Route::group(['middleware' => ['auth', 'auth.staff'], 'prefix' => 'staff', 'as' => 'staff.'], function () {
    //staff Home
    Route::get('/home', function(){ return redirect()->route('staff.table'); })->name('home');

    //staff table
    Route::get('/table', [StaffTableController::class, 'index'])->name('table');
    
    //staff order
    Route::get('/api/getMenu/{table_id}', [StaffOrderController::class, 'getMenu'])->name('api.get_menu');
    Route::post('/api/storeOrder', [StaffOrderController::class, 'storeOrder'])->name('api.store_order');
    Route::get('/api/getOrders/{table_id}', [StaffOrderController::class, 'getOrders'])->name('api.get_orders');
});

Route::group(['middleware' => ['auth', 'auth.kitchen_staff'], 'prefix' => 'kitchen_staff', 'as' => 'kitchen_staff.'], function () {
    //kitchen staff Home
    Route::get('/home', function(){ return redirect()->route('kitchen_staff.order'); })->name('home');
    
    //kitchen staff recipe
    Route::get('/recipe', [KitchenStaffRecipeController::class, 'index'])->name('recipe');
    Route::post('/recipe/toggle_availability', [KitchenStaffRecipeController::class, 'toggleAvailability'])->name('recipe.toggle_availability');
    
    //kitchen staff order
    Route::get('/order', [KitchenStaffOrderController::class, 'index'])->name('order');
    Route::post('/change_status', [KitchenStaffOrderController::class, 'changeStatus'])->name('change_status');
    Route::get('/api/getOrders/{table_id}', [StaffOrderController::class, 'getOrders'])->name('api.get_orders');

    //planned menu
    Route::get('/menu_planner', [KitchenStaffPlanController::class, 'index'])->name('menu_planner');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
