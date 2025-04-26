<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manager's Profile</title>
  <link rel="stylesheet" href="{{ asset('css/manager_profile.css') }}">
  <link rel="stylesheet" href="styles.css">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
  <title>Manager's Profile</title>
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
            <span class="notification">1</span>
          </li>
        </a>
      </ul>
    </div>

    <!--- MAIN CONTENT SECTION -->
    <div class="main-content">

      <div class="profile-card">
        <h2>Manager's Profile</h2>
        <div class="profile-details">
          <div class="avatar"></div>
          <div class="info">
            <p class="name">{{ $admin->name }}</p>
            <p><i class="material-icons">email</i> {{ $admin->email }}</p>
            <p><i class="material-icons">phone</i> {{ $admin->number }}</p>
          </div>
        </div>

        <div class="actions">
          <button class="edit-btn" onclick="clickEdit()">Edit Profile</button>
          <button class="logout-btn" onclick="clickLogout()">Log Out</button>
        </div>
      </div>
    </div>
  </div>

  <!--- DIALOG SECTION -->
  <dialog class="edit-profile-dialog">
    <div class="dialog-container">

      <div class="icon-container">
        <i class="material-icons" onclick="closeEdit()">chevron_left</i>
      </div>

      <div class="dialog-info">
        <div class="heading-container">
          <p> Edit Profile</p><hr>
        </div>
        <div>
          <div class="name-container">
            <p class="name">Name</p>
            <input value="Hector Culaste">
            <p class="edit-name">Edit</p>
          </div>
          <hr>
        </div>

        <div>
          <div class="email-container">
            <p class="email">Email</p>
            <input value="Hectorc@gmail.com">
            <p class="edit-email">Edit</p>
          </div>
          <hr>
        </div>

        <div>
          <div class="contact-container">
            <p class="contact">Contact</p>
            <input value="09204567334">
            <p class="edit-contact">Edit</p>
          </div>
          <hr>
        </div>
      </div>

    </div>
  </dialog>

  <!---------- Modal/Dialog Box ----------->
      
  <dialog class="logout-modal">
    <div class="modal-wrapper">
      <p class="modal-heading">Log Out?</p>
    <hr style="width: 100%">
    
    <p class="modal-text">
      Are you sure you want to logout? You'll need
      to sign in again to acess your account.
    </p>
      <div class="modal-button-wrapper">
        <button class="cancel-button" onclick="cancelLogout()">Cancel</button>
        <button class="confirm-button">Confirm</button>
     </div>
    </div>
  </dialog>

  <!--- SCRIPT SECTION -->

  <script>

    const editModal = document.querySelector('.edit-profile-dialog');

    function clickEdit() {
      editModal.showModal();
    }

    function closeEdit() {
      editModal.close();
    }

    const logoutModal = document.querySelector('.logout-modal');

    function clickLogout() {
      logoutModal.showModal();
    }

    function cancelLogout() {
      logoutModal.close();
    }

  </script>




</body>
</html>