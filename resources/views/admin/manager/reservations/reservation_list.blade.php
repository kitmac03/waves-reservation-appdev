<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="{{ asset('css/res_list.css') }}">
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
  <title>Reservation</title>
</head>
<body>
   <!-- NAVIGATION BAR SECTION -->

  <nav class="navbar">

    <div class="left-side-nav">
      <a href="{{ route('admin.dashboard') }}">
        <button class="dashboard" id="dashboard">
          <i class="material-icons nav-icons">dashboard</i> Dashboard
        </button>
      </a>
      <a href="{{ route('admin.cottages') }}">
        <button class="ameneties" id="ameneties">
          <i class="material-icons nav-icons">holiday_village</i> Amenities
        </button>
      </a>
      <a href="{{ route('admin.reservation.list') }}">
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

    <div class="calendar-header">
      <p>October 2024</p>
      <div class="dropdowns">
        <a href="{{ route('admin.all.reservations') }}">
          <button>
            Reservation
          </button>
        </a>
        <select>
          <option>October</option>
        </select>
        <select>
          <option>2024</option>
        </select>
      </div>

      <div class="status-legend">
        <div class="status"><div class="dot verified"></div> Verified</div>
        <div class="status"><div class="dot pending"></div> Pending</div>
        <div class="status"><div class="dot cancelled"></div> Cancelled</div>
        <div class="status"><div class="dot completed"></div> Completed</div>
      </div>
    </div>
  
    <div class="calendar">
      <!-- Day headers -->
      <div class="day-header">Sun</div>
      <div class="day-header">Mon</div>
      <div class="day-header">Tue</div>
      <div class="day-header">Wed</div>
      <div class="day-header">Thu</div>
      <div class="day-header">Fri</div>
      <div class="day-header">Sat</div>
  
      <!-- Empty slots for days before the 1st -->
      <div class="calendar-day"></div>
      <div class="calendar-day"></div>
      <div class="calendar-day">1</div>
      <div class="calendar-day">2</div>
      <div class="calendar-day">3</div>
      <div class="calendar-day">4</div>
      <div class="calendar-day">5</div>
  
      <!-- Fill out the rest of the days -->
      <!-- Use empty <div class="calendar-day"></div> where needed -->
  
      <!-- 18th - with reservation -->
      <div class="calendar-day">6</div>
      <div class="calendar-day">7</div>
      <div class="calendar-day">8</div>
      <div class="calendar-day">9</div>
      <div class="calendar-day">10</div>
      <div class="calendar-day">11</div>
      <div class="calendar-day">12</div>
  
      <div class="calendar-day">13</div>
      <div class="calendar-day">14</div>
      <div class="calendar-day">15</div>
      <div class="calendar-day">16</div>
      <div class="calendar-day">17</div>
      <div class="calendar-day">
        18
        <div class="reservation verified">Manny Pacquiao - 13:00</div>
      </div>
      <div class="calendar-day">
        19
        <div class="reservation pending">Erikka Yee - 16:00</div>
      </div>
  
      <!-- Remaining days -->
      <div class="calendar-day">20</div>
      <div class="calendar-day">21</div>
      <div class="calendar-day">22</div>
      <div class="calendar-day">23</div>
      <div class="calendar-day">24</div>
      <div class="calendar-day">25</div>
      <div class="calendar-day">26</div>
  
      <div class="calendar-day">27</div>
      <div class="calendar-day">28</div>
      <div class="calendar-day">29</div>
      <div class="calendar-day">30</div>
      <div class="calendar-day">31</div>
      <div class="calendar-day"></div>
      <div class="calendar-day"></div>
    </div>

  </main>

  <script src="../js/navbutton.js"></script>


  
</body>
</html>