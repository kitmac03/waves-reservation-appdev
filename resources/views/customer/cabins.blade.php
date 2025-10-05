<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resort Amenities - Waves Beach Resort</title>
    <link rel="stylesheet" href="{{ asset('css/cabins.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Jaldi&family=Allura&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body class="amenities-page">
    <header class="navbar">
        <div class="logo">
            <a href="{{ route('home') }}" class="logo-text" style="text-decoration: none; color: inherit;">
                    <h1 class="title">Waves</h1>
                    <p class="sub-title">Beach Resort</p>
            </a>
        </div>

        <button class="navbar-toggler" onclick="toggleMenu()">
            <i class="fa-solid fa-bars"></i>
        </button>

        <nav class="nav-links" id="navMenu">
            <a class="nav-link" href="{{ route('home') }}">Home</a>
            <a class="nav-link" href="{{ route('customer.about') }}">About</a>
            <a class="nav-link" href="{{ route('customer.cabins') }}">Cabins</a>
            <a class="nav-link" href="{{ route('customer.reservation') }}">Book</a>

            <div class="profile-container">
                <i class="fas fa-user-circle" id="profile-icon" onclick="toggleDropdown(event)"></i>
                <div class="dropdown-content" id="profileDropdown">
                    <a href="{{ route('customer.profile') }}">
                        <i class="fas fa-user"></i> Profile
                    </a>
                    <form id="logoutForm" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                    <a href="#" id="logoutButton">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </div>
            </div>
        </nav>
    </header>

    <main>
        <!-- Hero Section -->
        <section class="amenities-hero">
            <div class="hero-content">
                <h1>Resort Amenities</h1>
                <p>Discover our exclusive day tour facilities - perfect cottages and beachside tables for your perfect beach day</p>
            </div>
            <div class="hero-wave"></div>
        </section>

        <!-- Amenities Content -->
        <section class="amenities-content">
            <!-- Cottages Section -->
            <div class="amenities-section">
                <h2 class="section-title">Beach Cottages</h2>
                <div class="cottages-grid">
                    
                    <!-- Cottage 1 -->
                    <div class="cottage-card">
                        <div class="cottage-image" style="background-image: url('https://images.unsplash.com/photo-1588387077973-0ba5cb497a59?q=80&w=870&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D')">
                            <div class="cottage-badge">Most Popular</div>
                        </div>
                        
                        <div class="cottage-content">
                            <h3>Standard Cottage</h3>
                            <p>Comfortable bamboo cottage perfect for families and small groups.</p>
                            
                            <table class="cottage-table">
                                <tbody>
                                    <tr>
                                        <th>Capacity</th>
                                        <td>6-8 People</td>
                                    </tr>
                                    <tr>
                                        <th>Size</th>
                                        <td>4x4 meters</td>
                                    </tr>
                                    <tr>
                                        <th>Amenities</th>
                                        <td>Table, Benches</td>
                                    </tr>
                                   
                                </tbody>
                            </table>
                            
                        </div>
                    </div>

                    <!-- Cottage 2 -->
                    <div class="cottage-card">
                        <div class="cottage-image" style="background-image: url('https://images.unsplash.com/photo-1597454642566-d4d3632eae6f?q=80&w=870&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D')">
                            <div class="cottage-badge">Premium</div>
                        </div>
                        
                        <div class="cottage-content">
                            <h3>Family Cottage</h3>
                            <p>Spacious cottage perfect for larger groups or special occasions.</p>
                            
                            <table class="cottage-table">
                                <tbody>
                                    <tr>
                                        <th>Capacity</th>
                                        <td>10-12 People</td>
                                    </tr>
                                    <tr>
                                        <th>Size</th>
                                        <td>5x5 meters</td>
                                    </tr>
                                    <tr>
                                        <th>Amenities</th>
                                        <td>Large Table, Seats</td>
                                    </tr>
                                    
                                </tbody>
                            </table>
                            
                        </div>
                    </div>

                    <!-- Cottage 3 -->
                    <div class="cottage-card">
                        <div class="cottage-image" style="background-image: url('https://images.unsplash.com/photo-1718330009321-0b02f7ba3ba1?q=80&w=870&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D')">
                            <div class="cottage-badge">Beachfront</div>
                        </div>
                        
                        <div class="cottage-content">
                            <h3>Premium Cottage</h3>
                            <p>Luxury beachfront cottage and the best ocean views.</p>
                            
                            <table class="cottage-table">
                                <tbody>
                                    <tr>
                                        <th>Capacity</th>
                                        <td>4-6 People</td>
                                    </tr>
                                    <tr>
                                        <th>Size</th>
                                        <td>4x5 meters</td>
                                    </tr>
                                    <tr>
                                        <th>Amenities</th>
                                        <td>Lounge, Charging Ports</td>
                                    </tr>
                                   
                                    </tr>
                                </tbody>
                            </table>
                            
                        </div>
                    </div>

                </div>
            </div>

          <!-- Tables Section -->
