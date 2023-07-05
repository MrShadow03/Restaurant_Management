<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminStaffController extends Controller
{
    public function index()
    {
        return view('dashboard.pages.admin.staff',[
            'staff' => User::where('role', 'staff')->orWhere('role', 'kitchen_staff')->get(),
        ]);
    }
}
