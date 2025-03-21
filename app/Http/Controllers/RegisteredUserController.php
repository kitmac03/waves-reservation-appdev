<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class RegisteredUserController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {

        $this->validator($request->all())->validate();

        $customer = Customer::create([
            'name' => $request->name,
            'number' => $request->number,  // Store the contact number
            'email' => $request->email,
            'password' => Hash::make($request->password),  // Hash the password
        ]);

        // Optionally, log the user in after registration
        Auth::login($customer);

        // return redirect()->route('dashboard');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'number' => 'required|regex:/^[0-9]{11}$/',
            'email' => ['required', 'string', 'email', 'max:255', 'unique:customers'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }
}
