<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;

class CabinsController extends Controller
{
    public function showCabins()
    {
        return view('customer.cabins'); 
    }
}
