<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cottages Management</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        function toggleArchived() {
            let archivedRows = document.querySelectorAll(".archived");
            archivedRows.forEach(row => {
                row.style.display = row.style.display === "none" ? "table-row" : "none";
            });

            // Change button text dynamically
            let btn = document.getElementById("toggleButton");
            btn.textContent = btn.textContent === "Show Archived Cottages" ? "Hide Archived Cottages" : "Show Archived Cottages";
        }
    </script>
</head>
<body class="bg-gray-100 p-6">
    <div class="max-w-5xl mx-auto bg-white p-6 rounded-lg shadow-lg">
        <h1 class="text-2xl font-bold text-center mb-6">Cottages Management</h1>

        <!-- Success Message -->
        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded-lg mb-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- Add Cottage Form -->
        <form action="{{ route('admin.cottages') }}" method="POST" class="mb-6 flex gap-4">
            @csrf
            <input type="text" name="name" placeholder="Cottage Name" required 
                class="border border-gray-300 rounded-md px-4 py-2 flex-1 focus:outline-none focus:ring-2 focus:ring-blue-400">
            <input type="number" name="price" placeholder="Price" required step="0.01" 
                class="border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                Add Cottage
            </button>
        </form>

        <!-- Toggle Archived Button -->
        <button id="toggleButton" onclick="toggleArchived()" 
            class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700 mb-4">
            Show Archived Cottages
        </button>

        <!-- Cottages Table -->
        <div class="overflow-x-auto">
            <table class="w-full border-collapse border border-gray-300 bg-white shadow-md rounded-md">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="border border-gray-300 px-4 py-2">ID</th>
                        <th class="border border-gray-300 px-4 py-2">Name</th>
                        <th class="border border-gray-300 px-4 py-2">Price</th>
                        <th class="border border-gray-300 px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cottages as $cottage)
                        <tr class="{{ $cottage->is_active ? 'active' : 'archived' }}" 
                            style="{{ $cottage->is_active ? '' : 'display:none;' }}">
                            <td class="border border-gray-300 px-4 py-2 text-center">{{ $cottage->id }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $cottage->name }}</td>
                            <td class="border border-gray-300 px-4 py-2 text-center">₱{{ number_format($cottage->price, 2) }}</td>
                            <td class="border border-gray-300 px-4 py-2 text-center">
                                @if($cottage->is_active)
                                    <!-- Edit Button -->
                                    <button class="bg-yellow-500 text-white px-3 py-1 rounded-md hover:bg-yellow-600"
                                        data-id="{{ $cottage->id }}"
                                        data-name="{{ $cottage->name }}"
                                        data-price="{{ $cottage->price }}"
                                        onclick="openEditModal(this)">
                                        Edit
                                    </button>

                                    <!-- Archive Button -->
                                    <form action="{{ route('cottages.archive', $cottage->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded-md hover:bg-red-600">
                                            Archive
                                        </button>
                                    </form>
                                @else
                                    <!-- Unarchive Button -->
                                    <form action="{{ route('cottages.unarchive', $cottage->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="bg-green-500 text-white px-3 py-1 rounded-md hover:bg-green-600">
                                            Unarchive
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal (Hidden Initially) -->
    <div id="editModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg w-96">
            <h2 class="text-lg font-bold mb-4">Edit Cottage</h2>
            <form id="editForm" method="POST">
                @csrf
                @method('PATCH')

                <input type="hidden" id="edit_id" name="id">

                <label class="block mb-2">Cottage Name</label>
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

    <script>
        function openEditModal(button) {
            document.getElementById("edit_id").value = button.getAttribute("data-id");
            document.getElementById("edit_name").value = button.getAttribute("data-name");
            document.getElementById("edit_price").value = button.getAttribute("data-price");
            document.getElementById("editForm").setAttribute("action", `/cottages/${button.getAttribute("data-id")}/update`);
            document.getElementById("editModal").classList.remove("hidden");
        }

        function closeEditModal() {
            document.getElementById("editModal").classList.add("hidden");
        }
    </script>
</body>
</html>
