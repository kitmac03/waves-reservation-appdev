<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    public function view_profile()
    {
        $customer = auth()->user();
        return view('customer.profile', compact('customer'));
    }


    public function edit_profile($id)
    {
        $customer = Customer::findOrFail($id);
        return view('customer.edit_profile', compact('customer'));
    }

    public function update_profile(Request $request, $id)
    {
        $customer = Customer::findOrFail($id);

        Log::debug('Updating Profile for customer ID: ' . $id);
        Log::debug('Request Data: ', $request->all());

        $request->validate([
            'name' => 'required|string|max:255',
            'number' => 'required|regex:/^[0-9]{11}$/',
            'email' => 'required|string|email|max:255',
        ]);

        $customer->update($request->only(['name', 'number', 'email']));

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }

}