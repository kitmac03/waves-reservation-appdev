<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WAVES Beach Resort</title>
    <link rel="stylesheet" href="{{ asset('css/reservation_records.css') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Jaldi&family=Allura&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Jaldi&family=Allura&display=swap" rel="stylesheet">
</head>

<div class="container">
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="back-button">
            <i class="fas fa-chevron-left"></i>
            <span>Back to main</span>
        </div>

        <div class="customer-profile">
            <i class="fas fa-user-circle profile-icon"></i>
            <div class="customer-name">{{ $customer->name }}</div>
        </div>

        <div class="menu">
            <a href="{{ route('customer.profile') }}">
                <i class="fas fa-user"></i>
                <span>Profile</span>
            </a>
            <a href="{{ route('customer.reservation.records') }}" class="active">
                <i class="fas fa-calendar-alt"></i>
                <span>Reservation</span>
            </a>

        </div>

        <button class="logout">
            <i class="fas fa-sign-out-alt"></i>
            <span>Log Out</span>
        </button>
    </div>

    <div class="content">
        <h2>Your Reservations</h2>
        <div class="status-bar">
            <span style="color: green;">● Verified</span>
            <span style="color: orange;">● Pending</span>
            <span style="color: red;">● Cancelled</span>
            <span style="color: gray;">● Past</span>
        </div>
        <div class="reservations">
            <div class="reservation-column">
                <h4>Cancelled</h4>
                @foreach ($cancelledReservations->sortBy(fn($reservation) => new DateTime($reservation->date . ' ' . $reservation->startTime)) as $reservation)
                    @php
                        $date = new DateTime($reservation->date ?? now());
                        $startTime = new DateTime($reservation->startTime ?? '00:00:00');
                        $endTime = new DateTime($reservation->endTime ?? '00:00:00');
                        $statusColor = match ($reservation->status) {
                            'pending' => 'orange',
                            'verified' => 'green',
                            'invalid', 'cancelled' => 'red',
                            'completed' => 'gray',
                            default => 'black',
                        };
                    @endphp
                    <div class="reservation-item" 
                        data-id="{{ $reservation->id }}" 
                        data-name="{{ $reservation->customer->name }}" 
                        data-paidAmount="{{ $reservation->paidAmount }}"
                        data-total="{{ $reservation->grandTotal }}" 
                        data-balance="{{ $reservation->balance }}" 
                        data-date="{{ $reservation->date }}"
                        data-start="{{ $reservation->startTime }}" 
                        data-end="{{ $reservation->endTime }}"
                        data-status="{{ $reservation->status }}"
                        style="border-left: 5px solid {{ $statusColor }}; cursor: pointer;">
                        <strong>#{{ $reservation->customer->name }}</strong><br>
                        {{ $reservation->date }} | {{ $reservation->startTime }} - {{ $reservation->endTime }}
                </div>
                @endforeach
            </div>

            <div class="reservation-column">
                <h4>invalid</h4>
                @foreach ($invalidReservations->sortBy(fn($reservation) => new DateTime($reservation->date . ' ' . $reservation->startTime)) as $reservation)
                    @php
                        $date = new DateTime($reservation->date ?? now());
                        $startTime = new DateTime($reservation->startTime ?? '00:00:00');
                        $endTime = new DateTime($reservation->endTime ?? '00:00:00');
                        $statusColor = match ($reservation->status) {
                            'pending' => 'orange',
                            'verified' => 'green',
                            'invalid', 'cancelled' => 'red',
                            'completed' => 'gray',
                            default => 'black',
                        };
                    @endphp
                    <div class="reservation-item" 
                    data-id="{{ $reservation->id }}" 
                    data-name="{{ $reservation->customer->name }}" 
                    data-paidAmount="{{ $reservation->paidAmount }}"
                    data-total="{{ $reservation->grandTotal }}" 
                    data-balance="{{ $reservation->balance }}" 
                    data-date="{{ $reservation->date }}"
                    data-start="{{ $reservation->startTime }}" 
                    data-end="{{ $reservation->endTime }}"
                    data-status="{{ $reservation->status }}"
                        style="border-left: 5px solid {{ $statusColor }}; cursor: pointer;">
                        <strong>#{{ $reservation->customer->name }}</strong><br>
                        {{ $reservation->date }} | {{ $reservation->startTime }} - {{ $reservation->endTime }}
                    </div>
                @endforeach
            </div>

            <div class="reservation-column">
                <h4>Current</h4>
                @foreach ($currentReservations->sortBy(fn($reservation) => new DateTime($reservation->date . ' ' . $reservation->startTime)) as $reservation)
                    @php
                        $date = new DateTime($reservation->date ?? now());
                        $startTime = new DateTime($reservation->startTime ?? '00:00:00');
                        $endTime = new DateTime($reservation->endTime ?? '00:00:00');
                        $statusColor = match ($reservation->status) {
                            'pending' => 'orange',
                            'verified' => 'green',
                            'invalid', 'cancelled' => 'red',
                            'completed' => 'gray',
                            default => 'black',
                        };
                    @endphp
                    <div class="reservation-item" 
                        data-id="{{ $reservation->id }}" 
                        data-name="{{ $reservation->customer->name }}" 
                        data-paidAmount="{{ $reservation->paidAmount }}"
                        data-total="{{ $reservation->grandTotal }}" 
                        data-balance="{{ $reservation->balance }}" 
                        data-date="{{ $reservation->date }}"
                        data-start="{{ $reservation->startTime }}" 
                        data-end="{{ $reservation->endTime }}"
                        data-status="{{ $reservation->status }}"
                        style="border-left: 5px solid {{ $statusColor }}; cursor: pointer;">
                        <strong>#{{ $reservation->customer->name }}</strong><br>
                        {{ $reservation->date }} | {{ $reservation->startTime }} - {{ $reservation->endTime }}
                    </div>
                @endforeach
            </div>

            <div class="reservation-column">
                <h4>Completed</h4>
                @foreach ($completedReservations->sortBy(fn($reservation) => new DateTime($reservation->date . ' ' . $reservation->startTime)) as $reservation)
                    @php
                        $date = new DateTime($reservation->date ?? now());
                        $startTime = new DateTime($reservation->startTime ?? '00:00:00');
                        $endTime = new DateTime($reservation->endTime ?? '00:00:00');
                        $statusColor = match ($reservation->status) {
                            'pending' => 'orange',
                            'verified' => 'green',
                            'invalid', 'cancelled' => 'red',
                            'completed' => 'gray',
                            default => 'black',
                        };
                    @endphp
                    <div class="reservation-item" 
                        data-id="{{ $reservation->id }}" 
                        data-name="{{ $reservation->customer->name }}" 
                        data-paidAmount="{{ $reservation->paidAmount }}"
                        data-total="{{ $reservation->grandTotal }}" 
                        data-balance="{{ $reservation->balance }}" 
                        data-date="{{ $reservation->date }}"
                        data-start="{{ $reservation->startTime }}" 
                        data-end="{{ $reservation->endTime }}"
                        data-status="{{ $reservation->status }}"
                        style="border-left: 5px solid {{ $statusColor }}; cursor: pointer;">
                        <strong>#{{ $reservation->customer->name }}</strong><br>
                        {{ $reservation->date }} | {{ $reservation->startTime }} - {{ $reservation->endTime }}
                    </div>
                @endforeach
            </div>

        </div>
    </div>
