<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManagerProfileController extends Controller
{
    public function view_reservation_list()
    {
        return view('admin.manager.reservations.reservation_list');
    }

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

    public function update_vendors_list(Request $request, $id)
    {
        $vendor = Admin::find($request->id);
        if ($vendor) {
            $vendor->role = $request->role;
            $vendor->save();

            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }

    public function view_del_req()
    {
        return view('admin.manager.profile.del_req');
    }
}
