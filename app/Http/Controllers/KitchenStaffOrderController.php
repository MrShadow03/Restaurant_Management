<?php

namespace App\Http\Controllers;

use App\Models\Table;
use Illuminate\Http\Request;
use Termwind\Components\Dd;

class KitchenStaffOrderController extends Controller
{
    public function index(){
        $tables = Table::with(['orders.recipe','oldestOrder'])->get();
        return view('dashboard.pages.kitchen_staff.orders', [
            'tables' => $tables,
        ]);
    }
}