</div>

    <section class="reservation-details hidden">
        <div class="reservation-container">
            <button class="ellipsis-btn">
                <i class="fas fa-ellipsis-h"></i>
            </button>
            <button class="close-btn">&times;</button>
            <div class="menu">
                <!-- Add any necessary menu items here -->
            </div>
            <div class="dropdown-menu hidden text-xs">
                <button class="edit-reservation">Edit Reservation</button>
                <hr>
                <button class="pay-reservation">Pay</button>
                <hr>
                <button class="cancel-reservation">Cancel Reservation</button>
            </div>
            <div class="downpayment-content">
                <div class="reservation-summary">
                    <div class="placeholder-box"></div> <!-- Placeholder for dynamic data -->
                </div>

                <div class="r-details">
                    <p>
                        <strong><span id="name"></span></strong>
                        <span id="status" class="reservation-status"></span>
                    </p>

                    <p><span id="startTime"></span> - <span id="endTime"></span></p>

                    <ul id="modalAmenities"></ul>
                    <hr>
                    <p><strong>Total: <span id="grandTotal"></span></strong></p>
                    <p><strong>Paid Amount: <span id="paidAmount"></span></strong></p>
                    <p><strong>Balance: <span id="balance"></span></strong></p>
                </div>

            </div>
        </div>
    </section>

