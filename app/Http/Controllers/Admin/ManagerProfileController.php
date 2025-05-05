<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Rules\UniqueEmailAcrossTables;

class ManagerProfileController extends Controller
{

    public function view_all_reservations()
    {
        return view('admin.manager.reservations.all_reservations');
    }

    public function view_profile()
    {
        $userId = Auth::id();
        $admin = Admin::find($userId);
        return view('admin.manager.profile.profile', compact('admin'));
    }

    public function view_vendors_list()
    {
        $vendors = Admin::whereRaw('LOWER(role) = ?', ['vendor'])->get();

        return view('admin.manager.profile.vendors_list', compact('vendors'));
    }

    public function update_profile(Request $request, $id)
    {
        // Get the currently authenticated admin (modify as needed)
        $admin = Admin::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'number' => 'required|regex:/^[0-9]{11}$/',
            'email' => ['required', 'string', 'email', 'max:255', new UniqueEmailAcrossTables($admin->id)],
        ]);

        $admin->update($validated);

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }
    public function update_vendors_list(Request $request, $id)
    {
        $vendor = Admin::find($request->id);
        if ($vendor) {
            $vendor->role = $request->role;
            $vendor->save();

            return response()->json(['success' => true, 'message' => 'Role updated successfully.']);
        } else {
            return response()->json(['success' => false, 'message' => 'Vendor not found.']);
        }
    }


    public function view_del_req()
    {
        return view('admin.manager.profile.del_req');
    }
}
