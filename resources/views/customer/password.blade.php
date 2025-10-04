<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <link rel="stylesheet" href="{{ asset('css/password.css') }}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body>
    <div class="container">
        <!-- Sidebar -->
        <aside class="sidebar" style="display: flex; flex-direction: column;">
            <div>
                <div class="back-button">
                    <a href="{{ route('customer.reservation') }}" class="back-link">
                        <i class="fas fa-chevron-left"></i>
                        <span>Back to main</span>
                    </a>
                </div>

                <div class="customer-profile"> 
                    <div class="avatar">
                        <i class="fas fa-user-circle"></i>
                    </div>
                    <span class="customer-name">{{ $customer->name }}</span>
                </div>
                <nav class="menu">
                    <a href="{{ route('customer.profile') }}" ><i class="fas fa-user"></i> Profile</a>
                    <a href="{{ route('customer.reservation.records') }}"><i class="fas fa-calendar-check"></i>
                        Reservations</a>
                    <a href="{{ route('customer.password') }}" class="active"><i class="fas fa-key"></i>
                        Password</a>
                </nav>
            </div>
            <div style="margin-top: auto;">
                <nav class="menu" style="margin-bottom: 0; ">
                    <a href="#" id="logoutButton" style="color: var(--text-light);">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </nav>
                <form id="logoutForm" method="POST" action="{{ route('logout') }}" style="display: none;">
                    @csrf
                </form>
            </div>
        </aside> 

        <!-- Main Content -->
        <div class="main-content">
            <div class="profile-section">
                <h2>Change Password</h2>

                <!-- Success Message (only shown if session has success) -->
                @if(session('success'))
                    <div class="alert alert-success" style="color: green; font-size: 14px;">
                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                    </div>
                @endif

                <!-- Error Messages -->
                @if($errors->any())
                    <div class="alert alert-error" style="color: red; font-size: 14px;">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
<form id="password-form" 
      action="{{ route('password.update', ['id' => auth()->user()->id]) }}" 
      method="POST"
      onsubmit="return confirmEdit()">
    @csrf
    @method('PATCH')


    <div class="form-group">
        <label>Current Password</label>
        <input type="password" name="current_password" required>
    </div>

    <div class="form-group">
        <label>New Password</label>
        <input type="password" name="new_password" required>
    </div>

    <div class="form-group">
        <label>Confirm New Password</label>
        <input type="password" name="new_password_confirmation" required>
    </div>

    <button type="submit">Change Password</button>
</form>


            </div>
        </div>
    </div>

    <script>
        function confirmEdit() {
            document.getElementById('saveModal').style.display = 'flex';
            return false; // prevent default form submission
        }

        function cancelEdit() {
            document.getElementById('cancelModal').style.display = 'flex';
        }

        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
        }

        function submitForm() {
            document.getElementById('password-form').submit();
        }

        function redirectToProfile() {
            window.location.href = "{{ route('customer.profile') }}";
        }
    </script>

    <!-- Save Confirmation Modal -->
    <div id="saveModal" class="modal">
        <div class="modal-content">
            <p>Are you sure you want to change your password?</p>
            <div class="modal-buttons">
                <button class="btn confirm" onclick="submitForm()">Yes</button>
                <button class="btn cancel" onclick="closeModal('saveModal')">No</button>
            </div>
        </div>
    </div>

    <!-- Cancel Confirmation Modal -->
    <div id="cancelModal" class="modal">
        <div class="modal-content">
            <p>Are you sure you want to cancel the password change?</p>
            <div class="modal-buttons">
                <button class="btn confirm" onclick="redirectToProfile()">Yes</button>
                <button class="btn cancel" onclick="closeModal('cancelModal')">No</button>
            </div>
        </div>
    </div>

    <!-- Logout Confirmation Modal -->
    <div id="logoutModal" class="modal">
        <div class="modal-content">
            <span class="close" id="closeLogoutModal">&times;</span>
            <div class="modal-header">
                <h3>Are you sure you want to log out?</h3>
            </div>
            <div class="modal-footer">
                <button class="btn secondary-btn" id="cancelLogout">Cancel</button>
                <button class="btn primary-btn" id="confirmLogout">Confirm Logout</button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Logout Modal Logic
            const logoutButton = document.getElementById('logoutButton');
            const logoutModal = document.getElementById('logoutModal');
            const cancelLogout = document.getElementById('cancelLogout');
            const confirmLogout = document.getElementById('confirmLogout');
            const closeLogoutBtn = document.getElementById('closeLogoutModal');

            // Open modal on logout button click
            if (logoutButton) {
                logoutButton.addEventListener('click', function () {
                    logoutModal.style.display = 'flex';
                });
            }

            // Close modal when clicking on the cancel button
            if (cancelLogout) {
                cancelLogout.addEventListener('click', function () {
                    logoutModal.style.display = 'none';
                });
            }

            // Close modal when clicking on the close button (×)
            if (closeLogoutBtn) {
                closeLogoutBtn.addEventListener('click', function () {
                    logoutModal.style.display = 'none';
                });
            }

            // Confirm logout action (submit logout form only when Confirm is clicked)
            if (confirmLogout) {
                confirmLogout.addEventListener('click', function () {
                    document.getElementById('logoutForm').submit();
                    logoutModal.style.display = 'none'; // Close modal after confirming
                });
            }

            // Close modal if clicked outside
            window.addEventListener('click', function (event) {
                if (event.target === logoutModal) {
                    logoutModal.style.display = 'none';
                }
            });
        });
    </script>
</body>

</html>