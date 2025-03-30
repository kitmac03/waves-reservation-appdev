<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendor Reservation Record</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FullCalendar CSS -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
    <!-- FullCalendar JS -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>

</head>
 <!--for Calendar buttons -->
<style>
    .fc .fc-button {
        padding: 2px 6px !important;
        font-size: 12px !important;
        height: 24px !important;
        min-width: 30px !important;
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
    
        <!-- Modal -->
        <div
        data-dialog-backdrop="modal"
        data-dialog-backdrop-close="true"
        class="pointer-events-none fixed inset-0 z-[999] grid h-screen w-screen place-items-center bg-black bg-opacity-60 opacity-0 backdrop-blur-sm transition-opacity duration-300">
        <div
        data-dialog="modal"
        class="relative m-4 p-6 w-2/5 min-w-[40%] max-w-[40%] rounded-lg bg-white shadow-sm">
            <!-- Modal Header -->
            <div class="flex justify-between items-center pb-4 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-800">
                Reservation by: <span id="modalTitle"></span>
                </h2>
                <span id="modalStatus" class="text-sm font-bold px-2 py-1 rounded-md"></span>
            </div>
        
            <!-- Modal Content -->
            <div class="py-4 text-gray-600">
                <p>Date: <span id="modalDate"> </span></p>
                <p> Start Time: <span id="modalStartTime"></p>
                <p> End Time: <span id="modalEndTime"></p>
        
                <h3 class="font-semibold mt-3">Amenities Reserved:</h3>
                <ul id="modalAmenities" class="list-disc pl-5"></ul>
        
                <hr class="my-3 border-gray-300">
                <p class="font-semibold text-lg">Total: <span id="modalTotal"></span> PHP</p>
                <p class="text-sm">Downpayment (50%): <span id="modalDownpayment"></span> PHP</p>
            </div>
        
            <!-- Modal Footer -->
            <div class="flex justify-end space-x-2 pt-4 border-t border-gray-200">
                <button data-dialog-close="true" class="rounded-md border border-gray-300 px-4 py-2 text-gray-700 hover:bg-gray-100">Close</button>
                <button id="verifyButton" class="rounded-md bg-green-600 px-4 py-2 text-white hover:bg-green-700">Verify</button>
            </div>
        </div>
      </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            events: '/api/events', // Fetch events from Laravel
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
                console.log("Extended Props:", info.event.extendedProps);

                // Fill in modal details
                document.getElementById('modalTitle').innerText = (info.event.extendedProps.customer_name || "Unknown");
                document.getElementById('modalDate').innerText = (info.event.extendedProps.date || "N/A");
                document.getElementById('modalStartTime').innerText = (info.event.extendedProps.start_time || "N/A");
                document.getElementById('modalEndTime').innerText = (info.event.extendedProps.end_time || "N/A");

                // Set status color
                let statusEl = document.getElementById('modalStatus');
                statusEl.innerText = info.event.extendedProps.status || "Pending";
                statusEl.className = "text-sm font-bold px-2 py-1 rounded-md " +
                    (info.event.extendedProps.status === "pending" ? "bg-yellow-500 text-white" :
                    info.event.extendedProps.status === "verified" ? "bg-green-500 text-white" :
                    info.event.extendedProps.status === "cancelled" ? "bg-red-500 text-white" :
                    "bg-gray-500 text-white");

                // Display amenities
                const amenitiesList = document.getElementById('modalAmenities');
                amenitiesList.innerHTML = "";

                if (Array.isArray(info.event.extendedProps.amenities) && info.event.extendedProps.amenities.length > 0) {
                    info.event.extendedProps.amenities.forEach(amenity => {
                        let li = document.createElement('li');
                        li.innerText = `${amenity.name} - ₱${amenity.price}`;
                        amenitiesList.appendChild(li);
                    });
                } else {
                    amenitiesList.innerHTML = "<li>No amenities reserved</li>";
                }

                // Display total and downpayment (from backend)
                document.getElementById('modalTotal').innerText = (info.event.extendedProps.total || '0');
                document.getElementById('modalDownpayment').innerText = (info.event.extendedProps.downpayment || '0');   

                // Open modal
                document.querySelector("[data-dialog='modal']").parentElement.classList.remove("opacity-0", "pointer-events-none");
            }
        });

        calendar.render();

        // Close modal functionality
        document.querySelectorAll("[data-dialog-close='true'], [data-dialog-backdrop-close='true']").forEach(element => {
            element.addEventListener("click", function() {
                document.querySelector("[data-dialog='modal']").parentElement.classList.add("opacity-0", "pointer-events-none");
            });
        });
    });
    </script>
    
</body>
</html>
