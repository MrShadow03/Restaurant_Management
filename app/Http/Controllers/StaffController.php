<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Termwind\Components\Dd;

class StaffController extends Controller
{
    public function index()
    {
        return view('dashboard.pages.manager.staff',[
            'staff' => User::where('role', 'staff')->orWhere('role', 'kitchen_staff')->get(),
        ]);
    }

    public function store(Request $request){
        if(User::where('phone_number', $request->phone_number)->orWhere('email', $request->email)->exists()){
            return redirect()->route('manager.staff')->with('error', 'Phone number or Email already exists');
        }

        $request->validate([
                'name' => 'required',
                'phone_number' => 'required | unique:users',
                'role' => 'required',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone_number = $request->phone_number;
        $user->password = Hash::make('pass@'.$request->phone_number);
        $user->role = $request->role;
        $user->save();

        return redirect()->route('manager.staff')->with('success', 'Staff added successfully');
    }

    public function update(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'nullable | unique:users,email,'.$request->id,
            'phone_number' => 'required | unique:users,phone_number,'.$request->id,
            'role' => 'required',
        ]);

        $user = User::find($request->id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone_number = $request->phone_number;
        $user->role = $request->role;
        $user->save();

        return redirect()->route('manager.staff')->with('success', $request->name.'\'s data updated successfully');
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
