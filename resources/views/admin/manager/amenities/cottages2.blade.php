<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="{{ asset('css/cottages.css') }}">
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
  <title>Cottages Management</title>
  <script src="https://cdn.tailwindcss.com"></script>
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

  <!-- SIDEBAR SECTION -->
  <div class="container">
    <aside class="sidebar">
      <div class="icon-container">
        <a href="{{ route('admin.cottages') }}">
          <i class="material-icons side-icons">storefront</i>
        </a>
        <p class="icon-label">Cottages</p>
      </div>
      <div class="icon-container">
        <a href="{{ route('admin.tables') }}">
          <i class="material-icons side-icons">dining</i>
        </a>
        <p class="icon-label">Tables</p>
      </div>
    </aside>

    <!-- MAIN SECTION -->
    <main class="main">
      <p class="label">Cottages</p>

      <!-- Add Cottage Form -->
      <form action="{{ route('admin.cottages') }}" method="POST" class="mb-6 flex gap-4">
        @csrf
        <input type="text" name="name" placeholder="Cottage Name" required class="border border-gray-300 rounded-md px-4 py-2 flex-1 focus:outline-none focus:ring-2 focus:ring-blue-400">
        <input type="number" name="price" placeholder="Price" required step="0.01" class="border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Add Cottage</button>
      </form>

      <!-- Toggle Archived Button -->
      <button id="toggleButton" onclick="toggleArchived()" class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700 mb-4">Show Archived Cottages</button>

      <!-- Cottages Table -->
      <table class="table">
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Price</th>
          <th>Actions</th>
        </tr>

        @foreach($cottages as $cottage)
          <tr class="{{ $cottage->is_active ? '' : 'archived' }}" style="{{ $cottage->is_active ? '' : 'display:none;' }}">
            <td>{{ $cottage->id }}</td>
            <td>{{ $cottage->name }}</td>
            <td>₱{{ number_format($cottage->price, 2) }}</td>
            <td>
              <div class="button-wrapper">
                @if($cottage->is_active)
                  <!-- Edit Button -->
                  <i class="material-icons edit-icon" onclick="openEditModal({{ $cottage->id }}, '{{ $cottage->name }}', {{ $cottage->price }})">edit</i>
                  <!-- Archive Button -->
                  <form action="{{ route('cottages.archive', $cottage->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="archive-button">Archive</button>
                  </form>
                @else
                  <!-- Unarchive Button -->
                  <form action="{{ route('cottages.unarchive', $cottage->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="unarchive-button">Unarchive</button>
                  </form>
                @endif
              </div>
            </td>
          </tr>
        @endforeach
      </table>

      <!-- Modal (for Edit) -->
      <dialog class="modal" id="editModal">
        <div class="modal-wrapper">
          <p class="modal-heading">Edit Cottage</p>
          <form id="editForm" method="POST">
            @csrf
            @method('PATCH')
            <input type="hidden" id="edit_id" name="id">
            <label class="block mb-2">Cottage Name</label>
            <input type="text" id="edit_name" name="name" required class="border border-gray-300 px-3 py-2 w-full rounded-md mb-4">
            <label class="block mb-2">Price</label>
            <input type="number" id="edit_price" name="price" required step="0.01" class="border border-gray-300 px-3 py-2 w-full rounded-md mb-4">
            <div class="flex justify-end">
              <button type="button" onclick="closeEditModal()" class="cancel-button">Cancel</button>
              <button type="submit" class="confirm-button">Update</button>
            </div>
          </form>
        </div>
      </dialog>

    </main>
  </div>

  <!-- SCRIPT SECTION -->
  <script>
    // Toggle archived cottages
    function toggleArchived() {
      let archivedRows = document.querySelectorAll(".archived");
      archivedRows.forEach(row => {
        row.style.display = row.style.display === "none" ? "table-row" : "none";
      });

      // Change button text dynamically
      let btn = document.getElementById("toggleButton");
      btn.textContent = btn.textContent === "Show Archived Cottages" ? "Hide Archived Cottages" : "Show Archived Cottages";
    }

    // Edit Modal functions
    function openEditModal(id, name, price) {
      document.getElementById("edit_id").value = id;
      document.getElementById("edit_name").value = name;
      document.getElementById("edit_price").value = price;
      document.getElementById("editForm").setAttribute("action", `/cottages/${id}/update`);
      document.getElementById("editModal").showModal();
    }

    function closeEditModal() {
      document.getElementById("editModal").close();
    }
  </script>
</body>
</html>
