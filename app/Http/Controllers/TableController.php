<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Table;
use Illuminate\Http\Request;

class TableController extends Controller
{
    public function index()
    {
        return view('dashboard.pages.manager.table',[
            'tables' => Table::with('user')->get(),
            'attendants' => User::where('role', 'staff')->get(),
        ]);
    }

    public function store(Request $request){
        $request->validate([
            'table_number' => 'required|unique:tables|numeric',
            'user_id' => 'required|numeric|exists:users,id|not_in:0',
        ]);

        $table = new Table();
        $table->table_number = $request->table_number;
        $table->user_id = $request->user_id;
        $table->save();

        return redirect()->route('manager.table')->with('success', 'Table added successfully');
    }

    public function updateAttendant(Request $request){
        $request->validate([
            'table_id' => 'required|numeric|exists:tables,id',
            'user_id' => 'required|numeric|exists:users,id|not_in:0',
        ]);

        $table = Table::find($request->table_id);
        $table->user_id = $request->user_id;
        $table->save();

        return redirect()->route('manager.table')->with('success', 'Table attendant updated successfully');
    }
}
