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
          <li class="menu-item active">List of Admins</li>
        </a>
        <a href="{{ route('admin.delete.requests') }}">
          <li class="menu-item">
            Account Deletion Requests
          </li>
        </a>
      </ul>
    </div>

    <!--- MAIN CONTENT SECTION -->
    <div class="main-content">

      <p class="head-title">LIST OF ADMINS</p>
      <div id="flash-message" style="display:none; padding:10px; margin-bottom:10px; border-radius:5px;"></div>
      <table>
        <thead>
          <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Contact No.</th>
            <th>Role</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          @foreach ($vendors as $vendor)
        <tr>
        <td>{{ $vendor->name }}</td>
        <td>{{ $vendor->email }}</td>
        <td>{{ $vendor->number }}</td>
        <!--<td class="role">{{ $vendor->role }}</td>-->
        <td>Admin</td>
        <td>
         
        </td>
        </tr>
      @endforeach
        </tbody>

      </table>

    </div>
  </div>

  <!---------- Change Admin Role Dialog ----------->

  <dialog class="change-admin-modal">
    <div class="dialog-container">
      <div class="dialog-info">
        <p class="dialog-title">CHANGE ADMIN ROLE</p>
        <p class="name"><b>Name: </b></p> <!-- Dynamic -->
        <p class="email"><b>Email: </b></p> <!-- Dynamic -->
        <p class="contact"><b>Contact No: </b></p> <!-- Dynamic -->
        <select class="select-role">
          <option>Vendor</option>
          <option>Manager</option>
        </select>
      </div>

      <div class="button-container">
        <button class="cancel-button" onclick="closeDialog()">Cancel</button>
        <button class="save-button" onclick="saveDialog()">Save</button>
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
        <button class="confirm-button" onclick="confirmDialog()"> Confirm</button>
      </div>
    </div>
  </dialog>

  <!----------------------- SCRIPT SECTION  ---------------------------->
  <script>

    const changeAdminModal = document.querySelector('.change-admin-modal');
    let id = ""
    function openDialog(id, name, email, contact) {
      this.id = id;

      const changeAdminModal = document.querySelector('.change-admin-modal');

      // Set the text in the modal
      changeAdminModal.querySelector('.name').innerHTML = '<b>Name: </b>' + name;
      changeAdminModal.querySelector('.email').innerHTML = '<b>Email: </b>' + email;
      changeAdminModal.querySelector('.contact').innerHTML = '<b>Contact No: </b>' + contact;

      changeAdminModal.showModal();
    }

    function closeDialog() {
      changeAdminModal.close();
    }

    const confirmModal = document.querySelector('.confirmation-modal');

    function saveDialog() {
      confirmModal.showModal();
    }

    function confirmDialog() {
      const selectedRole = document.querySelector('.select-role').value;

      fetch(`/admin/vendors-list/${this.id}`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
          id: this.id,
          role: selectedRole
        })
      })
        .then(response => response.json())
        .then(data => {
          const messageDiv = document.getElementById('flash-message');
          if (data.success) {
            messageDiv.innerText = data.message;
            messageDiv.style.display = 'block';
            messageDiv.style.backgroundColor = '#d4edda';
            messageDiv.style.color = '#155724';
          } else {
            messageDiv.innerText = data.message || 'Failed to update role.';
            messageDiv.style.display = 'block';
            messageDiv.style.backgroundColor = '#f8d7da';
            messageDiv.style.color = '#721c24';
          }

          // Optional: auto-hide after 3 seconds
          setTimeout(() => {
            messageDiv.style.display = 'none';
            location.reload(); // reload after message disappears
          }, 2000);
        })
        .catch(error => {
          console.error('Error:', error);
        });

      confirmModal.close();
      changeAdminModal.close();
    }


    function exitDialog() {
      confirmModal.close();
    }

  </script>

</body>

</html>