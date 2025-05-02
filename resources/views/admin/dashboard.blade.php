<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="{{ asset('css/admin_dashboard.css') }}">
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
    rel="stylesheet">
  <title>Dashboard</title>
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
      @if($user->role === 'Manager')
      <a href="{{ route('admin.manager.profile') }}">
      <button class="profile">
        <i class="material-icons" style="font-size:45px; color: white">
        account_circle
        </i>
      </button>
      </a>
    @elseif($user->role === 'Vendor')
      <a href="{{ route('admin.vendor.profile') }}">
      <button class="profile">
        <i class="material-icons" style="font-size:45px; color: white">
        account_circle
        </i>
      </button>
      </a>
    @endif
    </div>


  </nav>

  <!-- MAIN SECTION -->

  <main class="main">
    <p class="head-title">
      Dashboard Section
    </p>

  </main>

</body>

</html>