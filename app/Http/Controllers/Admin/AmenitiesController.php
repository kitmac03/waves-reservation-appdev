<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Amenities;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class AmenitiesController extends Controller
{
    public function view_cottages()
    {
        return view('admin.manager.amenities.cottages');
    }

    public function view_tables()
    {
        return view('admin.manager.amenities.tables');
    }


    public function add_cottage(Request $request)
    {
        // Log the incoming request data for debugging
        Log::debug('Incoming request data:', $request->all());
    
        // If 'type' is not provided, set it to 'cottage'
        $type = $request->type ?? 'cottage';
        $userId = Auth::id();

        Log::debug('Admin ID:', [$userId]);
    
        $validator = $this->validator(array_merge($request->all(), ['type' => $type], ['added_by' => $userId]));
        
        // Check if validation fails
        if ($validator->fails()) {
            // Log validation errors and return them to the user
            Log::error('Validation failed:', $validator->errors()->all());
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        // Create the new amenity record
        $amenities = Amenities::create([
            'name' => $request->name,
            'price' => $request->price,
            'type' => $type,
            'added_by' => $userId,  // Ensure this is a valid ID
        ]);
    
    }
    
    public function add_table(Request $request)
    {
        // Log the incoming request data for debugging
        Log::debug('Incoming request data:', $request->all());
    
        // If 'type' is not provided, set it to 'cottage'
        $type = $request->type ?? 'table';
        $userId = Auth::id();

        Log::debug('Admin ID:', [$userId]);
    
        $validator = $this->validator(array_merge($request->all(), ['type' => $type], ['added_by' => $userId]));
        
        // Check if validation fails
        if ($validator->fails()) {
            // Log validation errors and return them to the user
            Log::error('Validation failed:', $validator->errors()->all());
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        // Create the new amenity record
        $amenities = Amenities::create([
            'name' => $request->name,
            'price' => $request->price,
            'type' => $type,
            'added_by' => $userId,  // Ensure this is a valid ID
        ]);
    
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'decimal:2', 'max:9999'],
            'type' => ['required', 'string', 'max:255'],
            'added_by' => ['required', 'integer', 'max:255'],

        ]);
    }
}
