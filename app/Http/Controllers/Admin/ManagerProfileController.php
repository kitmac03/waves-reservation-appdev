<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ManagerProfileController extends Controller
{
    public function view_reservation_list()
    {
        return view('admin.manager.profile.reservation_list'); 
    }

    public function view_all_reservations()
    {
        return view('admin.manager.profile.all_reservations'); 
    }

    public function view_profile()
    {
        return view('admin.manager.profile.profile'); 
    }

    public function view_vendors_list()
    {
        return view('admin.manager.profile.vendors_list'); 
    }

    public function view_del_req()
    {
        return view('admin.manager.profile.del_req'); 
    }
}
