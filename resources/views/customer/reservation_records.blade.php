<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>WAVES Beach Resort</title>
    <link rel="stylesheet" href="{{ asset('css/reservation_records.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<div class="container">
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="back-button">
            <a href="{{ route('customer.reservation') }}" class="back-btn">
                <i class="fas fa-chevron-left"></i>
                <span>Back to main</span>
            </a>
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

        <!-- logout -->
        <form id="logoutForm" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf <!-- CSRF Token for security -->
        </form>

        <button id="logoutButton" class="logout">
            <i class="fas fa-sign-out-alt"></i> Log Out
        </button>

        <script>
            document.getElementById('logoutButton').addEventListener('click', function () {
                document.getElementById('logoutForm').submit();
            });
        </script>
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
                @foreach($cancelledReservations as $reservation)
                    <div class="reservation-item" style="border-left: 5px solid red;">
                        <strong>#{{ $reservation->id }}</strong><br>
                        {{ $reservation->date }} | {{ $reservation->startTime }} - {{ $reservation->endTime }}
                    </div>
                @endforeach
            </div>
            <div class="reservation-column">
                <h4>Invalid</h4>
                @foreach($invalidReservations as $reservation)
                    <div class="reservation-item" data-id="{{ $reservation->id }}" data-date="{{ $reservation->date }}"
                        data-start="{{ $reservation->startTime }}" data-end="{{ $reservation->endTime }}"
                        style="border-left: 5px solid red; cursor: pointer;">
                        <strong>#{{ $reservation->id }}</strong><br>
                        {{ $reservation->date }} | {{ $reservation->startTime }} - {{ $reservation->endTime }}
                    </div>
                @endforeach
            </div>
            <div class="reservation-column">
                <h4>Current</h4>

                @foreach($pendingReservations as $reservation)
                    <div class="reservation-item" data-id="{{ $reservation->id }}" data-date="{{ $reservation->date }}"
                        data-start="{{ $reservation->startTime }}" data-end="{{ $reservation->endTime }}"
                        style="border-left: 5px solid orange; cursor: pointer;">
                        <strong>#{{ $reservation->id }}</strong><br>
                        {{ $reservation->date }} | {{ $reservation->startTime }} - {{ $reservation->endTime }}
                    </div>
                @endforeach

                @foreach($verifiedReservations as $reservation)
                    <div class="reservation-item" data-id="{{ $reservation->id }}" data-date="{{ $reservation->date }}"
                        data-start="{{ $reservation->startTime }}" data-end="{{ $reservation->endTime }}"
                        style="border-left: 5px solid green; cursor: pointer;">
                        <strong>#{{ $reservation->id }}</strong><br>
                        {{ $reservation->date }} | {{ $reservation->startTime }} - {{ $reservation->endTime }}
                    </div>
                @endforeach
            </div>


            <div class="reservation-column">
                <h4>Past</h4>
                @foreach($completedReservations as $reservation)
                    <div class="reservation-item" style="border-left: 5px solid gray;">
                        <strong>#{{ $reservation->id }}</strong><br>
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
        <div class="dropdown-menu hidden">
            <button class="edit-reservation">Edit Reservation</button>
            <hr>
            <button class="cancel-reservation">Cancel Reservation</button>
        </div>
        <div class="downpayment-content">
            <div class="reservation-summary">
                <div class="placeholder-box"></div> <!-- Placeholder for dynamic data -->
            </div>

            <div class="r-details">
                <p>
                    <strong>#<span class="reservation-id"></span></strong>
                    <span class="verified {{ $reservation->status === 'verified' ? 'verified' : 'pending' }}">
                        {{ $reservation->status }}
                    </span>
                </p>

                <p><span class="reservation-date"></span></p>
                <p><span class="reservation-start"></span></p>
                <!-- Add dynamic cottage and table details -->
                <p><span class="cottage-type"></span> - <strong><span class="cottage-price"></span></strong></p>
                <p><span class="table-type"></span> - <strong><span class="table-price"></span></strong></p>
                <hr>
                <p><strong>Total: <span class="total-price"></span></strong></p>
                <p><strong>Down Payment: <span class="down-payment"></span></strong></p>
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

        <label for="time">Start Time:</label>
        <input type="time" id="starttime" placeholder="00:00:00">

        <label for="time">End Time:</label>
        <input type="time" id="endtime" placeholder="00:00:00">

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

        reservationItems.forEach(item => {
            item.addEventListener("click", function () {
                const reservationId = item.getAttribute("data-id");
                const reservationDate = item.getAttribute("data-date");
                const reservationStart = item.getAttribute("data-start");
                const reservationEnd = item.getAttribute("data-end");

                // Populate the reservation details modal with the selected reservation data
                document.querySelector(".reservation-id").textContent = reservationId;
                document.querySelector(".reservation-date").textContent = reservationDate;
                document.querySelector(".reservation-start").textContent = reservationStart;

                // Fetch the reservations data passed by the controller (pending + verified)
                const reservations = @json($pendingReservations->merge($verifiedReservations));

                // Find the selected reservation data based on reservationId
                const selectedReservation = reservations.find(reservation => reservation.id == reservationId);

                // If the reservation is not found, handle the error
                if (!selectedReservation) {
                    console.error("Reservation not found!");
                    return;
                }

                // Initialize variables to store cottage and table information
                let cottageType = '';
                let cottagePrice = '';
                let tableType = '';
                let tablePrice = '';

                // Iterate through reserved amenities and fetch relevant data
                selectedReservation.reserved_amenities.forEach(amenity => {
                    if (amenity.amenity.type === 'cottage') {
                        cottageType = amenity.amenity.name;
                        cottagePrice = amenity.amenity.price;
                    }
                    if (amenity.amenity.type === 'table') {
                        tableType = amenity.amenity.name;
                        tablePrice = amenity.amenity.price;
                    }
                });

                // Populate the modal with the fetched amenities data
                document.querySelector(".cottage-type").textContent = cottageType;
                document.querySelector(".cottage-price").textContent = cottagePrice;
                document.querySelector(".table-type").textContent = tableType;
                document.querySelector(".table-price").textContent = tablePrice;

                // Calculate total and down payment
                const totalPrice = parseFloat(cottagePrice || 0) + parseFloat(tablePrice || 0);
                const downPayment = totalPrice / 2; // You can replace this with your actual down payment logic

                document.querySelector(".total-price").textContent = totalPrice.toFixed(2); // Ensure proper formatting
                document.querySelector(".down-payment").textContent = downPayment.toFixed(2); // Format down payment

                // Dynamically set the reservation status class and status text
                const statusElement = document.querySelector(".verified");

                if (selectedReservation.status === 'verified') {
                    statusElement.classList.add("verified"); // Apply the verified class
                    statusElement.classList.remove("pending");
                    statusElement.textContent = "Verified";

                    document.querySelector(".ellipsis-btn").classList.add("hidden");
                }

                if (selectedReservation.status === 'pending') {
                    statusElement.classList.add("pending"); // Apply the pending class
                    statusElement.classList.remove("verified");
                    statusElement.textContent = "Pending";
                    statusElement.classList.add("verified"); // STUPID AHH LINE???

                    document.querySelector(".ellipsis-btn").classList.remove("hidden");
                }

                // Show the modal
                document.querySelector(".reservation-details").classList.remove("hidden");
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

        // Cancel reservation with confirmation
        const cancelButtons = document.querySelectorAll(".cancel-reservation");

        cancelButtons.forEach(button => {
            button.addEventListener("click", function () {
                const reservationId = document.querySelector(".reservation-id").textContent;

                if (confirm("Are you sure you want to cancel this reservation?")) {
                    fetch(`/customer/reservation-records/${reservationId}/cancel`, {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({ id: reservationId })
                    })
                        .then(response => {
                            if (response.ok) {
                                alert("Reservation cancelled successfully.");
                                location.reload();
                            } else {
                                alert("Failed to cancel reservation.");
                            }
                        })
                        .catch(error => {
                            console.error("Error:", error);
                            alert("An error occurred.");
                        });
                }
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