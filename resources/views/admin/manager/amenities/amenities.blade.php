<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="{{ asset('css/cottages.css') }}">
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
    rel="stylesheet">
  <title>Cottages Management</title>
  <script src="https://cdn.tailwindcss.com"></script>
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

  <!-- SIDEBAR SECTION -->
  <div class="container">
    <aside class="sidebar">
      <div class="icon-container">
        <a href="{{ route('admin.manager.amenities', ['type' => 'cottage']) }}">
          <i class="material-icons side-icons">storefront</i>
        </a>
        <p class="icon-label">Cottages</p>
      </div>
      <div class="icon-container">
        <a href="{{ route('admin.manager.amenities', ['type' => 'table']) }}">
          <i class="material-icons side-icons">dining</i>
        </a>
        <p class="icon-label">Tables</p>
      </div>
    </aside>

    <!-- MAIN SECTION -->
    <main class="main">
      <p class="label">{{ ucfirst($type) }}s</p>
      @if(session('success'))
      <div style="text-xs color: green;">{{ session('success') }}</div>
    @endif
      <!-- Add Cottage Form -->
      <form action="{{ route('amenities.store') }}" method="POST" class="mb-6 mt-6 flex gap-4">
        @csrf
        <input type="text" name="name" placeholder="Amenity Name" required
          class="border border-gray-300 rounded-md px-4 py-2 flex-1 focus:outline-none focus:ring-2 focus:ring-blue-400">
        <input type="number" name="price" placeholder="Price" required step="0.01"
          class="border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">

        <!-- Select input for type (Cottage or Table) -->
        <select name="type" required
          class="border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
          <option value="" disabled selected>Select</option>
          <option value="cottage">Cottage</option>
          <option value="table">Table</option>
        </select>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Add Amenity</button>
      </form>

      <!-- Toggle Archived Button -->
      <button id="toggleButton" onclick="toggleArchived()"
        class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700 mb-4">Show Archived
        {{ ucfirst($type) }}</button>

      <!--Amenity Table -->
      @yield('amenities-content')

    </main>
  </div>
  <!-- SCRIPT SECTION -->
  @yield('scripts')
</body>

</html>