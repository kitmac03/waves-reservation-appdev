<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="{{ asset('css/del_req.css') }}">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
  <title>Account Deletion</title>
</head>
<body>
  <div class="container">

    <!--- SIDEBAR SECTION -->
    <div class="sidebar">

      <a href="dashboard.html">
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
        <a href="manager_profile.html">
          <li class="menu-item">Profile</li>
        </a>
        <a href="create_manager_account.html">
          <li class="menu-item">Create Admin Account</li>
        </a>
        <a href="vendor_list.html">
          <li class="menu-item">List of Vendors</li>
        </a>
        <a href="account_deletion_request.html">
          <li class="menu-item active">
            Account Deletion Requests
          </li>
        </a>
      </ul>
    </div>

    <!--- MAIN CONTENT SECTION -->
    <div class="main-content">

      <h1>ACCOUNT DELETION REQUESTS</h1>
      <table>
        <thead>
          <tr>
            <th>Name</th>
            <th>Reason</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>
              Maria Sanchez 
              <button class="view-account" onclick="openDialog()">View account</button>
            </td>
            <td>I'll make a new one</td>
            <td>
              <button class="accept" onclick="showAcceptDeletion()">Accept</button>
              <button class="decline" onclick="showDeclineDeletion()">Decline</button>
            </td>
          </tr>
        </tbody>
      </table>

    </div>
  </div>

  <!--------------------- DIALOG SECTION ------------------------>

  <!--- RESERVATION DIALOG SECTION -->

  <dialog class="reservation-dialog">
    <div class="dialog-header">
      <button class="close-dialog-button" onclick="closeDialog()">&times;</button>
    </div>
    <div class="dialog-content">
      <div class="profile-section">
        <div class="profile-pic"></div>
        <p class="profile-name">Maria Sanchez</p>
        <p class="profile-email">sanchezm@gmail.com</p>
        <p class="profile-phone">09206754432</p>
      </div>
      <div class="reservations-section">
        <h1 class="reservations-title">Customer’s Reservations</h1>
        <div class="legend">
          <span class="legend-item verified">Verified</span>
          <span class="legend-item pending">Pending</span>
          <span class="legend-item cancelled">Cancelled</span>
          <span class="legend-item completed">Completed</span>
        </div>
        <div class="columns">
          <div class="column cancelled-column">
            <h2 class="column-title">Cancelled</h2>
            <div class="reservation">
              <span class="reservation-id">#6</span>
              <span class="reservation-detail">Right Side</span>
              <span class="reservation-date">2024-11-24</span>
              <span class="reservation-time">8:00 AM</span>
            </div>
          </div>
          <div class="column current-column">
            <h2 class="column-title">Current</h2>
          </div>
          <div class="column completed-column">
            <h2 class="column-title">Completed</h2>
          </div>
        </div>
      </div>
    </div>
  </dialog>

  <!--- ACCEPT ACCOUNT DELETION DIALOG SECTION -->

  <dialog class="accept-deletion">
    <div class="accept-content">
      <p class="accept-title">Accept Account Deletion?</p>
      <hr class="divider">
      
      <p class="accept-text">
        Are you sure you want to delete this customer's account?
        This action cannot be undone.
      </p>
      <div class="accept-actions">
        <button class="accept-cancel-btn" onclick="closeAcceptDeletion()">Cancel</button>
        <button class="accept-confirm-btn" onclick="closeAcceptDeletion()">Confirm</button>
      </div>
    </div>
  </dialog>

  <!--- DECLINE ACCOUNT DELETION DIALOG SECTION -->

  <dialog class="decline-deletion">
    <div class="decline-content">
      <p class="decline-title">Decline Account Deletion?</p>
      <hr class="divider">
      
      <p class="decline-text">
        Are you sure you want to decline this request? The account 
        will remain undeleted and will no longer be processed for removal.
      </p>
      <div class="decline-actions">
        <button class="decline-cancel-btn" onclick="closeDeclineDeletion()">Cancel</button>
        <button class="decline-confirm-btn" onclick="closeDeclineDeletion()">Confirm</button>
      </div>
    </div>
  </dialog>
  
  <!------------ SCRIPT SECTION ------------>

  <script>

    const reservationDialog = document.querySelector('.reservation-dialog');
    const acceptDeletion = document.querySelector('.accept-deletion');  
    const declineDeletion = document.querySelector('.decline-deletion'); 

    function openDialog() {
      reservationDialog.showModal();
    }
    function closeDialog() {
      reservationDialog.close();
    }

    
    function showAcceptDeletion() {
      acceptDeletion.showModal();
    }
    function closeAcceptDeletion() {
      acceptDeletion.close();
    }

     
    function showDeclineDeletion() {
      declineDeletion.showModal();
    }
    function closeDeclineDeletion() {
      declineDeletion.close();
    }
    


  </script>
  
  
</body>
</html>