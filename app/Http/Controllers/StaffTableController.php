<?php

namespace App\Http\Controllers;

use App\Models\Table;
use Illuminate\Http\Request;

class StaffTableController extends Controller
{
    public function index()
    {
        return view('dashboard.pages.staff.table',[
            'tables' => Table::where('user_id', auth()->user()->id)->get(),
        ]);
    }
}
