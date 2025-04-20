@extends('admin.vendor.amenities.amenities')

@section('amenities-content')
    <!-- Success Message -->
    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded-lg mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Cottages Table -->
    <table class="availability-table">
        <thead>
            <tr>
                <th>Name</th>
					 <th>Price</th>
                <th>Availability</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cottages as $cottage)
                @if($cottage->type === 'cottage') <!-- Only display cottages -->
                <tr class="{{ $cottage->is_active ? 'active' : 'archived' }}">
                    <td>{{ $cottage->name }}</td>
						  <td>₱{{ number_format($cottage->price, 2) }}</td>
                    <td>
                        <span class="{{ $cottage->is_active ? 'text-green-600' : 'text-red-600' }}">
                            {{ $cottage->is_active ? 'Available' : 'Not Available' }}
                        </span>
                    </td>
                </tr>
                @endif
            @endforeach
        </tbody>
    </table>
@endsection