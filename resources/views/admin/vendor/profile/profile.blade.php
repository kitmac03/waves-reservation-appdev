@extends('admin.vendor.profile')

@section('styles')
  <link rel="stylesheet" href="{{ asset('css/ven_profile.css') }}">
  <link rel="stylesheet" href="{{ asset('css/ven_editprof.css') }}">
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
@endsection

@section('profile-content')
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
  </nav>

  <!-- MAIN CONTENT SECTION -->
  <main class="profile-section">
      <div class="profile-card">
          <h2 class="profile-title">Your Admin Profile</h2>

          <div id="confirmModal" class="modal">
              <div class="modal-content">
                  <p>Are you sure you want to logout?</p> 
                  <div class="modal-buttons">
                      <button class="btn-cancel-modal" id="cancelModalBtn">Cancel</button>
                      <button class="btn-yes" id="yesBtn">Yes</button>
                  </div>
              </div>
          </div>

          @if(session('success'))
          <div class="alert alert-success" style="color: green; font-size: 18px;">
              <i class="fas fa-check-circle"></i> {{ session('success') }}
          </div>
          @endif

          <div class="profile-content">
              <div class="profile-avatar">
                  <div class="avatar-circle">
                      <i class="fas fa-user-circle"></i>
                  </div>
              </div>

              <div class="profile-details">
                  <div class="detail-item name">
                      <span>{{ $admin->name }}</span>
                  </div>

                  <div class="detail-item name">
                      <span class="position-text"></span>
                  </div>

                  <div class="detail-item">
                      <i class="fas fa-envelope"></i>
                      <span>{{ $admin->email }}</span>
                  </div>

                  <div class="detail-item">
                      <i class="fas fa-phone"></i>
                      <span>{{ $admin->number }}</span>
                  </div>
              </div>
          </div>

          <div class="actions">
              <a href="{{ route('admin.vendor.profile.edit', ['id' => $admin->id]) }}" class="edit-btn">
                  Edit Profile
              </a>

              <a href="javascript:void(0);" class="logout-btn" id="logoutBtn">
                  Log Out
              </a>

              <!-- Hidden Logout Form -->
              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                  @csrf
              </form>
          </div>
      </div>
  </main>

  @section('scripts')
    <script>
      // Get modal elements
      const modal = document.getElementById("confirmModal");
      const cancelBtn = document.getElementById("cancelModalBtn");
      const yesBtn = document.getElementById("yesBtn");
      const logoutBtn = document.getElementById("logoutBtn");

      // Show the modal when logout button is clicked
      logoutBtn.addEventListener("click", function() {
        modal.style.display = "block";
      });

      // If the user clicks cancel, close the modal
      cancelBtn.addEventListener("click", function() {
        modal.style.display = "none";
      });

      // If the user confirms logout, submit the logout form
      yesBtn.addEventListener("click", function() {
        document.getElementById('logout-form').submit();
      });

      // Close modal if clicked outside of the modal content
      window.addEventListener("click", function(event) {
        if (event.target === modal) {
          modal.style.display = "none";
        }
      });
    </script>
  @endsection
@endsection