<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Profile</title>
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
</head>

<body>
    <div class="container">
        <aside class="sidebar">
            <div class="back-button">
                <i class="fas fa-arrow-left"></i> Back to main
            </div>
            <div class="customer-profile">
                <!-- Profile Icon and Name (Side by side) -->
                <i class="fas fa-user-circle profile-icon"></i>
                <span class="customer-name">{{ $customer->name }}</span>
            </div>
            <nav class="menu">
                <a href="#" class="active"><i class="fas fa-user"></i> Profile</a>
                <a href="#"><i class="fas fa-calendar-check"></i> Reservations</a>
            </nav>
            <button class="logout"><i class="fas fa-sign-out-alt"></i> Log Out</button>
        </aside>
        <main class="profile-section">
            <div class="gradient-overlay"></div>
            <div class="profile-box">
                <h2>Your Profile</h2>
                <div class="profile-banner"></div>

                <!-- Container for Name, Email, and Contact -->
                <div class="profile-details">
                    <div class="profile-field name">
                        <span>{{ $customer->name }}</span>
                    </div>
                    <div class="profile-field">
                        <i class="fas fa-envelope"></i>
                        <span>{{ $customer->email }}</span>
                    </div>
                    <div class="profile-field">
                        <i class="fas fa-phone"></i>
                        <span>{{ $customer->number }}</span>
                    </div>
                </div>

                <div class="profile-actions">
                    <a href="{{ route('profile.edit', ['id' => $customer->id]) }}" class="edit-profile">
                        <i class="fas fa-pencil-alt"></i> Edit Profile
                    </a>

                    <button class="delete-account"><i class="fas fa-trash-alt"></i> Delete Account</button>
                </div>
            </div>
        </main>
    </div>
</body>

</html>
