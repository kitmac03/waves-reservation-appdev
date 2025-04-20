<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Amenities;
use App\Models\Admin;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class AmenitiesController extends Controller
{
    public function view_cottages()
    {
        // Retrieve all cottages (both active and archived)
        $cottages = Amenities::where('type', 'cottage')->get();

        $userId = Auth::id();
        $user = Admin::find($userId);

        if ($user->role == 'manager') {
            return view('admin.manager.amenities.cottages', compact('cottages'));
        } else if ($user->role == 'vendor') {
            return view('admin.vendor.amenities.cottages', compact('cottages'));
        }
        return redirect()->route('login')->with('error', 'Unauthorized access.');
    }

    public function add_cottage(Request $request)
    {
        Log::debug('Incoming request data:', $request->all());

        $type = 'cottage';
        $userId = Auth::id();

        Log::debug('Admin ID:', [$userId]);

        $validator = $this->validator(array_merge($request->all(), ['type' => $type, 'added_by' => $userId]));

        if ($validator->fails()) {
            Log::error('Validation failed:', $validator->errors()->all());
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Amenities::create([
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

    public function update_cottage(Request $request, $id)
    {
        $cottage = Amenities::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
        ]);

        $cottage->update([
            'name' => $request->name,
            'price' => $request->price,
        ]);

        return redirect()->back()->with('success', 'Cottage updated successfully!');
    }

    public function archive_cottage($id)
    {
        $cottage = Amenities::findOrFail($id);
        $cottage->update(['is_active' => false]);

        return redirect()->back()->with('success', 'Cottage archived successfully!');
    }

    public function unarchive_cottage($id)
    {
        $cottage = Amenities::findOrFail($id);
        $cottage->update(['is_active' => true]);

        return redirect()->back()->with('success', 'Cottage unarchived successfully!');
    }



    public function view_tables()
    {
        // Retrieve all tables (both active and archived)
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

        $type = 'table';
        $userId = Auth::id();

        Log::debug('Admin ID:', [$userId]);

        $validator = $this->validator(array_merge($request->all(), ['type' => $type, 'added_by' => $userId]));

        if ($validator->fails()) {
            Log::error('Validation failed:', $validator->errors()->all());
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Amenities::create([
            'name' => $request->name,
            'price' => $request->price,
            'type' => $type,
            'added_by' => $userId,
        ]);

        return redirect()->back()->with('success', 'Table added successfully!');
    }

    public function edit_table($id)
    {
        $table = Amenities::findOrFail($id);
        return view('admin.manager.amenities.edit_table', compact('table'));
    }

    public function update_table(Request $request, $id)
    {
        $table = Amenities::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
        ]);

        $table->update([
            'name' => $request->name,
            'price' => $request->price,
        ]);

        return redirect()->back()->with('success', 'Table updated successfully!');
    }

    public function archive_table($id)
    {
        $table = Amenities::findOrFail($id);
        $table->update(['is_active' => false]);

        return redirect()->back()->with('success', 'Table archived successfully!');
    }

    public function unarchive_table($id)
    {
        $table = Amenities::findOrFail($id);
        $table->update(['is_active' => true]);

        return redirect()->back()->with('success', 'Table unarchived successfully!');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'regex:/^\d+(\.\d{1,2})?$/'],
            'type' => ['required', 'string', 'max:255'],
            'added_by' => ['required', 'integer'],
        ]);
    }
}
