<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/edit_profile.css') }}">
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
                <!-- nag add kog button ani for acc balance -->

                <a href="#"><i class="fas fa-wallet"></i> Account Balance</a>
            </div>

            <form id="logoutForm" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf <!-- CSRF Token for security -->
            </form>

            <button id="logoutButton" class="logout">
                <i class="fas fa-sign-out-alt"></i> Log Out
            </button>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <div class="profile-section">
                <h2>Edit Profile</h2>

                <form id="profile-form" action="{{ route('profile.update', ['id' => $customer->id]) }}" method="POST">
                    @csrf
                    @method('PATCH')

                    <div class="form-group">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" class="form-input" value="{{ $customer->name }}">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-input" value="{{ $customer->email }}">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Contact No.</label>
                        <input type="tel" name="number" class="form-input" value="{{ $customer->number }}">
                    </div>

                    <div class="form-actions">
                        <button type="button" class="btn btn-cancel">Cancel</button>
                        <button type="submit" class="btn btn-save">Save</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</body>

</html>