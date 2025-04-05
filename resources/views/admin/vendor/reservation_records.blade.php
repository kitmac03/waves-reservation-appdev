<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendor Reservation Record</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
</head>
<style>
    .fc .fc-button {
        padding: 2px 6px !important;
        font-size: 12px !important;
        height: 24px !important;
        min-width: 30px !important;
    }
    #verifyModal {
        max-height: 80vh;
        overflow-y: auto;
    }
    #verifyModal::-webkit-scrollbar {
        width: 6px;
    }
    #verifyModal::-webkit-scrollbar-thumb {
        background-color: #ccc;
        border-radius: 3px;
    }
    #verifyModal::-webkit-scrollbar-thumb:hover {
        background-color: #aaa;
    }
    /* Fullscreen image modal with fixed center image */
    #fullscreenImageModal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.9);
        z-index: 1100;
        overflow: hidden;
    }
    #fullscreenImageContainer {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        display: flex;
        align-items: center;
        justify-content: center;
        max-width: 100%;
        max-height: 90%; /* Reduced to make space for controls */
    }
    #fullscreenImage {
        display: block;
        max-width: 100%;
        max-height: 80vh;
        object-fit: contain;
        transform-origin: center center;
        transition: transform 0.25s ease;
        cursor: default;
    }
    #verifyImage {
        cursor: zoom-in;
        transition: transform 0.2s;
        max-width: 100%;
        max-height: 300px;
        object-fit: contain;
    }
    #verifyImage:hover {
        transform: scale(1.02);
    }
