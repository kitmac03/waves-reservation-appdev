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
            @foreach($amenities as $amenity)
                <tr class="{{ $amenity->is_active ? 'active' : 'archived' }}">
                    <td>{{ $amenity->name }}</td>
                    <td>₱{{ number_format($amenity->price, 2) }}</td>
                    <td>
                        <span class="{{ ($amenity->availability_status === 'Available') ? 'text-green-600' : 'text-red-600' }}">
                            {{ $amenity->availability_status }}
                        </span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection