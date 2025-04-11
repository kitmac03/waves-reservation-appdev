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
  
    <div class="reservations-container">
      <!-- Cancelled Column -->
      <div class="reservation-column">
        <h4>Cancelled</h4>
        @if($cancelledReservations->isEmpty())
            <p class="text-center">No cancelled reservations.</p>
        @else
            @foreach ($cancelledReservations as $reservation)
              <div class="reservation-item cancelled" onclick="showReservationDetails('{{ $reservation->id }}')">
                <strong>{{ $reservation->customer->name ?? 'Unknown' }}</strong><br>
                @php
                  
                  $date = new DateTime($reservation->date);  
                  $startTime = new DateTime($reservation->startTime); 
                  $endTime = new DateTime($reservation->endTime); 
                @endphp
               {{ $date->format('Y-m-d') }} | {{ $startTime->format('g:i A') }} - {{ $endTime->format('g:i A') }}
              </div>
              <section class="reservation-details hidden" id="{{ 'reservationDetails-' . trim($reservation->id) }}">
                <div class="reservation-container">
                    <button class="ellipsis-btn">
                        <i class="fas fa-ellipsis-h"></i>
                    </button>
                    <button class="close-btn" onclick="closeReservationDetails('{{ $reservation->id }}')">&times;</button>
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
                                <strong>{{ $reservation->customer->name ?? 'Unknown' }}</span></strong>
                                <span>{{ $reservation->status }}</span>
                            </p>
            
                            <p><span>{{ \Carbon\Carbon::parse($reservation->date)->format('Y-m-d') }}</span></p>
                            <p><span> {{ \Carbon\Carbon::parse($reservation->startTime)->format('g:i A') }} - {{ \Carbon\Carbon::parse($reservation->endTime)->format('g:i A') }}</span></p>
                            <!-- Add dynamic cottage and table details -->
                            <ul>
                              @foreach ($reservation->reservedAmenities as $amenity)
                                  <li>{{ $amenity->amenity->name }} - {{ number_format($amenity->amenity->price, 2) }}</li>
                              @endforeach
                          </ul>
                            <hr>
                            <p><strong>Total: ${{ number_format($reservation->grandTotal, 2) }}</strong></p>
                            <p><strong>Down Payment: ${{ number_format($reservation->paidAmount, 2) }}</strong></p>
                            <p><strong>Balance: ${{ number_format($reservation->balance, 2) }}</strong></p>
                        </div>
                    </div>
                </div>
            </section>
            @endforeach
        @endif
      </div>

    <!-- Invalid Column -->
      <div class="reservation-column">
        <h4>Invalid</h4>
        @if($invalidReservations->isEmpty())
        <p class="text-center">No invalid reservations.</p>
        @else
          @foreach ($invalidReservations as $reservation)
            <div class="reservation-item cancelled" onclick="showReservationDetails('{{ $reservation->id }}')">
              <strong>{{ $reservation->customer->name ?? 'Unknown' }}</strong><br>
              @php
                  
                  $date = new DateTime($reservation->date);  
                  $startTime = new DateTime($reservation->startTime); 
                  $endTime = new DateTime($reservation->endTime); 
              @endphp
               {{ $date->format('Y-m-d') }} | {{ $startTime->format('g:i A') }} - {{ $endTime->format('g:i A') }}
            </div>
            <section class="reservation-details hidden" id="{{ 'reservationDetails-' . trim($reservation->id) }}">
              <div class="reservation-container">
                  <button class="ellipsis-btn">
                      <i class="fas fa-ellipsis-h"></i>
                  </button>
                  <button class="close-btn" onclick="closeReservationDetails('{{ $reservation->id }}')">&times;</button>
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
                              <strong>{{ $reservation->customer->name ?? 'Unknown' }}</span></strong>
                              <span>{{ $reservation->status }}</span>
                          </p>
          
                          <p><span>{{ \Carbon\Carbon::parse($reservation->date)->format('Y-m-d') }}</span></p>
                          <p><span> {{ \Carbon\Carbon::parse($reservation->startTime)->format('g:i A') }} - {{ \Carbon\Carbon::parse($reservation->endTime)->format('g:i A') }}</span></p>
                          <!-- Add dynamic cottage and table details -->
                          <ul>
                            @foreach ($reservation->reservedAmenities as $amenity)
                                <li>{{ $amenity->amenity->name }} - {{ number_format($amenity->amenity->price, 2) }}</li>
                            @endforeach
                        </ul>
                          <hr>
                          <p><strong>Total: ${{ number_format($reservation->grandTotal, 2) }}</strong></p>
                          <p><strong>Down Payment: ${{ number_format($reservation->paidAmount, 2) }}</strong></p>
                          <p><strong>Balance: ${{ number_format($reservation->balance, 2) }}</strong></p>
                      </div>
                  </div>
              </div>
          </section>
          @endforeach
          @endif
      </div>

          <!-- Current Column -->
      <div class="reservation-column">
        <h4>Current</h4>
        @if($currentReservations->isEmpty())
            <p class="text-center">No current reservations.</p>
        @else
        @foreach ($pendingReservations->sortBy(function ($reservation) {
          // Combine date and startTime into a single DateTime object for sorting
            return new DateTime($reservation->date . ' ' . $reservation->startTime);
        }) as $reservation)
            <div class="reservation-item pending" onclick="console.log('ID: {{ $reservation->id }}'); showReservationDetails('{{ $reservation->id }}')">
              <strong>{{ $reservation->customer->name ?? 'Unknown' }}</strong><br>
                @php
                    // Parse the date and times into DateTime objects
                    $date = new DateTime($reservation->date);  // Date object
                    $startTime = new DateTime($reservation->startTime);  // 24-hour time format
                    $endTime = new DateTime($reservation->endTime);  // 24-hour time format
                @endphp
                {{ $date->format('Y-m-d') }} | {{ $startTime->format('g:i A') }} - {{ $endTime->format('g:i A') }}        
            </div>
            <section class="reservation-details hidden" id="{{ 'reservationDetails-' . trim($reservation->id) }}">
              <div class="reservation-container">
                  <button class="ellipsis-btn">
                      <i class="fas fa-ellipsis-h"></i>
                  </button>
                  <button class="close-btn" onclick="closeReservationDetails('{{ $reservation->id }}')">&times;</button>
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
                              <strong>{{ $reservation->customer->name ?? 'Unknown' }}</span></strong>
                              <span>{{ $reservation->status }}</span>
                          </p>
          
                          <p><span>{{ \Carbon\Carbon::parse($reservation->date)->format('Y-m-d') }}</span></p>
                          <p><span> {{ \Carbon\Carbon::parse($reservation->startTime)->format('g:i A') }} - {{ \Carbon\Carbon::parse($reservation->endTime)->format('g:i A') }}</span></p>
                          <!-- Add dynamic cottage and table details -->
                          <ul>
                            @foreach ($reservation->reservedAmenities as $amenity)
                                <li>{{ $amenity->amenity->name }} - {{ number_format($amenity->amenity->price, 2) }}</li>
                            @endforeach
                        </ul>
                          <hr>
                          <p><strong>Total: ${{ number_format($reservation->grandTotal, 2) }}</strong></p>
                          <p><strong>Down Payment: ${{ number_format($reservation->paidAmount, 2) }}</strong></p>
                          <p><strong>Balance: ${{ number_format($reservation->balance, 2) }}</strong></p>
                      </div>
                  </div>
              </div>
          </section>
        @endforeach
        @foreach ($verifiedReservations->sortBy(function ($reservation) {
              return $reservation->date . ' ' . $reservation->startTime;
              }) as $reservation)
            <div class="reservation-item verified" onclick='showReservationDetails("{{ $reservation->id }}")'>
                <strong>{{ $reservation->customer->name ?? 'Unknown' }}</strong><br>
                  @php
                    $date = new DateTime($reservation->date);  
                    $startTime = new DateTime($reservation->startTime); 
                    $endTime = new DateTime($reservation->endTime); 
                  @endphp
                {{ $date->format('Y-m-d') }} | {{ $startTime->format('g:i A') }} - {{ $endTime->format('g:i A') }}
            </div>
            <section class="reservation-details hidden" id="{{ 'reservationDetails-' . trim($reservation->id) }}">
              <div class="reservation-container">
                  <button class="ellipsis-btn">
                      <i class="fas fa-ellipsis-h"></i>
                  </button>
                  <button class="close-btn" onclick="closeReservationDetails('{{ $reservation->id }}')">&times;</button>
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
                              <strong>{{ $reservation->customer->name ?? 'Unknown' }}</span></strong>
                              <span>{{ $reservation->status }}</span>
                          </p>
          
                          <p><span>{{ \Carbon\Carbon::parse($reservation->date)->format('Y-m-d') }}</span></p>
                          <p><span> {{ \Carbon\Carbon::parse($reservation->startTime)->format('g:i A') }} - {{ \Carbon\Carbon::parse($reservation->endTime)->format('g:i A') }}</span></p>
                          <!-- Add dynamic cottage and table details -->
                          <ul>
                            @foreach ($reservation->reservedAmenities as $amenity)
                                <li>{{ $amenity->amenity->name }} - {{ number_format($amenity->amenity->price, 2) }}</li>
                            @endforeach
                        </ul>
                          <hr>
                          <p><strong>Total: ${{ number_format($reservation->grandTotal, 2) }}</strong></p>
                          <p><strong>Down Payment: ${{ number_format($reservation->paidAmount, 2) }}</strong></p>
                          <p><strong>Balance: ${{ number_format($reservation->balance, 2) }}</strong></p>
                      </div>
                  </div>
              </div>
            </section>
          @endforeach
        @endif
    </div>
      <!-- Completed Column -->
      <div class="reservation-column">
        <h4>Completed</h4>
        @if($completedReservations->isEmpty())
            <p class="text-center">No completed reservations.</p>
        @else
          @foreach ($completedReservations->sortBy(function ($reservation) {
            return $reservation->date . ' ' . $reservation->startTime;
            }) as $reservation)
            <div class="reservation-item verified" onclick='showReservationDetails("{{ $reservation->id }}")'>
                <strong>{{ $reservation->customer->name ?? 'Unknown' }}</strong><br>
                  @php
                    $date = new DateTime($reservation->date);  
                    $startTime = new DateTime($reservation->startTime); 
                    $endTime = new DateTime($reservation->endTime); 
                  @endphp
                  {{ $date->format('Y-m-d') }} | {{ $startTime->format('g:i A') }} - {{ $endTime->format('g:i A') }}
            </div>
            <section class="reservation-details hidden" id="{{ 'reservationDetails-' . trim($reservation->id) }}">
              <div class="reservation-container">
                <button class="ellipsis-btn">
                    <i class="fas fa-ellipsis-h"></i>
                </button>
                <button class="close-btn" onclick="closeReservationDetails('{{ $reservation->id }}')">&times;</button>
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
                          <strong>{{ $reservation->customer->name ?? 'Unknown' }}</span></strong>
                          <span>{{ $reservation->status }}</span>
                      </p>
      
                      <p><span>{{ \Carbon\Carbon::parse($reservation->date)->format('Y-m-d') }}</span></p>
                      <p><span> {{ \Carbon\Carbon::parse($reservation->startTime)->format('g:i A') }} - {{ \Carbon\Carbon::parse($reservation->endTime)->format('g:i A') }}</span></p>
                      <!-- Add dynamic cottage and table details -->
                      <ul>
                        @foreach ($reservation->reservedAmenities as $amenity)
                            <li>{{ $amenity->amenity->name }} - {{ number_format($amenity->amenity->price, 2) }}</li>
                        @endforeach
                    </ul>
                      <hr>
                      <p><strong>Total: ${{ number_format($reservation->grandTotal, 2) }}</strong></p>
                      <p><strong>Down Payment: ${{ number_format($reservation->paidAmount, 2) }}</strong></p>
                      <p><strong>Balance: ${{ number_format($reservation->balance, 2) }}</strong></p>
                    </div>
                  </div>
                </div>
              </div>
            </section>
          @endforeach
        @endif
      </div>
    </div>
  </div>
  

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
  function showReservationDetails(reservationId) {
    // Hide all other modals
    var allDetails = document.querySelectorAll('.reservation-details');
    allDetails.forEach(function(detail) {
        detail.classList.add('hidden');
    });

    // Show the selected one
    var detailSection = document.getElementById('reservationDetails-' + reservationId);
    if (detailSection) {
        detailSection.classList.remove('hidden');
    } else {
        console.log('Details not found for reservation:', reservationId);
    }
  }

  function closeReservationDetails(reservationId) {
      const modal = document.getElementById('reservationDetails-' + reservationId);
      if (modal) {
          modal.classList.add('hidden');
      }
  }
  </script>
</main>

</body>
</html>