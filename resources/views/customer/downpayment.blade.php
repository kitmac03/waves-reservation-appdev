<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>WAVES Reservation Down Payment</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Tailwind CDN -->
    <link rel="stylesheet" href="{{ asset('css/dp.css') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Jaldi&family=Allura&display=swap" rel="stylesheet">

</head>

<body>
    <header>
        <div class="logo">
            <img src="{{ asset('images/logs.png') }}" alt="WAVES Logo">
            <h1 class="title">WAVES <span>Beach Resort</span></h1>
        </div>
        <nav>
            <a href="#">Book Now</a>
            <a href="#">About Us</a>
            <i class="fas fa-user-circle"></i>
        </nav>
    </header>

    <main>
        <section class="down-payment-receipt">
            <div class="receipt-container">
                <h2 class="dp-title">WAVES <span class="text-gray-600">Beach Resort</span></h2>
                <h3 class="text-lg font-semibold mt-4">Complete Your Reservation with a Down Payment</h5>
                <div class="w-full p-1 mb-1">
                <h4 class="text-gray-800 space-y-1 mb-2" style="text-align: left; font-size: 13px; font-weight: bold;">
                    Reservation ID: {{ $reservation->id }} <br>
                    Customer Name: {{ $reservation->customer->name }} <br>
                    Reservation Date: {{ \Carbon\Carbon::parse($reservation->date)->format('F d, Y') }} <br>
                    Reservation Time: {{ \Carbon\Carbon::parse($reservation->startTime)->format('h:i A') }} - {{ \Carbon\Carbon::parse($reservation->endTime)->format('h:i A') }}
                </h4>
                </div>
                    @php
                        $hours = $reservation->hours ?? 0;
                        $total = $reservation->reservedAmenities->sum(function ($reserved) use ($hours) {
                            $price = optional($reserved->amenity)->price ?? 0;
                            return $price * $hours;
                        });
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
                    <div class="downpayment-container">
                        <div class="downpayment-content">

                            <div class="payment-summary">
                                <div class="w-full bg-gray-50 border border-gray-200 border-dashed rounded-lg p-4">
                                    <h6 class="text-xs font-semibold text-gray-700 mb-2">Payment Summary</h6>
                                    <ul class="text-xs text-gray-800 space-y-1 mb-2">
                                        @foreach ($reservation->reservedAmenities as $reserved)
                                            @php
                                                $hours = $reservation->hours ?? 0;
                                                $price    = optional($reserved->amenity)->price ?? 0;
                                                $name     = optional($reserved->amenity)->name  ?? 'Amenity';
                                                $itemTotal = $price * $hours;
                                            @endphp
                                            <li class="flex justify-between text-xs">
                                                <span>{{ $name }} (₱{{ number_format($price, 2) }} x {{ $hours }} hrs)</span>
                                                <span class="font-bold">₱{{ number_format($itemTotal, 2) }}</span>
                                            </li>
                                        @endforeach
                                    </ul>

                                    <hr class="my-2 border-gray-300">

                                    <div class="flex justify-between text-sm text-gray-700">
                                        <strong class="text-xs">Total:</strong>
                                        <span class="font-bold text-xs">₱{{ number_format($total, 2) }}</span>
                                    </div>

                                    <div class="flex justify-between text-xs text-gray-700">
                                        <strong class="text-xs">Down Payment (50%):</strong>
                                        <span class=" text-xs font-bold">₱{{ number_format($downpayment, 2) }}</span>
                                    </div>
                                </div>
                                <p class="warning">
                                    Down payments are non-refundable if the reservation is canceled.<br>
                                    Please ensure your reservation is final before proceeding.
                                </p>
                            </div>

                            <form class="payment-instructions"
                                action="{{ route('customer.downpayment.store', $reservation->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <h4>1. Pay via GCash</h4>
                                <p> Use the GCash number below to send your payment:
                                <p>
                                <p><a href="#">09151288083 - WAVES Beach Resort</a></p>

                                <h4>2. Provide Payment Details</h4>
                                <p class="upload-instruction">After completing the payment, please enter the following
                                    information of the Gcash account you used to proceed with your reservation
                                    verification:</p>

                                <input type="text" name="ref_number" placeholder="Enter reference number"
                                    id="ref_number" required>

                                <h4>3. Upload Proof of Payment</h6>
                                    <p class="upload-instruction">Upload the screenshot of your Gcash payment receipt:
                                    </p>
                                    <input type="file" name="payment_proof" id="payment_proof" accept="image/*" required
                                        onchange="previewImage(event)"
                                        class="mt-1 block w-full text-xs text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">

                                    <div id="imagePreview" class="mt-3 hidden">
                                        <p class="text-xs text-gray-700 mb-1">Preview:</p>
                                        <img id="preview" src=""
                                            class="max-w-xs rounded-lg border border-gray-300 shadow-sm"
                                            alt="Image Preview">
                                    </div>

                                    <div class="button-container">
                                        <a href="{{ route('customer.dashboard') }}"
                                            class="px-4 py-2 text-white bg-red-500 rounded-md hover:bg-red-700">Cancel</a>
                                        <button type="submit"
                                            class="px-4 py-2 text-gray-800 text-white bg-blue-500 rounded-md hover:bg-blue-700">Submit</button>
                                    </div>
                            </form>
                        </div>
                    </div>
            </div>
            <section>
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

                    document.addEventListener("DOMContentLoaded", function () {
                        const form = document.querySelector('.payment-instructions');
                        const modal = document.getElementById('confirmationModal');
                        const confirmBtn = document.getElementById('confirmBtn');
                        const cancelBtn = document.getElementById('cancelBtn');

                        let submitEvent;

                        form.addEventListener('submit', function (e) {
                            e.preventDefault();
                            submitEvent = e;
                            modal.classList.remove('hidden');
                        });

                        confirmBtn.addEventListener('click', function () {
                            modal.classList.add('hidden');
                            form.removeEventListener('submit', handleSubmit);
                            form.submit();
                        });

                        cancelBtn.addEventListener('click', function () {
                            modal.classList.add('hidden');
                        });

                        function handleSubmit(e) {
                            e.preventDefault();
                            modal.classList.remove('hidden');
                        }
                    });
                </script>
    </main>
    <!-- Confirmation Modal -->
    <div id="confirmationModal"
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-[9999] hidden">
        <div class="bg-white rounded-lg p-6 shadow-lg w-11/12 max-w-sm">
            <h2 class="text-lg font-semibold mb-3 text-gray-800">Confirm Submission</h2>
            <p class="text-sm text-gray-600 mb-4">Are you sure you want to submit your down payment?</p>
            <div class="flex justify-end space-x-3">
                <button id="cancelBtn" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400 text-sm">Cancel</button>
                <button id="confirmBtn" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">Yes,
                    Submit</button>
            </div>
        </div>
    </div>

</body>

</html>