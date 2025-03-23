<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminDashboardController extends Controller
{
    // public function __construct()
    // {
    //     // Ensures that only authenticated admins can access this controller
    //     $this->middleware('auth:admin');
    // }

    public function create()
    {
        // Return the view for the admin dashboard
        return view('admin.dashboard'); // Make sure you have an 'admin/dashboard.blade.php' view
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

        // Auth::login($admin);

        // return redirect()->route('admin/dashboard');
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
        return view('admin.manager.create_admin');
    }
}
