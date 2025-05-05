<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Rules\UniqueEmailAcrossTables;

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

        $request->validate([
            'name' => 'required|string|max:255',
            'number' => 'required|regex:/^[0-9]{11}$/',
            'email' => ['required', 'string', 'email', 'max:255', new UniqueEmailAcrossTables($customer->id)],
        ]);

        // Update the customer profile
        $customer->update($request->only(['name', 'number', 'email']));

        // Flash success message
        return redirect()->route('customer.profile')->with('success', 'Profile updated successfully!');
    }



}