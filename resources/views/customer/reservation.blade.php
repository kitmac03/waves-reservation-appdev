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
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;600;700&display=swap"
        rel="stylesheet" />


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


    <section class="booking">
        <div class="booking-form">
            <h2>Enjoy Your Vacation</h2>
            <p>7:00 AM - 9:00 PM</p>
            @if(session('success'))
                <div class="success-message" id="successMessage">
                    <span>{{ session('success') }}</span>
                    <button class="close-btn" onclick="dismissMessage()">×</button>
                </div>
            @endif
            <form action="{{ route('reservation.store') }}" method="POST" onsubmit="return validateSelection()">
                @csrf

                <!-- Date picker -->
                <div class="date-time-container">
                    <label for="date">Reservation Date</label>
                    <input type="date" id="date" name="date" required>
                </div>

                <!-- Start time picker -->
                <div class="start-end-time-container">
                    <div>
                        <label for="startTime">Start Time</label>
                        <input type="time" id="startTime" name="startTime" required min="07:00" max="21:00">
                    </div>
                    <div>
                        <label for="endTime">End Time</label>
                        <input type="time" id="endTime" name="endTime" required min="07:00" max="21:00">
                    </div>
                </div>


                <!-- Cottage selection with checkboxes -->
                <div class="custom-dropdown" id="cottage-dropdown">
                    <button type="button" class="dropdown-btn">Cottage</button>
                    <div class="dropdown-menu" id="cottage-menu">
                        @foreach ($cottages as $cottage)
                            @if ($cottage->is_active)
                                <label for="cottage-{{ $cottage->id }}">
                                    <input class="form-check-input p-2" type="checkbox" name="cottages[]"
                                        value="{{ $cottage->id }}" id="cottage-{{ $cottage->id }}">
                                    {{ $cottage->name }} - ₱{{ number_format($cottage->price, 2) }}
                                </label>
                            @endif
                        @endforeach
                    </div>
                </div>

                <!-- Table selection with checkboxes -->
                <div class="custom-dropdown" id="table-dropdown">
                    <button type="button" class="dropdown-btn">Table</button>
                    <div class="dropdown-menu" id="table-menu">
                        @foreach ($tables as $table)
                            @if ($table->is_active)
                                <label for="table-{{ $table->id }}">
                                    <input type="checkbox" name="tables[]" value="{{ $table->id }}" id="table-{{ $table->id }}">
                                    {{ $table->name }} - ₱{{ number_format($table->price, 2) }}
                                </label>
                            @endif
                        @endforeach
                    </div>
                </div>

                <!-- Error Message Container -->
                <div id="error-message" style="color: red; font-size: 14px; display: none; margin-bottom: 10px;">
                    Please select at least one Cottage or Table before submitting.
                </div>

                <!-- Submit button -->
                <div class="button-wrapper">
                    <button class="payment-button">Proceed to Payment</button>
                </div>
            </form>
        </div>

        <!-- Image Carousel -->
        <div class="image-carousel">
            <button class="prev">&#10094;</button>
            <img src="{{ asset('images/beach2.jpg') }}" alt="Beach View">
            <button class="next">&#10095;</button>
        </div>
    </section>



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
                <button class="btn primary-btn" id="confirmLogout">Confirm Logout</button>
            </div>
        </div>
    </div>

    <script>
        // Validation before form submission
        function validateSelection() {
            const cottages = document.querySelectorAll('input[name="cottages[]"]:checked');
            const tables = document.querySelectorAll('input[name="tables[]"]:checked');
            const cottageChecked = cottages.length > 0;
            const tableChecked = tables.length > 0;

            const startTime = document.getElementById("startTime").value;
            const endTime = document.getElementById("endTime").value;
            const errorMessageContainer = document.getElementById("error-message");

            // Validate if end time is after start time
            if (endTime <= startTime && endTime !== "") {
                alert("End time must be later than the start time.");
                return false; // Prevent form submission
            }

            // If neither cottage nor table is selected
            if (!cottageChecked && !tableChecked) {
                errorMessageContainer.style.display = "block"; // Show the error message
                return false; // Prevent form submission
            }

            // If either cottage or table is selected, hide the error message
            errorMessageContainer.style.display = "none";
            return true; // Allow form submission
        }

        document.addEventListener("DOMContentLoaded", function () {
            const now = new Date();
            const timezoneOffset = 8 * 60; // UTC +8
            const localDate = new Date(now.getTime() + timezoneOffset * 60000);
            const currentDate = localDate.toISOString().split('T')[0];

            // Set the minimum date to today for the date input field
            const dateInput = document.getElementById("date");
            dateInput.setAttribute("min", currentDate);
            dateInput.value = currentDate;

            // Fetch and update available amenities for the default date (today)
            fetchAvailableAmenities(currentDate, getStartTime(), getEndTime());

            // Handle dropdown visibility
            document.querySelectorAll('.dropdown-btn').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    const dropdownMenu = this.nextElementSibling;

                    if (dropdownMenu && dropdownMenu.classList) {
                        // Toggle visibility by checking the current state
                        if (dropdownMenu.style.display === "none" || dropdownMenu.classList.contains('hidden')) {
                            dropdownMenu.style.display = "block"; // Show the dropdown
                            dropdownMenu.classList.remove('hidden');
                        } else {
                            dropdownMenu.style.display = "none"; // Hide the dropdown
                            dropdownMenu.classList.add('hidden');
                        }
                    }
                });
            });

            // Close dropdown if clicked outside
            document.addEventListener('click', function (event) {
                document.querySelectorAll('.dropdown').forEach(function (dropdown) {
                    const dropdownMenu = dropdown.querySelector('.dropdown-menu');
                    if (!dropdown.contains(event.target) && dropdownMenu) {
                        dropdownMenu.classList.add('hidden');
                    }
                });
            });

            // Update minimum end time based on selected start time
            document.getElementById("startTime").addEventListener("change", function () {
                let startTime = this.value;
                document.getElementById("endTime").setAttribute("min", startTime);

                // Fetch updated amenities based on the new start and end times
                fetchAvailableAmenities(getSelectedDate(), getStartTime(), getEndTime());
            });

            document.getElementById("endTime").addEventListener("change", function () {
                // Fetch updated amenities based on the new end time
                fetchAvailableAmenities(getSelectedDate(), getStartTime(), getEndTime());
            });

            // Fetch and update available amenities when a date is selected
            document.getElementById("date").addEventListener("change", function () {
                let selectedDate = this.value;
                fetchAvailableAmenities(selectedDate, getStartTime(), getEndTime());
            });

            // Function to fetch and update available cottages and tables
            function fetchAvailableAmenities(date, startTime, endTime) {
                fetch(`/customer/check-availability?date=${date}&startTime=${startTime}&endTime=${endTime}`)
                    .then(response => response.json())
                    .then(data => {
                        updateAvailableAmenities(data.availableCottages, data.availableTables);
                    })
                    .catch(error => {
                        console.error("Error fetching availability data:", error);
                        updateAvailableAmenities([], []); // Clear dropdowns on error
                    });
            }

            // Function to update the available cottages and tables dynamically
            function updateAvailableAmenities(cottages, tables) {
                // Check if cottages and tables are arrays
                if (!Array.isArray(cottages) || !Array.isArray(tables)) {
                    return;
                }

                // Update Cottage Dropdown
                let cottageMenu = document.getElementById("cottage-menu");
                cottageMenu.innerHTML = ''; // Clear existing items

                if (cottages.length > 0) {
                    cottages.forEach(cottage => {
                        let label = document.createElement('label');
                        label.innerHTML = `
                    <input type="checkbox" name="cottages[]" value="${cottage.id}" id="cottage-${cottage.id}">
                    ${cottage.name} - ₱${cottage.price.toFixed(2)}
                `;
                        cottageMenu.appendChild(label);
                    });
                } else {
                    cottageMenu.innerHTML = '<p class="text-gray-500 px-4 py-2">No cottages available</p>';
                }

                // Update Table Dropdown
                let tableMenu = document.getElementById("table-menu");
                tableMenu.innerHTML = ''; // Clear existing items

                if (tables.length > 0) {
                    tables.forEach(table => {
                        let label = document.createElement('label');
                        label.innerHTML = `
                    <input type="checkbox" name="tables[]" value="${table.id}" id="table-${table.id}">
                    ${table.name} - ₱${table.price.toFixed(2)}
                `;
                        tableMenu.appendChild(label);
                    });
                } else {
                    tableMenu.innerHTML = '<p class="text-gray-500 px-4 py-2">No tables available</p>';
                }
            }

            // Helper function to get the selected date
            function getSelectedDate() {
                return document.getElementById("date").value;
            }

            // Helper function to get the selected start time
            function getStartTime() {
                return document.getElementById("startTime").value || "07:00";
            }

            // Helper function to get the selected end time
            function getEndTime() {
                return document.getElementById("endTime").value || "21:00";
            }

            // Image Carousel
            const images = [
                "{{ asset('images/beach1.jpg') }}",
                "{{ asset('images/beach2.jpg') }}",
                "{{ asset('images/beach3.jpg') }}",
            ];

            let currentIndex = 0;
            const imageElement = document.querySelector(".image-carousel img");
            const prevButton = document.querySelector(".prev");
            const nextButton = document.querySelector(".next");

            function updateImage() {
                imageElement.src = images[currentIndex];
            }

            prevButton.addEventListener("click", function () {
                currentIndex = (currentIndex - 1 + images.length) % images.length;
                updateImage();
            });

            nextButton.addEventListener("click", function () {
                currentIndex = (currentIndex + 1) % images.length;
                updateImage();
            });

            updateImage();
        });

        document.addEventListener('DOMContentLoaded', function () {
            const logoutButton = document.getElementById('logoutButton');
            const logoutModal = document.getElementById('logoutModal');
            const cancelLogout = document.getElementById('cancelLogout');
            const confirmLogout = document.getElementById('confirmLogout');
            const closeLogoutBtn = document.getElementById('closeLogoutModal');

            if (logoutButton && logoutModal && cancelLogout && confirmLogout && closeLogoutBtn) {
                logoutButton.addEventListener('click', () => openModal('logoutModal'));
                cancelLogout.addEventListener('click', () => closeModal('logoutModal'));
                closeLogoutBtn.addEventListener('click', () => closeModal('logoutModal'));

                confirmLogout.addEventListener('click', () => {
                    document.getElementById('logoutForm').submit();
                    closeModal('logoutModal');
                });

                window.addEventListener('click', function (event) {
                    if (event.target === logoutModal) {
                        closeModal('logoutModal');
                    }
                });
            } else {
                console.error('One or more logout modal elements not found.');
            }
        });
        function openModal(id) {
            const modal = document.getElementById(id);
            if (modal) modal.style.display = 'flex'; // This triggers centering based on your flex CSS
        }

        function closeModal(id) {
            const modal = document.getElementById(id);
            if (modal) modal.style.display = 'none';
        }


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

        document.addEventListener('click', function (event) {
            const dropdown = document.getElementById('profileDropdown');
            const profileIcon = document.getElementById('profile-icon');

            if (!profileIcon.contains(event.target) && !dropdown.contains(event.target)) {
                dropdown.classList.remove('show');
            }
        });

        function dismissMessage() {
            const message = document.getElementById('successMessage');
            if (message) {
                message.style.transition = 'opacity 0.3s ease';
                message.style.opacity = '0';
                setTimeout(() => {
                    message.style.display = 'none';
                }, 300);
            }
        }
    </script>


</body>

</html>