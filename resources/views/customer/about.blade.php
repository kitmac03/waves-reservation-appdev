<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Waves Beach Resort</title>
    <link rel="stylesheet" href="{{ asset('css/res.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Jaldi&family=Allura&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body>
    <header class="navbar">
        <div class="logo">
            <div class="logo-text">
                <h1 class="title">Waves</h1>
                <p class="sub-title">Beach Resort</p>
            </div>
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
        <!-- Welcome Section -->
        <section class="welcome-section">
            <div class="welcome-text">
                <h1>Welcome to WAVES Resort</h1>
                <p>Experience luxury beachfront living at its finest, where golden sands meet crystal-clear waters.</p>
                <p>Our private cabanas and beachside amenities are designed to provide the ultimate relaxation experience, complemented by refreshing cocktails and exceptional service.</p>
                <p>We're committed to creating a welcoming sanctuary where you can connect with nature, recharge your spirit, and create unforgettable memories.</p>
                <a href="{{ route('customer.reservation') }}" class="cta-button">Book Your Stay Now</a>
            </div>
            <div class="wave-divider"></div>
        </section>

        <!-- Resort Preview Section -->
        <section class="resort-preview">
            <div class="preview-header">
                <h2>The Waves Resort</h2>
                <p>Discover our world-class amenities and breathtaking locations</p>
            </div>

            <div class="preview-gallery">
                <!-- Beachfront Villas -->
                <div class="preview-card">
                    <div class="card-image" style="background-image: url('https://images.unsplash.com/photo-1566073771259-6a8506099945?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80')"></div>
                    <div class="card-content">
                        <h3>Beachfront Villas</h3>
                        <p>Private villas with direct beach access, outdoor showers, and panoramic ocean views. Perfect for romantic getaways.</p>
                        <div class="card-features">
                            <div class="feature">
                                <i class="fas fa-bed"></i>
                                <span>King Bed</span>
                            </div>
                            <div class="feature">
                                <i class="fas fa-swimming-pool"></i>
                                <span>Private Pool</span>
                            </div>
                            <div class="feature">
                                <i class="fas fa-wifi"></i>
                                <span>WiFi</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Infinity Pool -->
                <div class="preview-card">
                    <div class="card-image" style="background-image: url('https://images.unsplash.com/photo-1575429198097-0414ec08e8cd?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80')"></div>
                    <div class="card-content">
                        <h3>Infinity Pool</h3>
                        <p>Stunning infinity pool overlooking the ocean with swim-up bar, comfortable loungers, and daily poolside service.</p>
                        <div class="card-features">
                            <div class="feature">
                                <i class="fas fa-cocktail"></i>
                                <span>Swim-up Bar</span>
                            </div>
                            <div class="feature">
                                <i class="fas fa-umbrella-beach"></i>
                                <span>Sun Loungers</span>
                            </div>
                            <div class="feature">
                                <i class="fas fa-concierge-bell"></i>
                                <span>Pool Service</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Seaside Restaurant -->
                <div class="preview-card">
                    <div class="card-image" style="background-image: url('https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80')"></div>
                    <div class="card-content">
                        <h3>Seaside Restaurant</h3>
                        <p>Gourmet dining experience with fresh local seafood, international cuisine, and breathtaking sunset views.</p>
                        <div class="card-features">
                            <div class="feature">
                                <i class="fas fa-utensils"></i>
                                <span>Fine Dining</span>
                            </div>
                            <div class="feature">
                                <i class="fas fa-fish"></i>
                                <span>Fresh Seafood</span>
                            </div>
                            <div class="feature">
                                <i class="fas fa-wine-glass-alt"></i>
                                <span>Wine Bar</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Spa & Wellness -->
                <div class="preview-card">
                    <div class="card-image" style="background-image: url('https://images.unsplash.com/photo-1544161515-4ab6ce6db874?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80')"></div>
                    <div class="card-content">
                        <h3>Spa & Wellness</h3>
                        <p>Rejuvenate with our signature treatments, yoga sessions on the beach, and state-of-the-art fitness center.</p>
                        <div class="card-features">
                            <div class="feature">
                                <i class="fas fa-spa"></i>
                                <span>Spa Treatments</span>
                            </div>
                            <div class="feature">
                                <i class="fas fa-yoga"></i>
                                <span>Yoga Classes</span>
                            </div>
                            <div class="feature">
                                <i class="fas fa-dumbbell"></i>
                                <span>Fitness Center</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Resort Stats -->
            <div class="resort-stats">
                <div class="stat-item">
                    <span class="stat-number">50+</span>
                    <span class="stat-label">Luxury Rooms</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">3</span>
                    <span class="stat-label">Swimming Pools</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">2</span>
                    <span class="stat-label">Restaurants</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">98%</span>
                    <span class="stat-label">Guest Satisfaction</span>
                </div>
            </div>
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

        // Add smooth scrolling for better user experience
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    </script>
</body>
</html>