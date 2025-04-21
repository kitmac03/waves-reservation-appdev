<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="{{ asset('css/create_admin.css') }}">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
  <title>Create Account</title>
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
          <li class="menu-item">Profile</li>
        </a>
        <a href="{{ route('admin.create.account') }}">
          <li class="menu-item active">Create Admin Account</li>
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

      <p class="head-title">ADMIN ACCOUNT CREATION</p>

      <div class="input-container">
        <input class="name-input" placeholder="Name">
        <input class="email-input" placeholder="Email">
        <input class="password-input" type="password" placeholder="Password">
        <input class="contact-input" type="number" placeholder="Contact No.">
        <select class="select-role">
          <option disabled selected>Select admin role</option>
          <option>Manager</option>
        </select>
      </div>

      <div class="button-container">
        <button class="create-button" onclick="confirmDialog()">Create Account</button>
      </div>
      
    </div>
  </div>

   <!---------- Modal/Dialog Box ----------->
      
   <dialog class="confirm-account-modal">
    <div class="modal-wrapper">
      <p class="modal-heading">Confirm Admin Account Creation?</p>
    <hr style="width: 100%">
    
    <p class="modal-text">
      Are you sure you want to create this admin account?
      The account cannot be deleted once created.
    </p>
      <div class="modal-button-wrapper">
        <button class="cancel-button" onclick="closeDialog()">Cancel</button>
        <button class="confirm-button">Confirm</button>
     </div>
    </div>
  </dialog>

  <!----------------------- SCRIPT SECTION  ---------------------------->
  <script>

    const confirmationModal = document.querySelector('.confirm-account-modal');

    function confirmDialog() {
      confirmationModal.showModal();
    }
    function closeDialog() {
      confirmationModal.close();
    }

  </script>
  
</body>
</html>