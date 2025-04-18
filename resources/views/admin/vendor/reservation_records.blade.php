<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/venhistory.css') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
    rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Jaldi&family=Allura&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Jaldi&family=Allura&display=swap" rel="stylesheet">
    <title>Reservation History</title>
</head>

<body>
    <!-- NAVIGATION BAR SECTION -->
    <nav class="navbar">
        <div class="left-side-nav">
            <a href="dashboard.html">
                <button class="dashboard inactive" id="dashboard">
                    <i class="material-icons nav-icons">dashboard</i> Dashboard
                </button>
            </a>
            <a href="ameneties.html">
                <button class="ameneties" id="ameneties">
                    <i class="material-icons nav-icons">holiday_village</i> Ameneties
                </button>
            </a>
            <a href="reservations.html">
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
        <h2 class="head-title">All Reservations</h2>

        <div class="status-bar">
            <span style="color: green;">● Verified</span>
            <span style="color: orange;">● Pending</span>
            <span style="color: red;">● Cancelled</span>
            <span style="color: gray;">● Past</span>
        </div>

        <div class="reservations-container overflow-y-auto">
            <!-- Cancelled Column -->
            <div class="reservation-column">
                <h4>Cancelled</h4>
                @if ($cancelledReservations->isEmpty())
                    <p class="text-center">No cancelled reservations.</p>
                @else
                    @foreach ($cancelReservations->sortBy(fn($reservation) => new DateTime($reservation->date . ' ' . $reservation->startTime)) as $reservation)
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
                            <strong>{{ $reservation->customer->name ?? 'Unknown' }}</strong><br>
                            @php

                                $date = new DateTime($reservation->date);
                                $startTime = new DateTime($reservation->startTime);
                                $endTime = new DateTime($reservation->endTime);
                            @endphp
                            {{ $date->format('Y-m-d') }} | {{ $startTime->format('g:i A') }} -
                            {{ $endTime->format('g:i A') }}
                        </div>
                    @endforeach
                @endif
            </div>

            <!-- Invalid Column -->
            <div class="reservation-column overflow-y-auto">
                <h4>Invalid</h4>
                @if ($invalidReservations->isEmpty())
                    <p class="text-center">No invalid reservations.</p>
                @else
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
                            <strong>{{ $reservation->customer->name ?? 'Unknown' }}</strong><br>
                            @php

                                $date = new DateTime($reservation->date);
                                $startTime = new DateTime($reservation->startTime);
                                $endTime = new DateTime($reservation->endTime);
                            @endphp
                            {{ $date->format('Y-m-d') }} | {{ $startTime->format('g:i A') }} -
                            {{ $endTime->format('g:i A') }}
                        </div>
                    @endforeach
                @endif
            </div>

            <!-- Current Column -->
            <div class="reservation-column overflow-y-auto">
					<h4>Current</h4>
			  
					@if ($currentReservations->isEmpty())
						 <p class="text-center">No current reservations.</p>
					@else
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
									<strong>{{ $reservation->customer->name ?? 'Unknown Customer' }}</strong><br>
									{{ $date->format('Y-m-d') }} |
									{{ $startTime->format('g:i A') }} -
									{{ $endTime->format('g:i A') }}
							  </div>
						 @endforeach
					@endif
			  </div>
            <!-- Completed Column -->
            <div class="reservation-column overflow-y-auto">
                <h4>Completed</h4>
                @if ($completedReservations->isEmpty())
                    <p class="text-center">No completed reservations.</p>
                @else
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
                            <strong>{{ $reservation->customer->name ?? 'Unknown' }}</strong><br>
                            @php
                                $date = new DateTime($reservation->date);
                                $startTime = new DateTime($reservation->startTime);
                                $endTime = new DateTime($reservation->endTime);
                            @endphp
                            {{ $date->format('Y-m-d') }} | {{ $startTime->format('g:i A') }} -
                            {{ $endTime->format('g:i A') }}
                        </div>
                    @endforeach
                @endif
            </div>
        </div>

		<section class="reservation-details hidden">
            <div class="reservation-container">
                <button class="ellipsis-btn">
                    <i class="fas fa-ellipsis-h"></i>
                </button>
                <button class="close-btn">&times;</button>
                <div class="menu">
                </div>
                <div class="dropdown-menu hidden">
                    <button class="edit-reservation">Edit Reservation</button>
                    <hr>
                    <button class="cancel-reservation">Cancel Reservation</button>
                </div>
                <div class="downpayment-content">
                    <div class="reservation-summary">
                        <div class="placeholder-box"></div>
                    </div>
                    <div class="r-details ms-0 ps-0">
                        <p>
                            <strong><span class="reservation-name" id="name"></span></strong>
                            <span id="status" class="reservation-status"></span>
                        </p>

                        <p><span id="date"></span>
                        </p>
                        <p><span id="startTime"> - </span><span id="endTime"></span></p>
                            <ul id="modalAmenities"></ul>
                        <hr>
                        <p><strong id="grandTotal">Total: </strong>
                        </p>
                        <p><strong id="paidAmount">paid Amount:</strong></p>
                        <p><strong id="balance">Balance: </strong></p>
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
                <input type="date" id="date">

                <label for="time">Time:</label>
                <input type="time" id="time">

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
			const amenities = @json($reservations->values()->all());

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

					document.querySelector(".reservation-details").classList.remove("hidden");
				});
			});

			// Close button handler
			const closeDetails = document.querySelector(".close-btn");
			closeDetails.addEventListener("click", function () {
				document.querySelector(".reservation-details").classList.add("hidden");
			});
		});
        </script>
    </main>
</body>
</html>
