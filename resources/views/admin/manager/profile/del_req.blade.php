<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="{{ asset('css/del_req.css') }}">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
    rel="stylesheet">
  <title>Account Deletion</title>
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
          <li class="menu-item">List of Vendors</li>
        </a>
        <a href="{{ route('admin.delete.requests') }}">
          <li class="menu-item active">
            Account Deletion Requests
          </li>
        </a>
      </ul>
    </div>

    <!--- MAIN CONTENT SECTION -->
    <div class="main-content">

      <h1>ACCOUNT DELETION REQUESTS</h1>
      @if(session('success'))
      <div class="alert success">{{ session('success') }}</div>
    @endif
      <table>
        <thead>
          <tr>
            <th>Name</th>
            <th>Reason</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          @forelse ($pendingRequests as $request)
        <tr>
        <td>
          {{ $request->customer->name }}
          <a href="{{ route('admin.delete.requests.details', $request->customer->id) }}" class="view-account">
          View account
          </a>

        </td>
        <td>{{ $request->deletion_reason }}</td>
        <td>
          <form action="{{ route('admin.delete.approve', $request->id) }}" method="POST" style="display:inline;">
          @csrf
          @method('PATCH')
          <button type="submit" class="accept">Accept</button>
          </form>

          <form action="{{ route('admin.delete.decline', $request->id) }}" method="POST" style="display:inline;">
          @csrf
          @method('PATCH')
          <button type="submit" class="decline">Decline</button>
          </form>
        </td>

        </tr>
      @empty
        <tr>
        <td colspan="3">No pending deletion requests.</td>
        </tr>
      @endforelse
        </tbody>

      </table>

    </div>
  </div>

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

    function openDialogWithData(name, email, phone) {
      document.querySelector('.profile-name').textContent = name;
      document.querySelector('.profile-email').textContent = email;
      document.querySelector('.profile-phone').textContent = phone;
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