<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BusinessInformation;

class BusinessInformationController extends Controller
{
    public function index()
    {
        return view('dashboard.pages.manager.setting', [
            'business_details' => BusinessInformation::first(),
        ]);
    }

    public function update(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'email' => 'nullable|string|max:255',
        ]);

        $business_details = BusinessInformation::first();
        $business_details->name = $request->name;
        $business_details->phone_number = $request->phone_number;
        $business_details->address = $request->address;
        $business_details->email = $request->email;
        $business_details->save();
        
        return redirect()->back()->with('success', 'Business details has updated!');
    }
}
