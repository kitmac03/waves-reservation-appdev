<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Waves Beach Resort</title>
    <link rel="stylesheet" href="{{ asset('css/res.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Jaldi&family=Allura&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

</head>

<body>
    <header class="navbar">
  <div class="logo">
    <img src="{{ asset('images/logs.png') }}" alt="WAVES Logo" />
    <div class="logo-text">
      <h1 class="title">WAVES</h1>
      <p class="sub-title">Resort</p>
    </div>
  </div>

  <button class="navbar-toggler" onclick="toggleMenu()">
    <i class="fa-solid fa-bars"></i>
  </button>

  <nav class="nav-links" id="navMenu">
    <a class="nav-link" href="{{ route('customer.about') }}">About</a>
   
      <a class="nav-link" href="{{ route('customer.reservation') }}">Book</a>
      
    <div class="profile-container">
                <i class="fas fa-user-circle" id="profile-icon" onclick="toggleDropdown(event)"></i>
                <div class="dropdown-content" id="profileDropdown">
                    <a href="{{ route('customer.profile') }}">
                        <i class="fas fa-user"></i> Profile
                    </a>
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>
        </nav>
</header>

    <main>
       <section class="welcome-section">
        <div class="welcome-text">
            <h1>Welcome to WAVES Resort</h1>
            <p>Experience luxury beachfront living at its finest, where golden sands meet crystal-clear waters.</p>
            <p>Our private cabanas and beachside amenities are designed to provide the ultimate relaxation experience, complemented by refreshing cocktails and exceptional service.</p>
            <p>We're committed to creating a welcoming sanctuary where you can connect with nature, recharge your spirit, and create unforgettable memories.</p>
        </div>
        <div class="wave-divider"></div>
    </section>
    </main>

    
    <footer class="site-footer">
    <p>&copy; 2025 Waves Beach Resort. All rights reserved.</p>
</footer>
 <script>
    
        // Toggle mobile menu
        function toggleMenu() {
            const navMenu = document.getElementById('navMenu');
            navMenu.style.display = navMenu.style.display === 'flex' ? 'none' : 'flex';
        }

        // Toggle profile dropdown
        function toggleDropdown(event) {
            event.stopPropagation(); 
            const dropdown = document.getElementById('profileDropdown');
            dropdown.classList.toggle('show');
        }

        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('profileDropdown');
            const profileIcon = document.getElementById('profile-icon');
            
            if (!profileIcon.contains(event.target) && !dropdown.contains(event.target)) {
                dropdown.classList.remove('show');
            }
        });
    </script>
</body>

</html>