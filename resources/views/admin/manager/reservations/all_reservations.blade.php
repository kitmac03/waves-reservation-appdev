<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="{{ asset('css/all_res.css') }}">
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
  <title>All Reservation</title>
</head>
<body>
   <!-- NAVIGATION BAR SECTION -->

  <nav class="navbar">

    <div class="left-side-nav">
      <a href="dashboard.html">
        <button class="dashboard" id="dashboard">
          <i class="material-icons nav-icons">dashboard</i> Dashboard
        </button>
      </a>
      <a href="cottages.html">
        <button class="ameneties" id="ameneties">
          <i class="material-icons nav-icons">holiday_village</i> Amenities
        </button>
      </a>
      <a href="reservations.html">
        <button class="reservations" id="reservation">
          <i class="material-icons nav-icons">date_range</i> Reservations
        </button>
      </a>
    </div>

    <div class="right-side-nav">
      <a href="manager_profile.html">
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
        <a href="reservations.html">&larr; Back to Calendar</a>
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
    <div class="reservations-container">
      <!-- Cancelled -->
      <div class="column">
        <h2>Cancelled</h2>
        <div class="reservation cancelled-res">
          <div class="details">#6 Maria Sanchez<br><small>2024-11-24</small></div>
          <div class="time">8:00 AM</div>
        </div>
        <div class="reservation cancelled-res">
          <div class="details">#2 Zuleika Yee<br><small>2023-01-20</small></div>
          <div class="time">12:00 PM</div>
        </div>
      </div>

      <!-- Current -->
      <div class="column">
        <h2>Current</h2>
        <div class="reservation verified-res">
          <div class="details" onclick="clickReservation()">#7 Manny Pacquiao<br><small>2024-10-18</small></div>
          <div class="time">1:00 PM</div>
        </div>
        <div class="reservation pending-res">
          <div class="details">#8 Erikka Yee<br><small>2024-10-19</small></div>
          <div class="time">4:00 PM</div>
        </div>
        <div class="reservation pending-res">
          <div class="details">#9 Tokkio Yee<br><small>2024-12-25</small></div>
          <div class="time">6:00 PM</div>
        </div>
      </div>

      <!-- Completed -->
      <div class="column">
        <h2>Completed</h2>
        <div class="reservation completed-res">
          <div class="details">#5 Nikkita Yee<br><small>2024-09-09</small></div>
          <div class="time">11:00 AM</div>
        </div>
        <div class="reservation completed-res">
          <div class="details">#4 Olivia Rodrigo<br><small>2024-01-27</small></div>
          <div class="time">9:00 AM</div>
        </div>
        <div class="reservation completed-res">
          <div class="details">#3 Manny Pacquiao<br><small>2023-09-01</small></div>
          <div class="time">10:00 AM</div>
        </div>
        <div class="reservation completed-res">
          <div class="details">#1 Feranz Salonga<br><small>2022-02-11</small></div>
          <div class="time">1:00 PM</div>
        </div>
      </div>
    </div>
  </main>

  <!-- MODAL SECTION -->
  <dialog class="reservation-modal">
    <div class="dialog-container">

      <div class="dialog-header">
        <div class="dialog-head-text">
          <p class="id">#7</p>
          <p class="name">Manny Pacquiao</p>
          <p class="status">VERIFIED</p>
        </div>

        <div dialog-head-button>
          <i class="material-icons more-icon">more_horiz</i>
          <i class="material-icons close-icon" onclick="closeDialog()">close</i>
        </div>
      </div>

      <div class="dialog-details">
        <p class>2024-10-18</p>
        <p>1:00 PM</p>
        <p>Full Cottage - <b class="price">1,000</b></p>
        <p>Round Table w/3 chairs - <b>150</b></p>
        <hr>
      </div>

      <div class="dialog-figures">
        <p>Total: Php 1,150</p>
        <p>Down Payment: Php 575</p>
        <p>Remaining Balance: Php 575</p>
      </div>

    </div>
  </dialog>

  <!-- SCRIPT SECTION -->

  <script>

    const modal = document.querySelector('.reservation-modal');

    function clickReservation() {
      modal.showModal();
    }

    function closeDialog() {
      modal.close();
    }


  </script>

  <script src="../js/navbutton.js"></script>


  
</body>
</html>