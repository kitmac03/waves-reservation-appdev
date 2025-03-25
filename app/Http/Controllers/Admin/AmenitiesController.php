<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Amenities; // Using Amenities model
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class AmenitiesController extends Controller
{
    public function view_cottages()
    {
        // Retrieve all cottages from the database
        $cottages = Amenities::where('type', 'cottage')->get();

        $userId = Auth::id();
        $user = \App\Models\Admin::find($userId);

        // Check the user's role
        if ($user->role == 'manager') {
            return view('admin.manager.amenities.cottages', compact('cottages'));
        } else if ($user->role == 'vendor') {
            return view('admin.vendor.amenities.cottages', compact('cottages'));
        }
    }


    public function add_cottage(Request $request)
    {
        // Log the incoming request data for debugging
        Log::debug('Incoming request data:', $request->all());

        // Set type as 'cottage' by default
        $type = 'cottage';
        $userId = Auth::id(); // Ensure admin is authenticated

        Log::debug('Admin ID:', [$userId]);

        $validator = $this->validator(array_merge($request->all(), ['type' => $type, 'added_by' => $userId]));

        if ($validator->fails()) {
            Log::error('Validation failed:', $validator->errors()->all());
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Insert into database
        $amenities = Amenities::create([
            'name' => $request->name,
            'price' => $request->price,
            'type' => $type,
            'added_by' => $userId,
        ]);

        return redirect()->back()->with('success', 'Cottage added successfully!');
    }

    public function edit_cottage($id)
    {
        $cottage = Amenities::findOrFail($id);
        return view('admin.manager.amenities.edit_cottage', compact('cottage'));
    }

    public function archive_cottage($id)
    {
        $cottage = Amenities::findOrFail($id);
        $cottage->update(['status' => 'archived']); // Assuming you have a 'status' column

        return redirect()->back()->with('success', 'Cottage archived successfully!');
    }

    public function create_cottage()
    {
        return view('admin.manager.amenities.create_cottage'); // Ensure this view exists
    }

    public function view_tables()
    {
        $tables = Amenities::where('type', 'table')->get();

        $userId = Auth::id();
        $user = \App\Models\Admin::find($userId);

        if ($user->role == 'manager') {
            return view('admin.manager.amenities.tables', compact('tables'));
        } else if ($user->role == 'vendor') {
            return view('admin.vendor.amenities.tables', compact('tables'));
        }
    }

    public function add_table(Request $request)
    {
        Log::debug('Incoming request data:', $request->all());

        // Set type as 'table' by default
        $type = 'table';
        $userId = Auth::id();

        Log::debug('Admin ID:', [$userId]);

        $validator = $this->validator(array_merge($request->all(), ['type' => $type, 'added_by' => $userId]));

        if ($validator->fails()) {
            Log::error('Validation failed:', $validator->errors()->all());
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Insert into database
        $amenities = Amenities::create([
            'name' => $request->name,
            'price' => $request->price,
            'type' => $type,
            'added_by' => $userId,
        ]);

        return redirect()->back()->with('success', 'Table added successfully!');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'regex:/^\d+(\.\d{1,2})?$/'], // Fix decimal validation
            'type' => ['required', 'string', 'max:255'],
            'added_by' => ['required', 'integer'],
        ]);
    }

}
