<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Amenities;

class AmenitiesController extends Controller
{
    public function create()
    {
        return view('admin.manager.amenities.cottages');
    }

    public function store(Request $request)
    {
        $this->validator($request->all())->validate();

        $amenities = Amenities::create([
            'name' => $request->name,
            'price' => $request->price,  // Store the contact number
            'type' => $request->type,
            'added_by' => auth()->admin()->id,
        ]);
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'decimal', 'max:5'],
            'type' => ['required', 'string', 'max:255'],

        ]);
    }
}
