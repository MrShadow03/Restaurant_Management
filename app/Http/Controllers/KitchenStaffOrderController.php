<?php

namespace App\Http\Controllers;

use App\Models\Table;
use Illuminate\Http\Request;

class KitchenStaffOrderController extends Controller
{
    public function index(){
        $tables = Table::with('orders')->get();

        return view('dashboard.pages.kitchen_staff.orders', [
            'tables' => $tables,
        ]);
    }
}
