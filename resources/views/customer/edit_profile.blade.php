<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="{{ asset('css/edit_profile.css') }}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body>
    <div class="container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="back-button">
                <a href="{{ route('customer.reservation') }}" class="back-link">
                    <i class="fas fa-chevron-left"></i>
                    <span>Back to main</span>
                </a>
            </div>

            <div class="customer-profile">
                <i class="fas fa-user-circle profile-icon"></i>
                <div class="customer-name">{{ $customer->name }}</div>
            </div>

            <div class="menu">
                <a href="{{ route('customer.profile') }}" class="active">
                    <i class="fas fa-user"></i>
                    <span>Profile</span>
                </a>
                <a href="{{ route('customer.reservation.records') }}">
                    <i class="fas fa-calendar-alt"></i>
                    <span>Reservation</span>
                </a>
                <a href="{{ route('customer.password') }}"><i class="fas fa-key"></i>
                   Password</a>

            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <div class="profile-section">
                <h2>Edit Profile</h2>

                <!-- Success Message (only shown if session has success) -->
                @if(session('success'))
                    <div class="alert alert-success" style="color: green; font-size: 14px;">
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

                <form id="profile-form" action="{{ route('profile.update', ['id' => $customer->id]) }}" method="POST"
                    onsubmit="return confirmEdit()">
                    @csrf
                    @method('PATCH')

                    <div class="form-group">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" class="form-input" value="{{ old('name', $customer->name) }}">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-input"
                            value="{{ old('email', $customer->email) }}">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Contact No.</label>
                        <input type="tel" name="number" class="form-input"
                            value="{{ old('number', $customer->number) }}">
                    </div>

                    <div class="form-actions">
                        <button type="button" class="btn btn-cancel" onclick="cancelEdit()">Cancel</button>
                        <button type="submit" class="btn btn-save">Save</button>
                    </div>
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
            document.getElementById('profile-form').submit();
        }

        function redirectToProfile() {
            window.location.href = "{{ route('customer.profile') }}";
        }
    </script>

    <!-- Save Confirmation Modal -->
    <div id="saveModal" class="modal">
        <div class="modal-content">
            <p>Are you sure you want to save the changes?</p>
            <div class="modal-buttons">
                <button class="btn confirm" onclick="submitForm()">Yes</button>
                <button class="btn cancel" onclick="closeModal('saveModal')">No</button>
            </div>
        </div>
    </div>

    <!-- Cancel Confirmation Modal -->
    <div id="cancelModal" class="modal">
        <div class="modal-content">
            <p>Are you sure you want to cancel the changes?</p>
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
            logoutButton.addEventListener('click', function () {
                logoutModal.style.display = 'flex';
            });

            // Close modal when clicking on the cancel button
            cancelLogout.addEventListener('click', function () {
                logoutModal.style.display = 'none';
            });

            // Close modal when clicking on the close button (×)
            closeLogoutBtn.addEventListener('click', function () {
                logoutModal.style.display = 'none';
            });

            // Confirm logout action (submit logout form only when Confirm is clicked)
            confirmLogout.addEventListener('click', function () {
                document.getElementById('logoutForm').submit();
                logoutModal.style.display = 'none'; // Close modal after confirming
            });

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