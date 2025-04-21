<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="{{ asset('css/vendors_list.css') }}">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
    rel="stylesheet">
  <title>Vendor List</title>
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
          <li class="menu-item">Create Admin Account</li>
        </a>
        <a href="{{ route('admin.vendors.list') }}">
          <li class="menu-item active">List of Vendors</li>
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

      <p class="head-title">LIST OF VENDORS</p>
      <table>
        <thead>
          <tr>
            <th>Name</th>
            <th>Role</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Harry Potter</td>
            <td class="role">Cashier - Morning Shift</td>
            <td><button class="change-button" onclick="openDialog()">Change role</button></td>
          </tr>
          <tr>
            <td>Hermione Granger</td>
            <td class="role">Cashier - Afternoon Shift</td>
            <td><button class="change-button">Change role</button></td>
          </tr>
        </tbody>
      </table>

    </div>
  </div>

  <!---------- Change Admin Role Dialog ----------->

  <dialog class="change-admin-modal">
    <div class="dialog-container">
      <div class="dialog-info">
        <p class="dialog-title">CHANGE ADMIN ROLE</p>
        <p class="name"><b>Name: </b>Harry Potter</p>
        <p class="email"><b>Email: </b>ilovedraco@gmail.com</p>
        <p class="contact"><b>Contact No: </b>09123479899</p>
        <select class="select-role">
          <option>Cashier - Morning Shift</option>
          <option>Cashier - Afternoon Shift</option>
        </select>
      </div>

      <!---------- Confirm Change Admin Role Dialog ----------->

      <div class="button-container">
        <button class="cancel-button" onclick="closeDialog()">Cancel</button>
        <button class="save-button" onclick="confirmDialog()">Save</button>
      </div>
    </div>
  </dialog>

  <dialog class="confirmation-modal">
    <div class="confirm-modal-container">
      <p class="confirm-modal-heading">Change Admin Role?</p>
      <hr style="width: 100%">

      <p class="confirm-modal-text">
        Are you sure you want to change this admin's role?
        This will update the role information in their account.
      </p>
      <div class="confirm-button-container">
        <button class="exit-button" onclick="exitDialog(); closeDialog()">Cancel</button>
        <button class="confirm-button">Confirm</button>
      </div>
    </div>
  </dialog>

  <!----------------------- SCRIPT SECTION  ---------------------------->
  <script>

    const changeAdminModal = document.querySelector('.change-admin-modal');

    function openDialog() {
      changeAdminModal.showModal();
    }
    function closeDialog() {
      changeAdminModal.close();
    }

    const confirmModal = document.querySelector('.confirmation-modal');

    function confirmDialog() {
      confirmModal.showModal();
    }
    function exitDialog() {
      confirmModal.close();
    }

  </script>

</body>

</html>