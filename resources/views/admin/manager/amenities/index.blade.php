@extends('admin.manager.amenities.amenities')

@section('amenities-content')
<!-- Cottages Table -->
<table class="table">
  <tr>
    <th>ID</th>
    <th>Name</th>
    <th>Price</th>
    <th>Actions</th>
  </tr>

  @foreach($amenities as $amenity)
    <tr class="{{ $amenity->is_active ? '' : 'archived' }}" style="{{ $amenity->is_active ? '' : 'display:none;' }}">
      <td>{{ $amenity->id }}</td>
      <td>{{ $amenity->name }}</td>
      <td>₱{{ number_format($amenity->price, 2) }}</td>
      <td>
        <div class="button-wrapper">
          @if($amenity->is_active)
            <!-- Edit Button -->
            <i class="material-icons edit-icon" onclick="openEditModal({{ $amenity->id }}, '{{ $amenity->name }}', {{ $amenity->price }}, '{{ $amenity->type }}')">edit</i>
            <!-- Archive Button -->
            <form action="{{ route('amenitys.archive', $amenity->id) }}" method="POST" style="display:inline;">
              @csrf
              @method('PATCH')
              <button type="submit" class="archive-button">Archive</button>
            </form>
          @else
            <!-- Unarchive Button -->
            <form action="{{ route('amenitys.unarchive', $amenity->id) }}" method="POST" style="display:inline;">
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
    <p class="modal-heading">Edit {{ ucfirst($type) }}</p>
    <form id="editForm" method="POST">
      @csrf
      @method('PATCH')
      <input type="hidden" id="edit_id" name="id">
      <label class="block mb-2">{{ ucfirst($type) }} Name</label>
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
@endsection

@section('scripts')
  <!-- SCRIPT SECTION -->
<script>
  // Toggle archived cottages
  // Toggle archived amenities
  function toggleArchived() {
    let archivedRows = document.querySelectorAll(".archived");
    archivedRows.forEach(row => {
      row.style.display = row.style.display === "none" ? "table-row" : "none";
    });

    // Change button text dynamically
    let btn = document.getElementById("toggleButton");
    btn.textContent = btn.textContent === "Show Archived {{ ucfirst($type) }}" ? "Hide Archived {{ ucfirst($type) }}" : "Show Archived {{ ucfirst($type) }}";
  }

  // Edit Modal functions
  function openEditModal(id, name, price, type) {
    document.getElementById("edit_id").value = id;
    document.getElementById("edit_name").value = name;
    document.getElementById("edit_price").value = price;
    
    // Set the action dynamically based on the amenity type (cottage or table)
    document.getElementById("editForm").setAttribute("action", `/admin/${type}s/${id}/update`);
    
    document.getElementById("editModal").showModal();
  }

  function closeEditModal() {
    document.getElementById("editModal").close();
  }
</script>
@endsection
