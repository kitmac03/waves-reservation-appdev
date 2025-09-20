<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manager's Profile</title>
  <link rel="stylesheet" href="{{ asset('css/manager_profile.css') }}">
  <link rel="stylesheet" href="../css/manager_profile.css">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
    rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body>

  <div class="container">

    <!--- SIDEBAR SECTION -->
    <div class="sidebar">
      <a href="{{ route('admin.dashboard') }}">
        <div class="back-to-main">
          <i class="material-icons">arrow_back</i>
          <p>Back to main</p>
        </div>
      </a>

      <div class="profile">
        <div class="profile-icon">
          <i class="material-icons">account_circle</i>
        </div>
        <p>Manager's Profile</p>
      </div>

      <!--- MENU SECTION -->
      <ul class="menu">
        <a href="{{ route('admin.manager.profile') }}">
          <li class="menu-item active">Profile</li>
        </a>
        <a href="{{ route('admin.create.account') }}">
          <li class="menu-item">Create Admin Account</li>
        </a>
        <a href="{{ route('admin.vendors.list') }}">
          <li class="menu-item">List of Vendors</li>
        </a>
        <a href="{{ route('admin.delete.requests') }}">
          <li class="menu-item">
            Account Deletion Requests
          </li>
        </a>
      </ul>
    </div>

    <!--- MAIN CONTENT SECTION -->
    <main class="profile-section">
      <div class="profile-card">
        <h2 class="profile-title">Manager's Profile</h2>

        @if(session('success'))
      <div class="alert alert-success" style="color: green; font-size: 12px;">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
      </div>
    @endif

        <!-- Error Messages (e.g., email already taken) -->
        @if($errors->any())
        <div class="alert alert-error" style="color: red; font-size: 14px;">
          <ul>
          @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
          </ul>
        </div>
    @endif
        <div class="profile-content">
          <div class="profile-avatar">
            <div class="avatar-circle">
              <i class="fas fa-user"></i>
            </div>
          </div>

          <div class="profile-details">
            <div class="detail-item name">
              <span>{{ $admin->name }}</span>
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
          <button class="edit-btn" onclick="clickEdit()">Edit Profile</button>
          <button class="logout-btn" onclick="clickLogout()">Log Out</button>
        </div>
      </div>
    </main>

    <!--- DIALOG SECTION -->
    <dialog class="edit-profile-dialog">
      <form id="edit-profile-form" method="POST"
        action="{{ route('admin.manager.profile.update', ['id' => $admin->id]) }}">
        @csrf
        @method('PUT')
        <input type="hidden" name="id" value="{{ $admin->id }}">

        <div class="icon-container">
          <i class="material-icons" onclick="closeEdit()">chevron_left</i>
        </div>

        <div class="edit-card">
          <h2>Edit Profile</h2>

          <div class="form-section">
            <div class="form-group">
              <label class="form-label">Name</label>
              <div class="input-item">
                <i class="material-icons">person</i>
                <input type="text" class="form-input" name="name" value="{{ $admin->name }}" disabled>
              </div>
            </div>

            <div class="form-group">
              <label class="form-label">Email</label>
              <div class="input-item">
                <i class="material-icons">email</i>
                <input type="email" class="form-input" name="email" value="{{ $admin->email }}" disabled>
              </div>
            </div>

            <div class="form-group">
              <label class="form-label">Contact No.</label>
              <div class="input-item">
                <i class="material-icons">phone</i>
                <input type="tel" class="form-input" name="number" value="{{ $admin->number }}" disabled>
              </div>
            </div>

            <div class="form-actions" style="text-align: right; margin-top: 75px;">
              <button type="button" class="btn cancel-button" onclick="cancelEdit()">Cancel</button>
              <button type="button" class="btn confirm-button" onclick="showSaveConfirmation()">Save</button>
            </div>
          </div>
        </div>
      </form>
    </dialog>

    <!--- SAVE CONFIRMATION MODAL -->
    <dialog class="save-confirmation-modal">
      <div class="modal-wrapper">
        <p class="modal-heading">Confirm Changes</p>
        <hr style="width: 100%">

        <p class="modal-text">
          Are you sure you want to save the changes?
        </p>
        <div class="modal-button-wrapper">
          <button class="cancel-button" onclick="cancelSave()">Cancel</button>
          <button class="confirm-button" onclick="confirmSave()">Confirm</button>
        </div>
      </div>
    </dialog>

    <!--- LOGOUT MODAL -->
    <dialog class="logout-modal">
      <div class="modal-wrapper">
        <p class="modal-heading">Log Out?</p>
        <hr style="width: 100%">

        <p class="modal-text">
          Are you sure you want to logout? You'll need
          to sign in again to access your account.
        </p>
        <div class="modal-button-wrapper">
          <button class="cancel-button" onclick="cancelLogout()">Cancel</button>
          <button class="confirm-button" onclick="confirmLogout()">Confirm</button>
        </div>
      </div>
    </dialog>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
      @csrf
    </form>

    <!-- CANCEL CONFIRMATION MODAL -->
    <dialog class="cancel-confirmation-modal">
      <div class="modal-wrapper">
        <p class="modal-heading">Are you sure you want to cancel?</p>

        <p class="modal-text">
          Any unsaved changes will be lost.
        </p>
        <div class="modal-button-wrapper">
          <button class="cancel-button" onclick="cancelCancel()">No</button>
          <button class="confirm-button" onclick="confirmCancel()">Yes</button>
        </div>
      </div>
    </dialog>

  </div>

  <script>
    const editModal = document.querySelector('.edit-profile-dialog');
    const editInputs = document.querySelectorAll('.edit-profile-dialog input');
    const saveConfirmationModal = document.querySelector('.save-confirmation-modal');
    const editForm = document.getElementById('edit-profile-form');

    // Get the cancel confirmation modal
    const cancelModal = document.querySelector('.cancel-confirmation-modal');

    function cancelEdit() {
      // Show the cancel confirmation modal instead of closing the edit modal directly
      cancelModal.showModal();
    }

    function cancelCancel() {
      // Close the cancel confirmation modal if the user chooses to keep editing
      cancelModal.close();
    }

    function confirmCancel() {
      // Close the cancel confirmation modal and close the edit profile dialog
      cancelModal.close();
      editModal.close();  // Close the edit profile dialog to cancel the changes
    }

    function clickEdit() {
      editModal.showModal();
      // Enable fields for editing
      enableAllFields();
    }

    function closeEdit() {
      editModal.close();
    }

    // function cancelEdit() {
    //   // Reset all fields and disable them
    //   editInputs.forEach(input => {
    //     input.disabled = true;
    //   });
    // }

    function enableAllFields() {
      // Enable all fields for editing
      editInputs.forEach(input => {
        input.disabled = false;
      });
    }

    function showSaveConfirmation() {
      // Show confirmation dialog before submitting form
      saveConfirmationModal.showModal();
    }

    function cancelSave() {
      // Close confirmation modal without saving
      saveConfirmationModal.close();
    }

    function confirmSave() {
      // Close confirmation modal and submit the form
      saveConfirmationModal.close();
      editForm.submit();

    }

    const logoutModal = document.querySelector('.logout-modal');

    function clickLogout() {
      logoutModal.showModal();
    }

    function cancelLogout() {
      logoutModal.close();
    }

    function confirmLogout() {
      document.getElementById('logout-form').submit();
    }
  </script>
</body>

</html>