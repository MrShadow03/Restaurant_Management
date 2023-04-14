<?php

namespace App\Http\Controllers;

use App\Models\Table;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StaffTableController extends Controller
{
    public function index(){
        return view('dashboard.pages.staff.table',[
            'tables' => Table::where('user_id', auth()->user()->id)->get(),
            'menu' => Recipe::where('on_menu', 1)->get(),
        ]);
    }
}
