<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="{{ asset('css/all_res.css') }}">
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
    rel="stylesheet">
  <title>All Reservation</title>
</head>

<body>
  <!-- NAVIGATION BAR SECTION -->

  <nav class="navbar">
    @php
    $user = \App\Models\Admin::find(Auth::id());

    $calendar_route = $user && $user->role === 'Manager'
      ? route('admin.reservation.list')
      : route('admin.vendor.reservation_calendar');

    $amenities_route = $user && $user->role === 'Manager'
      ? route('admin.manager.amenities', ['type' => 'cottage'])
      : route('admin.vendor.amenities', ['type' => 'cottage']);
  @endphp

    <div class="left-side-nav">
      <a href="{{ route('admin.dashboard') }}">
        <button class="dashboard" id="dashboard">
          <i class="material-icons nav-icons">dashboard</i> Dashboard
        </button>
      </a>
      <a href="{{ $amenities_route }}">
        <button class="ameneties" id="ameneties">
          <i class="material-icons nav-icons">holiday_village</i> Amenities
        </button>
      </a>
      <a href="{{ $calendar_route }}">
        <button class="reservations" id="reservation">
          <i class="material-icons nav-icons">date_range</i> Reservations
        </button>
      </a>
    </div>
    <div class="right-side-nav">
      <a href="{{ route('admin.manager.profile') }}">
        <button class="profile">
          <i class="material-icons" style="font-size:45px; color: white">
            account_circle
          </i>
        </button>
      </a>
    </div>
  </nav>

  <!-- MAIN SECTION -->

  <main class="main">

    <!-- HEADER -->
    <div class="header">
      <div class="back-section">
        <a href="{{ route('admin.reservation.list') }}">&larr; Back to Calendar</a>
      </div>
      <div class="title-section">
        All Reservations
      </div>
      <!-- LEGEND -->
      <div class="legend-section">
        <span><span class="dot verified"></span> Verified</span>
        <span><span class="dot pending"></span> Pending</span>
        <span><span class="dot cancelled"></span> Cancelled</span>
        <span><span class="dot completed"></span> Completed</span>
      </div>
    </div>


    <!-- RESERVATION COLUMNS -->
    <div class="reservations-containeroverflow-y-auto">
      <!-- Cancelled Column -->
      <div class="reservation-column">
        <h4>Cancelled</h4>
        @if ($cancelledReservations->isEmpty())
      <p class="text-center">No cancelled reservations.</p>
    @else
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
      <div class="reservation-item" data-id="{{ $reservation->id }}" data-name="{{ $reservation->customer->name }}"
      data-paidAmount="{{ $reservation->paidAmount }}" data-total="{{ $reservation->grandTotal }}"
      data-balance="{{ $reservation->balance }}" data-date="{{ $reservation->date }}"
      data-start="{{ $reservation->startTime }}" data-end="{{ $reservation->endTime }}"
      data-status="{{ $reservation->status }}" style="border-left: 5px solid {{ $statusColor }}; cursor: pointer;">
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
      <div class="reservation-item" data-id="{{ $reservation->id }}" data-name="{{ $reservation->customer->name }}"
      data-paidAmount="{{ $reservation->paidAmount }}" data-total="{{ $reservation->grandTotal }}"
      data-balance="{{ $reservation->balance }}" data-date="{{ $reservation->date }}"
      data-start="{{ $reservation->startTime }}" data-end="{{ $reservation->endTime }}"
      data-status="{{ $reservation->status }}" style="border-left: 5px solid {{ $statusColor }}; cursor: pointer;">
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
      <div class="reservation-item" data-id="{{ $reservation->id }}" data-name="{{ $reservation->customer->name }}"
      data-paidAmount="{{ $reservation->paidAmount }}" data-total="{{ $reservation->grandTotal }}"
      data-balance="{{ $reservation->balance }}" data-date="{{ $reservation->date }}"
      data-start="{{ $reservation->startTime }}" data-end="{{ $reservation->endTime }}"
      data-status="{{ $reservation->status }}" style="border-left: 5px solid {{ $statusColor }}; cursor: pointer;">
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
      <div class="reservation-item" data-id="{{ $reservation->id }}" data-name="{{ $reservation->customer->name }}"
      data-paidAmount="{{ $reservation->paidAmount }}" data-total="{{ $reservation->grandTotal }}"
      data-balance="{{ $reservation->balance }}" data-date="{{ $reservation->date }}"
      data-start="{{ $reservation->startTime }}" data-end="{{ $reservation->endTime }}"
      data-status="{{ $reservation->status }}" style="border-left: 5px solid {{ $statusColor }}; cursor: pointer;">
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
            <p><span id="startTime"></span> - <span id="endTime"></span></p>
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

    <!-- SCRIPT SECTION -->

    <script>

      @section('scripts')
      < script >
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

          // Format times to 24-hour format
          const formatTo12Hour = (time) => {
          const [hours, minutes] = time.split(':');
          const period = hours >= 12 ? 'PM' : 'AM';
          const formattedHours = hours % 12 || 12; // Convert 0 to 12 for 12-hour format
          return `${formattedHours}:${minutes.padStart(2, '0')} ${period}`;
          };

          const formattedStartTime = reservationStart ? formatTo12Hour(reservationStart) : '';
          const formattedEndTime = reservationEnd ? formatTo12Hour(reservationEnd) : '';

          document.getElementById("name").textContent = reservationName || '';
          document.getElementById("date").textContent = reservationDate || '';
          document.getElementById("grandTotal").textContent = `Total: ₱${reservationgrandTotal || 0}`;
          document.getElementById("paidAmount").textContent = `Paid Amount: ₱${reservationpaidAmount || 0}`;
          document.getElementById("balance").textContent = `Balance: ₱${reservationbalance || 0}`;
          document.getElementById("startTime").textContent = formattedStartTime;
          document.getElementById("endTime").textContent = formattedEndTime;
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
        });
        });

        // Close button handler
        const closeDetails = document.querySelector(".close-btn");
        closeDetails.addEventListener("click", function () {
        document.querySelector(".reservation-details").classList.add("hidden");
        });
      });
    </script>
  @endsection

    </script>

</body>

</html>