<!DOCTYPE html> 
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cottages Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">
    <div class="max-w-5xl mx-auto bg-white p-6 rounded-lg shadow-lg">
        <h1 class="text-2xl font-bold text-center mb-6">Vendor Cottages</h1>

        <!-- Success Message -->
        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded-lg mb-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- Cottages Table -->
        <div class="overflow-x-auto">
            <table class="w-full border-collapse border border-gray-300 bg-white shadow-md rounded-md">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="border border-gray-300 px-4 py-2">Name</th>
                        <th class="border border-gray-300 px-4 py-2">Price</th>
                        <th class="border border-gray-300 px-4 py-2">Availability</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cottages as $cottage)
                        @if($cottage->type === 'cottage')  <!-- Only display cottages -->
                        <tr class="{{ $cottage->is_active ? 'active' : 'archived' }}">
                            <td class="border border-gray-300 px-4 py-2 text-center">{{ $cottage->name }}</td>
                            <td class="border border-gray-300 px-4 py-2 text-center">₱{{ number_format($cottage->price, 2) }}</td>
                            <td class="border border-gray-300 px-4 py-2 text-center">
                                <span class="{{ $cottage->is_active ? 'text-green-600 font-semibold' : 'text-red-600 font-semibold' }}">
                                    {{ $cottage->is_active ? 'Available' : 'Not Available' }}
                                </span>
                            </td>
                        </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
