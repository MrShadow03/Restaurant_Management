<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ManagerProfileController extends Controller
{
    public function update(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::find(auth()->user()->id);
        $user->name = $request->name;
        $user->password = Hash::make($request->password);
        $user->save();
        
        return redirect()->back()->with('success', 'Profile has updated!');
    }
}
