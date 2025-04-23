<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/tables.css') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <title>Tables</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        // Toggle the archived tables visibility
        function toggleArchived() {
            let archivedRows = document.querySelectorAll(".archived");
            archivedRows.forEach(row => {
                row.style.display = row.style.display === "none" ? "table-row" : "none";
            });

            let btn = document.getElementById("toggleButton");
            btn.textContent = btn.textContent === "Show Archived Tables" ? "Hide Archived Tables" : "Show Archived Tables";
        }

        // Open Edit Modal
        function openEditModal(button) {
            document.getElementById("edit_id").value = button.getAttribute("data-id");
            document.getElementById("edit_name").value = button.getAttribute("data-name");
            document.getElementById("edit_price").value = button.getAttribute("data-price");
            document.getElementById("editForm").setAttribute("action", `/admin/tables/${button.getAttribute("data-id")}/update`);
            document.getElementById("editModal").classList.remove("hidden");
        }

        // Close Edit Modal
        function closeEditModal() {
            document.getElementById("editModal").classList.add("hidden");
        }
    </script>

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
            <p class="label">Tables</p>

            <!-- Add Table Form -->
            <form action="{{ route('tables.store') }}" method="POST" class="mb-6 flex gap-4">
                @csrf
                <input type="text" name="name" placeholder="Table Name" required
                    class="border border-gray-300 rounded-md px-4 py-2 flex-1 focus:ring-2 focus:ring-blue-400">
                <input type="number" name="price" placeholder="Price" required step="0.01"
                    class="border border-gray-300 rounded-md px-4 py-2 focus:ring-2 focus:ring-blue-400">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                    Add Table
                </button>
            </form>

            <!-- Toggle Archived Tables -->
            <button id="toggleButton" onclick="toggleArchived()"
                class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700 mb-4">
                Show Archived Tables
            </button>

            <!-- Table of Available Tables -->
            <table class="table">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Actions</th>
                </tr>

                @foreach($tables as $table)
                    <tr class="{{ $table->is_active ? 'active' : 'archived' }}"
                        style="{{ $table->is_active ? '' : 'display:none;' }}">
                        <td>{{ $table->id }}</td>
                        <td>{{ $table->name }}</td>
                        <td>₱{{ number_format($table->price, 2) }}</td>
                        <td>
                            @if($table->is_active)
                                <div class="button-wrapper">
                                    <i class="material-icons edit-icon" onclick="openEditModal(this)" data-id="{{ $table->id }}"
                                        data-name="{{ $table->name }}" data-price="{{ $table->price }}">edit</i>
                                    <form action="{{ route('tables.archive', $table->id) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="archive-button">
                                            Archive
                                        </button>
                                    </form>
                                </div>
                            @else
                                <form action="{{ route('tables.unarchive', $table->id) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="unarchive-button">
                                        Unarchive
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </table>

            <!-- Modal for Editing Table -->
            <div id="editModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 hidden">
                <div class="bg-white p-6 rounded-lg shadow-lg w-96">
                    <h2 class="text-lg font-bold mb-4">Edit Table</h2>
                    <form id="editForm" method="POST">
                        @csrf
                        @method('PATCH')

                        <input type="hidden" id="edit_id" name="id">

                        <label class="block mb-2">Table Name</label>
                        <input type="text" id="edit_name" name="name" required
                            class="border border-gray-300 px-3 py-2 w-full rounded-md mb-4">

                        <label class="block mb-2">Price</label>
                        <input type="number" id="edit_price" name="price" required step="0.01"
                            class="border border-gray-300 px-3 py-2 w-full rounded-md mb-4">

                        <div class="flex justify-end">
                            <button type="button" onclick="closeEditModal()"
                                class="bg-gray-500 text-white px-3 py-1 rounded-md hover:bg-gray-600 mr-2">
                                Cancel
                            </button>
                            <button type="submit" class="bg-blue-500 text-white px-3 py-1 rounded-md hover:bg-blue-600">
                                Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>

    <script src="../js/navbutton.js"></script>
</body>

</html>