<div class="amenities-section">
    <h2 class="section-title">Beachside Tables</h2>
    <div class="tables-grid">
        
        <!-- Table 1 -->
        <div class="table-card">
            <div class="table-image" style="background-image: url('https://images.unsplash.com/photo-1758941192772-6737563a4386?q=80&w=685&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D');"></div>
            <h3><i class="fas fa-umbrella-beach"></i> Standard Table</h3>
            <p>Perfect for couples or small groups who want a simple beach setup.</p>
            
            <div class="table-details">
                <div class="detail-item">
                    <span class="detail-label">Capacity</span>
                    <span class="detail-value">2-4 People</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Includes</span>
                    <span class="detail-value">Table + 4 Chairs</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Beach Umbrella</span>
                    <span class="detail-value">Yes</span>
                </div>
            </div>
        </div>

        <!-- Table 2 -->
        <div class="table-card">
            <div class="table-image" style="background-image: url('https://images.unsplash.com/photo-1680014909199-ef0adcb29901?q=80&w=1173&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D');"></div>
            <h3><i class="fas fa-sun"></i> Family Table</h3>
            <p>Spacious setup perfect for families with children.</p>
            
            <div class="table-details">
                <div class="detail-item">
                    <span class="detail-label">Capacity</span>
                    <span class="detail-value">4-6 People</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Includes</span>
                    <span class="detail-value">Large Table + 6 Chairs</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Beach Umbrella</span>
                    <span class="detail-value">Large Size</span>
                </div>
            </div>
        </div>

        <!-- Table 3 -->
        <div class="table-card">
            <div class="table-image" style="background-image: url('https://plus.unsplash.com/premium_photo-1687960116836-0eb19ff4fcca?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D');"></div>
            <h3><i class="fas fa-cocktail"></i> Premium Table</h3>
            <p>Luxury beachside setup with premium furniture and service.</p>
            
            <div class="table-details">
                <div class="detail-item">
                    <span class="detail-label">Capacity</span>
                    <span class="detail-value">6-8 People</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Includes</span>
                    <span class="detail-value">Premium Table + Chairs</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Beach Umbrella</span>
                    <span class="detail-value">Premium Large</span>
                </div>
            </div>
        </div>

    </div>
</div>
            <!-- CTA Section -->
            <div style="text-align: center; margin-top: 60px;">
                <a href="{{ route('customer.reservation') }}" class="cta-button">
                    <i class="fas fa-calendar-check"></i> Reserve Your Spot Now
                </a>
                
                
            </div>
        </section>
    </main>

    <footer class="site-footer">
        <p>&copy; 2025 Waves Beach Resort. All rights reserved.</p>
    </footer>

    <!-- Logout Confirmation Modal -->
    <div id="logoutModal" class="modal" style="display: none;">
        <div class="modal-content">
            <span class="close" id="closeLogoutModal">&times;</span>
            <div class="modal-header">
                <h3>Are you sure you want to log out?</h3>
            </div>
            <div class="modal-footer">
                <button class="btn secondary-btn" id="cancelLogout">Cancel</button>
                <button class="btn primary-btn" id="confirmLogout">Logout</button>
            </div>
        </div>
    </div>

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