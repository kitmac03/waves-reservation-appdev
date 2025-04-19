<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/bal.css') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Remaining Balances</title>
</head>

<body>
    <!-- NAVIGATION BAR SECTION -->
    <nav class="navbar">
        <div class="left-side-nav">
            <a href="{{ url('dashboard') }}">
                <button class="dashboard inactive" id="dashboard">
                    <i class="material-icons nav-icons">dashboard</i> Dashboard
                </button>
            </a>
            <a href="{{ url('ameneties') }}">
                <button class="amenities" id="amenities">
                    <i class="material-icons nav-icons">holiday_village</i> Amenities
                </button>
            </a>
            <a href="{{ url('reservations') }}">
                <button class="reservations active" id="reservation">
                    <i class="material-icons nav-icons">date_range</i> Reservations
                </button>
            </a>
        </div>

        <div class="right-side-nav">
            <button class="profile">
                <i class="material-icons" style="font-size:45px; color: white">
                    account_circle
                </i>
            </button>
        </div>
    </nav>

    <main class="main">
        <a href="{{ route('admin.vendor.reservation_calendar') }}" class="back-link">
            <span class="chevron-left"></span> Back to Calendar
        </a>
        <h2 class="head-title">Remaining Balances</h2>

        <div class="reservation-container">
            <div class="header-row">
                <div class="header-cell name-header">Name</div>
                <div class="header-cell calculation-header">Balance Calculation</div>
                <div class="header-cell remaining-header">Remaining Balance</div>
                <div class="header-cell remaining-header">Status</div>
                <div class="header-cell"></div>
            </div>
            @foreach ($reservations as $reservation)
            <div class="reservation-item">
                <div class="name-cell">
                    <span class="guest-name">{{ $reservation->customer->name ?? 'Unknown' }}</span>
                </div>
                <div class="calculation-cell">
                    @php
                        $displayedBalance = $reservation->grandTotal - $reservation->balance;
                        if ($reservation->grandTotal == $reservation->balance) {
                            $displayedBalance = 0;
                        }
                    @endphp
                    <span class="total-amount">{{ number_format($reservation->grandTotal, 2) }}</span>
                    <span class="minus"> - </span>
                    <span class="downpayment">{{ number_format($displayedBalance, 2) }}</span>
                    <span class="equals"> = </span>
                </div>
                <div class="remaining-cell">
                    <span class="balance-amount">{{ number_format($reservation->balance, 2) }}</span>
                </div>
                @php
               $status = $reservation->bill ? $reservation->bill->status : 'Unpaid';
            
                $bgColor = match ($status) {
                    'partially paid' => 'bg-yellow-200 text-yellow-700',
                    'unpaid' => 'bg-red-200 text-red-700',
                    default => '',
                };
                  @endphp
                  
                  <div class="status-cell">
                     <div class="px-2 py-0.5 rounded text-xs inline-block {{ $bgColor }}">
                        <p class="m-0">{{ $status }}</p>
                    </div>
                  </div>
                <div class="action-cell">
                    @php
                        $amenities = $reservation->reservedAmenities->map(function($item) {
                            return [
                                'name' => $item->amenity->name,
                                'price' => number_format($item->amenity->price, 2)
                            ];
                        });
                        $bill = $reservation->bill;
                    @endphp
        
                    <button
                        class="verify-btn"
                        onclick='openPaymentModal(
                              "{{ $reservation->id }}", 
                              "{{ $bill->id }}",
                              "{{optional($reservation->downPayment)->id }}",
                              @json($reservation->customer->name ?? "Unknown"),
                              {{ $reservation->grandTotal }},
                              {{ $reservation->paidAmount }},
                              {{ $reservation->balance }},
                              @json($amenities),
                              @json($reservation->downPaymentImageUrl),
                              @json($reservation->downpayment_status)
                        )'
                     >
                        Record Payment
                    </button>
                    <button class="decline-btn">Send Reminder</button>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Modal -->
        <div id="paymentModal"
            x-data="paymentFormHandler()"
            x-show="isOpen"
            class="text-sm pointer-events-none fixed inset-0 z-[1000] grid h-screen w-screen place-items-center bg-black rounded bg-opacity-60 opacity-0 backdrop-blur-sm transition-opacity duration-300"
            :class="{
                'opacity-0 pointer-events-none': !isOpen,
                'opacity-100 overflow-hidden': isOpen && showConfirmation
            }"
            @keydown.escape.window="closeModal()"
            x-cloak
            style="display: none;"
        >
                    
            <div class="relative m-4 p-6 w-2/5 min-w-[35%] max-w-[35%] max-h-[80vh] rounded bg-white shadow-sm overflow-y-auto" @click.stop>
                <button @click="closeModal()" class="absolute top-2 right-2 text-2xl text-gray-600 hover:text-gray-800 transition-colors">&times;</button>
                <div class="flex justify-between items-center border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-800">Make Payment</h2>
                    <div>
                        <span id="dpStatus" class="text-sm font-bold px-2 py-1 rounded-md"></span>
                    </div>
                </div>
                <form id="verifyPaymentForm" method="POST" action="{{ route('admin.vendor.process-payment') }}" x-ref="paymentForm" @submit.prevent="trySubmit" class="p-6">
                    @csrf
                    <input type="hidden" id="reservationId" name="reservation_id">
                    <input type="hidden" id="billId" name="bill_id">
                    <input type="hidden" id="dp_id" name="dp_id">
                    <input type="hidden" id="status" name="status" value="verified">
                    
                    <div class="mb-4">
                        <h2 class="text-sm font-semibold text-gray-800"><span id="modalGustName"></span></h2>
                        <p class="text-sm text-gray-600"><span id="modalPhoneNumber"></span></p>
                    </div>
                    
                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 ps-10 mx-15 pe-10 mb-4">
                        <h6 class="font-semibold text-gray-700 mb-2">Payment Summary:</h6>
                        <ul id="modalAmenities" class="list-disc pl-5 space-y-1"></ul>
                        <hr class="my-3 border-gray-200">
                        <div class="flex justify-between">
                            <strong>Total:</strong>
                            <span class="font-bold"><span id="modalTotalAmount"></span></span>
                        </div>
                        <div class="flex justify-between">
                            <strong>Down Payment (50%):</strong>
                            <span class="font-bold"><span id="modalDownpayment"></span></span>
                        </div>
                        <div class="flex justify-between">
                            <strong>Paid Amount:</strong>
                            <span class="font-bold"><span id="balDown"></span></span>
                        </div>
                        <div class="flex justify-between">
                            <strong>Balance:</strong>
                            <span class="font-bold"><span id="balRemaining"></span></span>
                        </div>
                    </div>

                    <div class="my-2">
                     <p id="pendingMessage" class="bg-yellow-100 rounded-md text-sm text-yellow-500 p-2 hidden">Please verify the payment.</p>
                     <p id="invalidMessage" class="bg-red-100 rounded-md text-sm text-red-500 p-2 hidden">Contact the customer to send clear photo for proof of payment.</p>
                 </div>
                    
                    <div class="mb-4">
                        <div id="verifyImageWrapper" class="w-full">
                            <img id="verifyImage" alt="Downpayment Image"
                                class="rounded-md max-h-64 w-auto object-contain border border-gray-300 shadow hidden"/>
                        </div>
                        <p id="noImageMessage"
                            class="mt-2 bg-green-100 text-green-500 rounded-md text-sm p-2 text-center hidden">
                            Paid by cash
                        </p>
                        <p id="notPaidNoImage"
                            class="mt-2 bg-yellow-100 text-yellow-500 rounded-md text-sm p-2 text-center hidden">
                            Pending for payment
                        </p>
                    </div>
                    
                    <div class="my-4" id="paymentInputBox">
                        <label for="payment_amount" class="block text-sm font-medium text-gray-700 mb-1">Enter Payment Received:</label>
                        <input type="number" id="payment_amount" name="payment_amount" placeholder="500" required 
                            class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition" 
                            :class="{'border-red-500 border-2': hasError}" />
                        
                        <p x-show="showError" class="mt-1 text-sm text-red-600" style="display: none;">Please enter a valid payment amount</p>
                    </div>

                    <div class="flex flex-col md:flex-row justify-center items-center gap-4 mt-4">
                        <!-- Invalid Button & Confirmation -->
                        <div x-data="{ showInvalidConfirm: false }" class="w-full md:w-auto">
                            <button
                                type="button"
                                id="submitInvalidBtn"
                                @click="showInvalidConfirm = true"
                                data-action="{{ route('admin.vendor.invalid-payment') }}"
                                class="w-full md:w-auto rounded-md bg-red-600 px-6 py-2 text-white hover:bg-red-700 transition"
                            >
                                Mark as Invalid
                            </button>
                    
                            <!-- Invalid Confirmation Dialog -->
                            <div
                                x-show="showInvalidConfirm"
                                x-transition:enter="ease-out duration-300"
                                x-transition:enter-start="opacity-0"
                                x-transition:enter-end="opacity-100"
                                x-transition:leave="ease-in duration-200"
                                x-transition:leave-start="opacity-100"
                                x-transition:leave-end="opacity-0"
                                class="fixed inset-0 z-[1100] flex items-center justify-center bg-black bg-opacity-50"
                            >
                                <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-md">
                                    <h3 class="text-lg font-semibold text-gray-900">Mark Payment as Invalid?</h3>
                                    <p class="mt-2 text-gray-600">
                                        Are you sure the downpayment proof is unclear or invalid?
                                    </p>
                                    <div class="mt-6 flex justify-end gap-3">
                                        <button
                                            type="button"
                                            @click="showInvalidConfirm = false"
                                            class="px-4 py-2 text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200 transition"
                                        >
                                            Cancel
                                        </button>
                                        <button
                                            type="button"
                                            @click="
                                                document.getElementById('payment_amount').removeAttribute('required');
                                                document.getElementById('status').value = 'invalid';
                                                document.getElementById('verifyPaymentForm').action = document.getElementById('submitInvalidBtn').dataset.action;
                                                document.getElementById('verifyPaymentForm').submit();
                                                showInvalidConfirm = false;
                                            "
                                            class="px-4 py-2 text-white bg-red-600 rounded-md hover:bg-red-700 transition"
                                        >
                                            Confirm
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                        <!-- Record Payment Button -->
                        <button
                            type="submit"
                            id="submitBtn"
                            class="w-full md:w-auto px-6 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition"
                        >
                            Record Payment
                        </button>
                    
                        <!-- Payment Confirmation Modal -->
                        <div
                            x-show="showConfirmation"
                            x-transition
                            x-cloak
                            class="fixed inset-0 z-[1100] flex items-center justify-center bg-black bg-opacity-50 p-4"
                            style="display: none;"
                        >
                            <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-md">
                                <h3 class="text-lg font-semibold text-gray-900">Confirm Payment</h3>
                                <p class="mt-2 text-gray-600">
                                    Are you sure the payment was verified? Once verified, it will be confirmed and processed.
                                </p>
                                <div class="mt-6 flex justify-end gap-3">
                                    <button
                                        @click="cancelSubmit"
                                        type="button"
                                        class="px-4 py-2 text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200 transition"
                                    >
                                        Cancel
                                    </button>
                                    <button
                                        @click="confirmSubmit"
                                        type="button"
                                        class="px-4 py-2 text-white bg-green-600 rounded-md hover:bg-green-700 transition"
                                    >
                                        Confirm
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>                    
                </form>
            </div>
        </div>
    </main>

    <script>
        function paymentFormHandler() {
            return {
                isOpen: false,
                showConfirmation: false,
                shouldSubmit: false,
                hasError: false,
                showError: false,

                openModal() {
                    this.isOpen = true;
                },

                closeModal() {
                    this.isOpen = false;
                },

                resetState() {
                    this.hasError = false;
                    this.showError = false;
                    const input = document.getElementById('payment_amount');
                    input.classList.remove('border-red-500', 'border-2');
                },

                validateForm() {
                    const input = document.getElementById('payment_amount');
                    const amount = parseFloat(input.value);

                    if (!amount || amount <= 0) {
                        input.classList.add('border-red-500', 'border-2');
                        input.focus();
                        this.hasError = true;
                        this.showError = true;
                        return false;
                    }

                    input.classList.remove('border-red-500', 'border-2');
                    this.hasError = false;
                    this.showError = false;
                    return true;
                },

                trySubmit() {
                    this.resetState();
                    if (this.validateForm()) {
                        this.showConfirmation = true;
                    }
                },

                confirmSubmit() {
                    this.shouldSubmit = true;
                    this.showConfirmation = false;
                    this.$nextTick(() => {
                        document.getElementById('verifyPaymentForm').submit();
                    });
                },

                cancelSubmit() {
                    this.showConfirmation = false;
                    this.shouldSubmit = false;

                    const input = document.getElementById('payment_amount');
                    const amount = parseFloat(input.value);
                    if (!amount || amount <= 0) {
                        this.hasError = true;
                        this.showError = true;
                        input.classList.add('border-red-500', 'border-2');
                    }
                }
            }
        }

        function openPaymentModal(reservationId, billId, dpId, name, total, downpayment, balance, amenities, downpayment_image, downpayment_status) {
            const modal = document.getElementById('paymentModal');
            const minDp = total * 0.5;

            // Set form values
            document.getElementById('reservationId').value = reservationId;
            document.getElementById('billId').value = billId;
            document.getElementById('dp_id').value = dpId;
            document.getElementById('dpStatus').innerText = downpayment_status;
            document.getElementById('modalGustName').innerText = name;
            document.getElementById('modalTotalAmount').innerText = `₱${total.toFixed(2)}`;
            document.getElementById('modalDownpayment').innerText = `₱${minDp.toFixed(2)}`;
            document.getElementById('balDown').innerText = `₱${downpayment.toFixed(2)}`;
            document.getElementById('balRemaining').innerText = `₱${balance.toFixed(2)}`;
            // Handle image and messages
            const verifyModalImage = document.getElementById('verifyImage');
            const noImageMessage = document.getElementById('noImageMessage');
            const notPaidNoImage = document.getElementById('notPaidNoImage');
            const dpStatusElem = document.getElementById('dpStatus');

            dpStatusElem.innerText = downpayment_status;

            // Reset classes first
            dpStatusElem.classList.remove('bg-yellow-200', 'text-yellow-700', 'bg-green-200', 'text-green-700', 'bg-red-200', 'text-red-700');
            // Check if image exists
            const hasImage = downpayment_image && downpayment_image.trim() !== '' && downpayment_image !== 'N/A';

            if (hasImage) {
               // Image exists: show image, hide both messages
               verifyModalImage.src = downpayment_image;
               verifyModalImage.classList.remove('hidden');
               noImageMessage.classList.add('hidden');
               notPaidNoImage.classList.add('hidden');
               document.getElementById('submitInvalidBtn').classList.remove('hidden');
               document.getElementById('submitBtn').classList.add('md:w-auto');

            } else {
               // No image: hide image
               verifyModalImage.classList.add('hidden');

               if (downpayment <= 0) {
                  // No downpayment: show pending message
                  notPaidNoImage.classList.remove('hidden');
                  noImageMessage.classList.add('hidden');
               } else {
                  // Downpayment exists but no image: show no image message
                  notPaidNoImage.classList.add('hidden');
                  noImageMessage.classList.remove('hidden');
               }
               document.getElementById('submitInvalidBtn').classList.add('hidden');
               document.getElementById('submitBtn').classList.remove('md:w-auto');
            }

            const pendingMessage = document.getElementById('pendingMessage');
            const invalidMessage = document.getElementById('invalidMessage');

            // Hide both first to reset
            pendingMessage.classList.add('hidden');
            invalidMessage.classList.add('hidden');
            document.getElementById('paymentInputBox').classList.add('hidden');
            document.getElementById('submitBtn').classList.add('hidden');
            document.getElementById('submitInvalidBtn').classList.add('hidden');

            if (downpayment_status === 'pending' && hasImage) {
               pendingMessage.classList.remove('hidden');
               document.getElementById('submitInvalidBtn').classList.remove('hidden');
               document.getElementById('submitBtn').classList.remove('hidden');
               document.getElementById('paymentInputBox').classList.remove('hidden');
            } else if (downpayment_status === 'invalid' && hasImage) {
               invalidMessage.classList.remove('hidden');
               document.getElementById('submitInvalidBtn').classList.add('hidden');
               document.getElementById('submitBtn').classList.add('hidden');
               document.getElementById('paymentInputBox').classList.add('hidden');
            } else if (downpayment_status === 'verified' && hasImage){
                document.getElementById('paymentInputBox').classList.remove('hidden');
                document.getElementById('submitBtn').classList.remove('hidden');
                document.getElementById('submitInvalidBtn').classList.remove('hidden');
            } else{
                document.getElementById('paymentInputBox').classList.remove('hidden');
                document.getElementById('submitBtn').classList.remove('hidden');
                document.getElementById('submitInvalidBtn').classList.add('hidden');
            }

            if (downpayment_status === 'pending') {
                dpStatusElem.classList.add('bg-yellow-200', 'text-yellow-700');
            } else if (downpayment_status === 'verified') {
                dpStatusElem.classList.add('bg-green-200', 'text-green-700');
            } else if (downpayment_status === 'invalid') {
                dpStatusElem.classList.add('bg-red-200', 'text-red-700');
            }



         // Populate amenities
            const amenitiesContainer = document.getElementById('modalAmenities');
            if (amenities && amenities.length) {
               const container = document.createElement('div');
               
               amenities.forEach(item => {
                  const amenityDiv = document.createElement('div');
                  amenityDiv.className = 'flex justify-between text-sm';
                  
                  const nameSpan = document.createElement('span');
                  nameSpan.className = 'text-gray-700';
                  nameSpan.textContent = item.name;
               
                  const priceSpan = document.createElement('span');
                  priceSpan.className = 'font-medium text-gray-900';
                  priceSpan.textContent = `₱${item.price}`;
                  
                  amenityDiv.appendChild(nameSpan);
                  amenityDiv.appendChild(priceSpan);
                  container.appendChild(amenityDiv);
               });
               amenitiesContainer.innerHTML = '';
               amenitiesContainer.appendChild(container);
            } else {
               amenitiesContainer.innerHTML = '<p class="text-sm text-gray-500 italic">No amenities listed.</p>';
            }

            // Open modal
            Alpine.nextTick(() => {
                modal._x_dataStack[0].openModal();
            });
        }

        // Initialize Alpine when DOM is loaded
        document.addEventListener('DOMContentLoaded', function() {
            // Close modal when clicking outside content
            document.getElementById('paymentModal').addEventListener('click', function(e) {
                if (e.target === this) {
                    this._x_dataStack[0].closeModal();
                }
            });
        });
    </script>
</body>
</html>