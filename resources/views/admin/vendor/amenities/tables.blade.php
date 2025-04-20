<!-- filepath: c:\Users\Tenchavez\StudioProjects\winds-reservation\resources\views\admin\vendor\amenities\tables.blade.php -->
@extends('admin.vendor.amenities.amenities')

@section('amenities-content')
    <!-- Success Message -->
    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded-lg mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Tables List -->
    <table class="availability-table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Price</th>
                <th>Availability</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tables as $table)
                @if($table->type === 'table') <!-- Only display tables -->
                <tr class="{{ $table->is_active ? 'active' : 'archived' }}">
                    <td>{{ $table->name }}</td>
                    <td>₱{{ number_format($table->price, 2) }}</td>
                    <td>
                        <span class="{{ $table->is_active ? 'text-green-600 font-semibold' : 'text-red-600 font-semibold' }}">
                            {{ $table->is_active ? 'Available' : 'Not Available' }}
                        </span>
                    </td>
                </tr>
                @endif
            @endforeach
        </tbody>
    </table>
@endsection