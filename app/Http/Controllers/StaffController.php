<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StaffController extends Controller
{
    public function index()
    {
        return view('dashboard.pages.manager.staff',[
            'staff' => User::where('role', 'serving_staff')->where('role', 'kitchen_staff')->get(),
        ]);
    }

    public function store(Request $request){
        $request->validate([
                'name' => 'required',
                'email' => 'nullable | unique:users',
                'phone_number' => 'required | unique:users',
                'role' => 'required',
            ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make('pass@'.$request->phone_number);
        $user->role = $request->role;
        $user->save();

        return redirect()->route('manager.staff')->with('success', 'Staff added successfully');
    }

    public function update(Request $request){
        $request->validate([
                'name' => 'required',
                'email' => 'nullable',
                'phone_number' => 'required',
                'role' => 'required',
            ]);

        $user = User::find($request->id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->save();

        return redirect()->route('manager.staff')->with('success', 'Staff updated successfully');
    }

    public function toggleStatus(Request $request){
        $user = User::find($request->id);
        $user->status = isset($request->status) ? 1 : 0;
        $user->save();

        return redirect()->route('manager.staff')->with('success', 'Staff updated successfully');
    }

    public function destroy(Request $request){
        $user = User::find($request->id);
        $user->delete();

        return redirect()->route('manager.staff')->with('success', 'Staff deleted successfully');
    }
}