<!-- Edit Reservation Modal -->
<div class="edit hidden">
    <div class="edit-content">
        <span class="close-modal">&times;</span>
        <h2>EDIT RESERVATION DETAILS</h2>

        <label for="date">Date:</label>
        <input type="date" id="date" placeholder="DD/MM/YYYY">

        <label for="time">Time:</label>
        <input type="time" id="time" placeholder="00:00:00">

        <label for="cottage">Cottage:</label>
        <select id="cottage">
            <option>Select</option>
        </select>

        <label for="table">Table:</label>
        <select id="table">
            <option>Select</option>
        </select>

        <div class="buttons">
            <button class="cancel">Cancel</button>
            <button class="submit">Submit for Verification</button>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
    const reservationItems = document.querySelectorAll(".reservation-item");
    const amenities = @json($allReservations->values()->all());

    reservationItems.forEach(item => {
        item.addEventListener("click", function () {
            const reservationId = item.getAttribute("data-id");
            const reservationName = item.getAttribute("data-name");
            const reservationpaidAmount = item.getAttribute("data-paidAmount");
            const reservationgrandTotal = item.getAttribute("data-total");
            const reservationbalance = item.getAttribute("data-balance");
            const reservationDate = item.getAttribute("data-date");
            const reservationStart = item.getAttribute("data-start");
            const reservationEnd = item.getAttribute("data-end");

            const reservationStatus = item.getAttribute("data-status");
            const statusElement = document.getElementById("status");
            
            if (statusElement) {
                // Capitalize first letter
                const capitalizedStatus = reservationStatus.charAt(0).toUpperCase() + reservationStatus.slice(1);
                statusElement.textContent = capitalizedStatus;

                // Reset class/style
                statusElement.className = "reservation-status";

                // Apply color
                switch (reservationStatus) {
                    case "pending":
                        statusElement.style.color = "orange";
                        break;
                    case "verified":
                        statusElement.style.color = "green";
                        break;
                    case "invalid":
                    case "cancelled":
                        statusElement.style.color = "red";
                        break;
                    case "completed":
                        statusElement.style.color = "gray";
                        break;
                    default:
                        statusElement.style.color = "black";
                }
            }

            document.getElementById("name").textContent = reservationName || '';
            document.getElementById("date").textContent = reservationDate || '';
            document.getElementById("grandTotal").textContent = `Total: ₱${reservationgrandTotal || 0}`;
            document.getElementById("paidAmount").textContent = `Paid Amount: ₱${reservationpaidAmount || 0}`;
            document.getElementById("balance").textContent = `Balance: ₱${reservationbalance || 0}`;
            document.getElementById("startTime").textContent = reservationStart || '';
            document.getElementById("endTime").textContent = reservationEnd || '';
            console.log(reservationpaidAmount, reservationgrandTotal, reservationbalance);
            
            const selectedReservation = amenities.find(r => r.id == reservationId);

            if (selectedReservation) {
                let amenitiesHtml = '';

                selectedReservation.reserved_amenities.forEach(amenity => {
                    const amenityName = amenity.amenity.name;
                    const amenityPrice = amenity.amenity.price;
                    amenitiesHtml += `<li>${amenityName} - ₱${parseFloat(amenityPrice).toFixed(2)}</li>`;
                });

                document.getElementById("modalAmenities").innerHTML = amenitiesHtml;
            }

            document.querySelector(".reservation-details").classList.remove("hidden");

            // Attach click event to Pay button
            document.querySelector(".pay-reservation").addEventListener("click", function () {
                // Redirect to downpayment page with reservationId as a URL parameter
                const url = `/customer/downpayment/${reservationId}`; // Make sure the URL includes the customer prefix
                window.location.href = url;
            });
        });
    });

        // Open the dropdown menu when the 3-dotted icon is clicked
        const ellipsisButtons = document.querySelectorAll(".ellipsis-btn");

        ellipsisButtons.forEach(button => {
            button.addEventListener("click", function (event) {
                const dropdownMenu = event.target.closest(".reservation-container").querySelector(".dropdown-menu");

                // Toggle the visibility of the dropdown menu
                dropdownMenu.classList.toggle("hidden");

                // Prevent event propagation to avoid triggering other click events
                event.stopPropagation();
            });
        });

        // Open the edit modal when the "Edit Reservation" button is clicked
        const editButtons = document.querySelectorAll(".edit-reservation");

        editButtons.forEach(button => {
            button.addEventListener("click", function () {
                // Show the edit modal
                document.querySelector(".edit").classList.remove("hidden");

                // Populate the edit modal with the reservation data (you can add more logic for this if necessary)
                const selectedReservation = {}; // Get the selected reservation data (from the click event or state)

                document.querySelector("#date").value = selectedReservation.date || ''; // Set the date field
                document.querySelector("#time").value = selectedReservation.time || ''; // Set the time field
                // Populate the cottage and table select options dynamically if needed
            });
        });

        // Close the reservation details modal
        const closeDetails = document.querySelector(".close-btn");
        closeDetails.addEventListener("click", function () {
            document.querySelector(".reservation-details").classList.add("hidden");
        });

        // Close the edit modal when the close button is clicked
        const closeModal = document.querySelector(".close-modal");
        closeModal.addEventListener("click", function () {
            document.querySelector(".edit").classList.add("hidden");
        });

        // Close the modal if clicked outside
        window.addEventListener("click", function (event) {
            const editModal = document.querySelector(".edit");
            if (event.target === editModal) {
                editModal.classList.add("hidden");
            }
        });
    });


</script>
</body>

</html>