<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>WAVES Reservation Down Payment</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="w-full max-w-2xl mx-auto p-10  bg-white rounded-2xl shadow-lg">
        <div class="text-center mb-6">
            <h2 class="text-3xl font-bold mb-1">WAVES</h2>
            <p class="text-gray-600">Beach Resort</p>
            <h5 class="text-lg font-semibold mt-4">Complete Your Reservation with a Down Payment</h5>
        </div>

        @php
            $total = optional($reservation->bills)->sum('grand_total') ?? 0;
            $downpayment = $total * 0.5;
        @endphp

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul class="list-disc pl-5 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 ps-10 mx-15 pe-10 mb-4">
            <h6 class="text-sm font-semibold text-gray-700 mb-2">Payment Summary:</h6>
            <ul class="text-sm text-gray-800 space-y-1 mb-2">
                @foreach ($reservation->reservedAmenities as $reserved)
                    <li class="flex justify-between">
                        <span>{{ $reserved->amenity->name }}</span>
                        <span class="font-bold">₱{{ number_format($reserved->amenity->price, 2) }}</span>
                    </li>
                @endforeach
            </ul>
            <hr class="my-3">
            <div class="text-sm flex justify-between">
                <strong>Total:</strong>
                <span class="font-bold">₱{{ number_format($total, 2) }}</span>
            </div>
            <div class="text-sm flex justify-between">
                <strong>Down Payment (50%):</strong>
                <span class="font-bold">₱{{ number_format($downpayment, 2) }}</span>
            </div>
        </div>

        <div class="text-center text-red-600 text-sm mb-6">
            <strong>Down payments are non-refundable if the reservation is canceled.</strong><br>
            Please ensure your reservation is final before proceeding.
        </div>

        <form action="{{ route('customer.downpayment.store', $reservation->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div>
                <h6 class="text-base font-semibold mb-1">1. Pay via GCash</h6>
                <p class="text-sm text-gray-700">
                    Use the GCash number below to send your payment:<br>
                    <span class="text-blue-600 text-lg font-bold">09151288083</span> - WAVES Beach Resort
                </p>
            </div>

            <div>
                <h6 class="text-base font-semibold mb-1">2. Provide Payment Details</h6>
                <div class="mb-3">
                    <label for="full_name" class="block text-sm font-medium text-gray-700">Full Name:</label>
                    <input type="text" name="full_name" id="full_name" required
                        value="{{ old('full_name', $reservation->full_name) }}"
                        class="mt-1 block w-full p-2 rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                </div>

                <div>
                    <label for="ref_number" class="block text-sm font-medium text-gray-700">Reference Number:</label>
                    <input type="text" name="ref_number" id="ref_number" required
                        value="{{ old('ref_number') }}"
                        class="mt-1 block w-full p-2 rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                </div>
            </div>

            <div>
                <h6 class="text-base font-semibold mb-1">3. Upload Proof of Payment</h6>
                <label for="payment_proof" class="block text-sm font-medium text-gray-700">Upload screenshot of your GCash receipt:</label>
                <input type="file" name="payment_proof" id="payment_proof" accept="image/*" required
    onchange="previewImage(event)"
    class="mt-1 block w-full text-sm text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
            </div>

            <div id="imagePreview" class="mt-3 hidden">
                <p class="text-sm text-gray-700 mb-1">Preview:</p>
                <img id="preview" src="" class="max-w-xs rounded-lg border border-gray-300 shadow-sm" alt="Image Preview">
            </div>

            <div class="flex justify-end space-x-3 pt-2">
                <a href="{{ route('customer.dashboard') }}"
                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200">
                    Cancel
                </a>
                <button type="submit"
                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700">
                    Submit
                </button>
            </div>
        </form>
    </div>
    <script>
        function previewImage(event) {
            const input = event.target;
            const preview = document.getElementById('preview');
            const previewContainer = document.getElementById('imagePreview');
    
            if (input.files && input.files[0]) {
                const reader = new FileReader();
    
                reader.onload = function (e) {
                    preview.src = e.target.result;
                    previewContainer.classList.remove('hidden');
                }
    
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</body>
</html>