</style>
<body class="bg-gray-100 min-h-screen">

    <div class="container mx-auto p-6">
        <div class="flex justify-center my-4">
            <div class="flex space-x-4">
                <span class="text-green-600">● Verified</span>
                <span class="text-yellow-600">● Pending</span>
                <span class="text-red-600">● Cancelled</span>
                <span class="text-gray-600">● Completed</span>
            </div>
        </div>
    </div>

    <div class="flex justify-center">
        <div id="calendar" class="max-w-4xl w-full h-[500px]"></div>
    </div>

    <!-- Reservation Details Modal -->
    <div id="reservationModalBackdrop" data-dialog-backdrop="reservationModal" data-dialog-backdrop-close="true" class="pointer-events-none fixed inset-0 z-[999] grid h-screen w-screen place-items-center bg-black bg-opacity-60 opacity-0 backdrop-blur-sm transition-opacity duration-300">
        <div id="reservationModal" data-dialog="reservationModal" class="relative m-4 p-6 w-2/5 min-w-[40%] max-w-[40%] rounded-lg bg-white shadow-sm">
            <div class="flex justify-between items-center pb-4 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-800">Reservation by: <span id="modalCustomerName"></span></h2>
                <span id="modalStatus" class="text-sm font-bold px-2 py-1 rounded-md"></span>
            </div>

            <div class="py-4 text-gray-600">
                <p>Date: <span id="modalDate"> </span></p>
                <p>Start Time: <span id="modalStartTime"></span></p>
                <p>End Time: <span id="modalEndTime"></span></p>

                <h3 class="font-semibold mt-3">Amenities Reserved:</h3>
                <ul id="modalAmenities" class="list-disc pl-5"></ul>

                <hr class="my-3 border-gray-300">
                <p class="font-semibold text-lg">Total: <span id="modalTotal"></span> PHP</p>
                <p class="text-sm">Downpayment (50%): <span id="modalDownpayment"></span> PHP</p>
            </div>

            <div class="flex justify-end space-x-2 pt-4 border-t border-gray-200">
                <button id="closeReservationModal" class="rounded-md border border-gray-300 px-4 py-2 text-gray-700 hover:bg-gray-100">Close</button>
                <button id="verifyBtn" class="rounded-md bg-green-600 px-4 py-2 text-white hover:bg-green-700">Verify</button>
            </div>
        </div>
    </div>

    <!-- Verify Downpayment Modal -->
    <div 
    id="verifyModalBackdrop"
    data-dialog-backdrop="verifyModal" 
    data-dialog-backdrop-close="true" 
    class="pointer-events-none fixed inset-0 z-[1000] grid h-screen w-screen place-items-center bg-black bg-opacity-60 opacity-0 backdrop-blur-sm transition-opacity duration-300">
        <div 
        id="verifyModal"
        data-dialog="verifyModal" 
        class="relative m-4 p-6 w-2/5 min-w-[40%] max-w-[40%] rounded-lg bg-white shadow-sm">
            <!-- Modal Header -->
            <div class="flex justify-between items-center pb-4 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-800">Verify Downpayment</h2>
                <button id="closeVerifyModal" class="text-gray-700 hover:bg-gray-100 rounded-md px-2 py-1">Close</button>
            </div>
            
            <!-- Modal Content -->
            <div class="py-4 text-gray-600">
                <form id="verifyDownpaymentForm" action="{{ route('admin.vendor.process-payment') }}" method="POST">
                    @csrf
                    <input type="hidden" id="reservationId" name="reservation_id">
                    <input type="hidden" id="billId" name="bill_id">
                    <input type="hidden" id="dp_id" name="dp_id">
                    <input type="hidden" id="status" name="status" value="verified">
                
                    <!-- Customer Details -->
                    <div class="mb-4">
                        <h2 class="text-xl font-semibold text-gray-800">Username: <span id="verifyCustomerName"></span></h2>
                        <p>Phone Number: <span id="modalPhoneNumber"></span></p>
                    </div>
                
                    <!-- Bill Details -->
                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 ps-10 mx-15 pe-10 mb-4">
                        <h6 class="text-sm font-semibold text-gray-700 mb-2">Payment Summary:</h6>
                        <ul id="verifyAmenities" class="list-disc"></ul>
                        <hr class="my-3">
                        <div class="text-sm flex justify-between">
                            <strong>Total:</strong>
                            <span class="font-bold"><span id="verifyTotal"></span></span>
                        </div>
                        <div class="text-sm flex justify-between">
                            <strong>Down Payment (50%):</strong>
                            <span class="font-bold"><span id="verifyDownpayment"></span></span>
                        </div>
                        <div class="text-sm flex justify-between" id="balanceContainer">
                            <strong>Balance:</strong>
                            <span class="font-bold"><span id="balanceAmount"></span></span>
                        </div>
                    </div>
                
                    <!-- Image -->
                    <div class="mb-4">
                        <img id="verifyImage" src="" alt="Downpayment Image" class="rounded-md hidden">
                        <p id="noDownpaymentMessage" class="text-red-600 hidden">No downpayment submitted</p>
                    </div>
                
                    <!-- Reference Number -->
                    <div class="mb-4">
                        <p class="block text-m font-medium">Reference Number: <span id="verifyReferenceNumber"></span></p>
                    </div>
                
                    <!-- Payment Amount Input -->
                    <div class="mb-4">
                        <label for="payment_amount" class="block text-m font-medium">Payment Amount</label>
                        <input type="number" id="payment_amount" placeholder="Enter Paid Amount" name="payment_amount" required class="w-full mt-2 p-2 border rounded-md">
                    </div>
                
                    <!-- Modal Footer -->
                    <div class="flex justify-end space-x-2 pt-4 border-t border-gray-200">
                        <!-- Not Working -->
                        <button type="button" id="submitInvalidBtn" data-action="{{ route('admin.vendor.invalid-payment') }}" class="rounded-md bg-red-600 px-4 py-2 text-white hover:bg-red-700">Invalid</button>
                        <button type="submit" class="rounded-md bg-green-600 px-4 py-2 text-white hover:bg-green-700">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Fullscreen Image Modal with Zoom -->
    <div id="fullscreenImageModal" class="hidden">
        <div id="fullscreenImageContainer">
            <span id="closeFullscreen">&times;</span>
            <img id="fullscreenImage" src="" alt="Fullscreen Downpayment Image">
            <div id="zoomControls" class="hidden">
                <button class="zoomButton" id="zoomIn">+</button>
                <button class="zoomButton" id="zoomOut">-</button>
                <button class="zoomButton" id="resetZoom">Reset</button>
            </div>
        </div>
    </div>
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize FullCalendar with proper headers
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            events: '/api/events',
            headerToolbar: {
                start: '',
                center: 'title',
                end: 'prev,next today'
            },
            buttonText: {
                today: 'Today',
                prev: '‹',
                next: '›'
            },
            eventClick: function(info) {
                console.log('Full Event Data:', info.event);

                let eventProps = info.event.extendedProps || {};
                console.log('Event Props:', eventProps);

                let amenities = eventProps.amenities || [];
                console.log('Amenities:', amenities);

                // Basic information
                document.getElementById('modalCustomerName').textContent = eventProps.customer_name || "Unknown";
                document.getElementById('modalPhoneNumber').textContent = eventProps.phone_number || "N/A";
                document.getElementById('modalDate').textContent = eventProps.date || "N/A";
                document.getElementById('modalStartTime').textContent = eventProps.start_time || "N/A";
                document.getElementById('modalEndTime').textContent = eventProps.end_time || "N/A";

                // Status display
                const statusEl = document.getElementById('modalStatus');
                const billStatus = eventProps.bill_status || "unpaid";

                statusEl.textContent = billStatus.charAt(0).toUpperCase() + billStatus.slice(1);
                statusEl.className = `text-sm font-bold px-2 py-1 rounded-md ${
                    billStatus === "partially paid" ? "bg-yellow-500 text-white" :
                    billStatus === "paid" ? "bg-green-500 text-white" :
                    billStatus === "unpaid" ? "bg-red-500 text-white" :
                    "bg-gray-500 text-white"
                }`;

                // Amenities handling
                const amenitiesList = document.getElementById('modalAmenities');
                amenitiesList.innerHTML = "";

                if (Array.isArray(amenities) && amenities.length > 0) {
                    amenities.forEach(amenity => {
                        const li = document.createElement('li');
                        li.className = "list-none";

                        if (typeof amenity === 'object' && amenity.name && amenity.price !== undefined) {
                            li.innerHTML = `<span>${amenity.name}</span><span class="font-bold"> - ₱${parseFloat(amenity.price).toFixed(2)}</span>`;
                        } else {
                            li.innerHTML = `<span>${amenity}</span><span class="font-bold"> - ₱0.00</span>`; // Fallback if data is missing
                        }

                        amenitiesList.appendChild(li);
                    });
                } else {
                    amenitiesList.innerHTML = "<li>No amenities reserved</li>";
                }

                // Financial information
                document.getElementById('modalTotal').textContent = eventProps.total || '0';
                document.getElementById('modalDownpayment').textContent = eventProps.downpayment || '0';

                // Store reservation ID
                const verifyBtn = document.getElementById('verifyBtn');
                verifyBtn.setAttribute('data-reservation-id', info.event.id);
                verifyBtn.setAttribute('data-event-props', JSON.stringify(eventProps));

                // Open modal
                document.getElementById('reservationModalBackdrop').classList.remove("opacity-0", "pointer-events-none");
            }
        });

        calendar.render();

        // Modal close handlers
        document.getElementById('closeReservationModal').addEventListener('click', () => {
            document.getElementById('reservationModalBackdrop').classList.add("opacity-0", "pointer-events-none");
        });

        document.getElementById('closeVerifyModal').addEventListener('click', () => {
            document.getElementById('verifyModalBackdrop').classList.add("opacity-0", "pointer-events-none");
        });

        // Verify button handler
        document.getElementById('verifyBtn').addEventListener('click', function (e) {
            e.preventDefault();

            // Close reservation modal
            document.getElementById('reservationModalBackdrop').classList.add("opacity-0", "pointer-events-none");

            // Get stored event data
            const eventProps = JSON.parse(this.getAttribute('data-event-props') || "{}");
            const reservationId = this.getAttribute('data-reservation-id');
            const billId = eventProps.bill_id || ""; 
            const dp_id = eventProps.dp_id || "";
            const dpIdInput = document.getElementById('dp_id');

            // Populate verify modal
            document.getElementById('reservationId').value = reservationId;
            document.getElementById('billId').value = billId;
            document.getElementById('dp_id').value = dp_id;
            document.getElementById('verifyCustomerName').textContent = eventProps.customer_name || "Unknown";
            document.getElementById('modalPhoneNumber').textContent = eventProps.phone_number || "N/A";
            document.getElementById('verifyReferenceNumber').textContent = eventProps.ref_num || "N/A";

            // Populate amenities
            const verifyAmenitiesList = document.getElementById('verifyAmenities');
            verifyAmenitiesList.innerHTML = "";
            if (Array.isArray(eventProps.amenities) && eventProps.amenities.length > 0) {
                eventProps.amenities.forEach(amenity => {
                    const li = document.createElement('li');
                    li.className = "flex justify-between";
                    li.innerHTML = `<span>${amenity.name || "Unknown"}</span><span class="font-bold">₱${parseFloat(amenity.price || 0).toFixed(2)}</span>`;
                    verifyAmenitiesList.appendChild(li);
                });
            } else {
                verifyAmenitiesList.innerHTML = "<li class='text-gray-600'>No amenities reserved</li>";
            }

            // Financial handling
            const grandTotal = parseFloat(eventProps.total) || 0;
            const paidAmount = parseFloat(eventProps.paid_amount) || 0;
            const downPaymentAmount = grandTotal * 0.5;
            const balanceAmount = grandTotal - paidAmount;
            document.getElementById('verifyTotal').textContent = `₱${grandTotal.toFixed(2)}`;
            document.getElementById('verifyDownpayment').textContent = `₱${downPaymentAmount.toFixed(2)}`;
            document.getElementById('balanceAmount').textContent = `₱${balanceAmount.toFixed(2)}`;

            // Hide balance div if paidAmount is 0
            const balanceDiv = document.getElementById('balanceContainer'); // Add an ID to the div
            if (paidAmount === 0) {
                balanceDiv.style.display = 'none';
            } else {
                balanceDiv.style.display = 'flex'; // Show it if paidAmount is greater than 0
            }

            // Handle image
            const verifyModalImage = document.getElementById('verifyImage');
            const noDownpaymentMessage = document.getElementById('noDownpaymentMessage');
            if (eventProps.downpayment_image) {
                verifyModalImage.src = eventProps.downpayment_image;
                verifyModalImage.classList.remove('hidden');
                noDownpaymentMessage.classList.add('hidden');
            } else {
                verifyModalImage.classList.add('hidden');
                noDownpaymentMessage.classList.remove('hidden');
            }
            // Open verify modal
            document.getElementById('verifyModalBackdrop').classList.remove("opacity-0", "pointer-events-none");
        });
        // Invalid Button
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('verifyDownpaymentForm');
            const invalidBtn = document.getElementById('submitInvalidBtn');
            const paymentInput = document.getElementById('payment_amount');
            const statusField = document.getElementById('status');

            invalidBtn.addEventListener('click', function (e) {
                e.preventDefault();

                // Remove required validation
                paymentInput.removeAttribute('required');

                // Set status to invalid
                statusField.value = 'invalid';

                // Change the form action to the invalid-payment route
                form.action = invalidBtn.dataset.action;

                // Submit form
                form.submit();
            });

            // Re-enable validation on normal submission
            form.addEventListener('submit', function () {
                if (statusField.value !== 'invalid') {
                    paymentInput.setAttribute('required', 'required');
                }
            });
        });

        // Get the image element that opens the fullscreen modal
        const verifyImage = document.getElementById('verifyImage');
        const fullscreenImageModal = document.getElementById('fullscreenImageModal');
        const fullscreenImage = document.getElementById('fullscreenImage');
        const closeFullscreen = document.getElementById('closeFullscreen');
        let scale = 1;

        // Open the fullscreen image modal when the image is clicked
        verifyImage.addEventListener('click', function() {
            // Set the source of the fullscreen image
            fullscreenImage.src = verifyImage.src;

            // Show the modal
            fullscreenImageModal.style.display = 'block';
            document.body.style.overflow = 'hidden';  // Prevent scrolling when modal is open

            // Reset zoom scale on image open
            scale = 1;
            applyTransform();
        });

        // Zoom functionality (without pan/drag)
        document.getElementById('zoomIn').addEventListener('click', function() {
            scale = Math.min(scale + 0.25, 3);
            applyTransform();
        });

        document.getElementById('zoomOut').addEventListener('click', function() {
            scale = Math.max(scale - 0.25, 1);
            applyTransform();
        });

        document.getElementById('resetZoom').addEventListener('click', function() {
            scale = 1;
            applyTransform();
        });

        // Mouse wheel zoom
        fullscreenImage.addEventListener('wheel', function(e) {
            e.preventDefault();
            const delta = -e.deltaY;
            if (delta > 0) {
                scale = Math.min(scale + 0.1, 3);
            } else {
                scale = Math.max(scale - 0.1, 1);
            }
            applyTransform();
        });

        // Disable all drag/pan functionality
        fullscreenImage.addEventListener('mousedown', function(e) {
            e.preventDefault();
        });

        fullscreenImage.addEventListener('touchstart', function(e) {
            e.preventDefault();
        });

        function applyTransform() {
            fullscreenImage.style.transform = `scale(${scale})`;
        }

        // Close fullscreen image modal
        closeFullscreen.addEventListener('click', function() {
            closeFullscreenModal();
        });

        fullscreenImageModal.addEventListener('click', function(e) {
            if (e.target === this) {
                closeFullscreenModal();
            }
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeFullscreenModal();
            }
        });

        function closeFullscreenModal() {
            fullscreenImageModal.style.display = 'none';
            document.body.style.overflow = '';  // Re-enable scrolling
            scale = 1;
            applyTransform();
        }
    }); 

    </script>
</body>
</html>