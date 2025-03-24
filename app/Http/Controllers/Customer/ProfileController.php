<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function view_profile()
    {
        return view('customer.profile');
    }

    public function view_reservations()
    {
        return view('customer.reservation_records');
    }
}
