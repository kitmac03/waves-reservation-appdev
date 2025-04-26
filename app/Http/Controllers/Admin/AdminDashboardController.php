<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AdminDashboardController extends Controller
{
    // public function __construct()
    // {
    //     // Ensures that only authenticated admins can access this controller
    //     $this->middleware('auth:admin');
    // }

    public function create()
    {
        return view('admin.dashboard');
    }

    public function store(Request $request)
    {

        $this->validator($request->all())->validate();

        $admin = Admin::create([
            'name' => $request->name,
            'number' => $request->number,  // Store the contact number
            'email' => $request->email,
            'password' => Hash::make($request->password),  // Hash the password
            'role' => $request->role,
        ]);

        return redirect()->route('admin.create.account');
    }


    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'number' => 'required|regex:/^[0-9]{11}$/',
            'email' => ['required', 'string', 'email', 'max:255', 'unique:admins'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'string', 'max:255'],
        ]);
    }

    public function create_admin()
    {
        return view('admin.manager.profile.create_admin');
    }
}
