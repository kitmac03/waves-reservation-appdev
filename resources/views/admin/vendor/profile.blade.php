<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/ven_profile.css') }}">
    <link rel="stylesheet" href="{{ asset('css/ven_editprof.css') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <title>Vendor Profile</title>
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
            <a href="{{ route('admin.vendor.amenities', ['type' => 'cottage']) }}">
                <button class="ameneties" id="ameneties">
                    <i class="material-icons nav-icons">holiday_village</i> Amenities
                </button>
            </a>
            <a href="{{ route('admin.vendor.reservation_calendar') }}">
                <button class="reservations" id="reservation">
                    <i class="material-icons nav-icons">date_range</i> Reservations
                </button>
            </a>
        </div>

        <div class="right-side-nav">
            <a href="{{ route('admin.vendor.profile') }}">
                <button class="profile">
                    <i class="material-icons" style="font-size:45px; color: white">
                        account_circle
                    </i>
                </button>
            </a>
        </div>

    </nav>
    <main class="main">
        @yield('profile-content')
    </main>

    @yield('scripts')
</body>

</html>