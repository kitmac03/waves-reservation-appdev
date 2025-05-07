<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\InactiveCustomers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use App\Rules\UniqueEmailAcrossTables;

class ProfileController extends Controller
{
    public function view_profile()
    {
        $customer = auth()->user();

        // Check if there's a pending deletion request
        $pendingRequest = InactiveCustomers::where('customer_id', $customer->id)
            ->where('status', 'pending')
            ->first();
        return view('customer.profile', compact('customer', 'pendingRequest'));
    }

    public function edit_profile($id)
    {
        $customer = Customer::findOrFail($id);
        return view('customer.edit_profile', compact('customer'));
    }

    public function update_profile(Request $request, $id)
    {
        $customer = Customer::findOrFail($id);

        // Check if the email is being changed
        $emailRule = $customer->email == $request->email ? 'nullable' : ['required', 'string', 'email', 'max:255', new UniqueEmailAcrossTables($customer->id)];

        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
            'number' => 'required|regex:/^[0-9]{11}$/',
            'email' => $emailRule,  // Apply the dynamic email validation
        ]);

        // Update the customer profile with name, number, and email
        $customer->update($request->only(['name', 'number', 'email']));

        // Flash success message
        return redirect()->route('customer.profile')->with('success', 'Profile updated successfully!');
    }

    public function delete_profile(Request $request, $id)
    {
        $reason = $request->input('reason');
        $otherReason = $request->input('other_reason');

        $finalReason = ($reason === 'other') ? $otherReason : $reason;

        InactiveCustomers::create([
            'customer_id' => $id,
            'inactive_date'   => Carbon::now(),
            'deletion_reason' => $finalReason,
            'status' => 'pending',
        ]);

        return redirect()->route('customer.profile')->with('success', 'Your request to archive the account has been recorded.');
    }


}