<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class PasswordController extends Controller
{
    // Show password change form
    public function index()
    {
        $customer = auth()->user();
        return view('customer.password', compact('customer'));
    }

    // Handle password update
    public function update(Request $request)
    {
        $request->validate([
            'current_password'      => ['required'],
            'new_password'          => ['required', 'min:8', 'confirmed'],
        ]);

        $customer = Auth::user(); // logged in user

        // Check if current password is correct
        if (!Hash::check($request->current_password, $customer->password)) {
            return back()->withErrors(['current_password' => 'Your current password is incorrect.']);
        }

        // Update the password
        $customer->password = Hash::make($request->new_password);
        $customer->save();

        return back()->with('success', 'Password updated successfully.');
    }
}
