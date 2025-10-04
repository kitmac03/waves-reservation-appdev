<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Waves Beach Resort</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght@400" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/res.css') }}">
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

<section class="reservation-hero">
    <div class="hero-content">        
        <h1>Escape to Waves at Bliss</h1>
        <p>Book your perfect beach getaway at Waves Beach Resort</p>
        </div>
            <div class="hero-wave"></div>
    </section>
    
    

    <section class="booking">
        <div class="booking-container">
            <div class="booking-header">
                <h2>Resort Booking</h2>
            </div>

            @if(session('success'))
                <div class="success-message" id="successMessage">
                    <span>{{ session('success') }}</span>
                    <button class="close-btn" onclick="dismissMessage()">×</button>
                </div>
            @endif

            <form action="{{ route('reservation.store') }}" method="POST" onsubmit="return validateSelection()">
                @csrf
                
                <div class="date-time-selection">
                    <div class="date-picker">
                        <label for="date">Reservation Date</label>
                        <input type="date" id="date" name="date" required>
                    </div>
                    
                    <div class="time-picker">
                        <div class="time-input">
                            <label for="startTime">Start Time</label>
                            <input type="time" id="startTime" name="startTime" required min="07:00" max="21:00">
                        </div>
                        <div class="time-input">
                            <label for="endTime">End Time</label>
                            <input type="time" id="endTime" name="endTime" required min="07:00" max="21:00">
                        </div>
                    </div>
                </div>

                <div class="amenities-section">
                    <h3>Available Amenities</h3>
                    
                    <div class="amenities-tabs">
                        <button type="button" class="tab-btn active" data-tab="cottages">Cottages</button>
                        <button type="button" class="tab-btn" data-tab="tables">Tables</button>
                    </div>
                    
                    <div class="amenities-container">
                        <div class="amenities-grid" id="cottages-tab">
                            @foreach ($cottages as $cottage)
                                @if ($cottage->is_active)
                                    <div class="amenity-card" data-id="{{ $cottage->id }}" data-type="cottage" data-price="{{ $cottage->price }}">
                                        <div class="amenity-header">
                                            <h4 class="amenity-name">{{ $cottage->name }}</h4>
                                            <span class="amenity-price">₱{{ number_format($cottage->price, 2) }}</span>
                                        </div>
                                        <div class="amenity-details">
                                            <div class="amenity-features">
                                                <span class="feature-tag"> <span class="material-symbols-outlined">cottage table_restaurant</span> </span>
                                            </div>
                                            <div class="amenity-status available">
                                                <span class="status-dot"></span>
                                                Available
                                            </div>
                                        </div>
                                        <input type="checkbox" name="cottages[]" value="{{ $cottage->id }}" class="amenity-check" hidden>
                                        <input type="hidden" name="prices[cottage][{{ $cottage->id }}]" value="{{ $cottage->price }}">
                                        <button type="button" class="select-btn">Select</button>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                        
                        <div class="amenities-grid" id="tables-tab" style="display: none;">
                            @foreach ($tables as $table)
                                @if ($table->is_active)
                                    <div class="amenity-card" data-id="{{ $table->id }}" data-type="table" data-price="{{ $table->price }}">
                                        <div class="amenity-header">
                                            <h4 class="amenity-name">{{ $table->name }}</h4>
                                            <span class="amenity-price">₱{{ number_format($table->price, 2) }}</span>
                                        </div>
                                        <div class="amenity-details">
                                            <div class="amenity-features">
                                                <span class="feature-tag"><span class="material-symbols-outlined">table_restaurant umbrella</span></span>
                                            </div>
                                            <div class="amenity-status available">
                                                <span class="status-dot"></span>
                                                Available
                                            </div>
                                        </div>
                                         <input type="checkbox" name="tables[]" value="{{ $table->id }}" class="amenity-check" hidden>
                                         <input type="hidden" name="prices[table][{{ $table->id }}]" value="{{ $table->price }}">
                                        <button type="button" class="select-btn">Select</button>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="selected-amenities-section">
                    <h3>Selected Amenities</h3>
                    <div class="selected-amenities-container" id="selected-amenities-container">
                        <div class="no-selection">No amenities selected yet</div>
                    </div>
                    <div class="total-price">
                        <span>Total: </span>
                        <span id="total-amount">₱0.00</span>
                    </div>
                </div>

                <div id="hidden-selection-bucket"></div>

                <!-- Error Message Container -->
                <div id="error-message" class="error-message">
                    Please select at least one Cottage or Table before submitting.
                </div>

                <!-- Submit button -->
                <div class="button-wrapper">
                    <button class="payment-button">Proceed to Payment</button>
                </div>
            </form>
        </div>
    </section>
<footer class="site-footer">
    <div class="footer-content">
        <div class="footer-bottom">
        <p>&copy; 2025 Waves Beach Resort. All rights reserved.</p>
        </div>
    </div>
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

        // Validation before form submission
        /*
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
        */
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

// Function to update selected amenities display
function updateSelectedAmenities() {
    const container = document.getElementById('selected-amenities-container');
    const checked = document.querySelectorAll('.amenity-check:checked');
    //const selectedAmenities = [];
    
    const selectedAmenities = Array.from(checked).map(input => {
    const card  = input.closest('.amenity-card');
    return {
      id:   card.getAttribute('data-id'),
      type: card.getAttribute('data-type'),
      name: card.querySelector('.amenity-name')?.textContent?.trim() || '',
      price: parseFloat(card.getAttribute('data-price')) || 0
    };
    });
    // Get all selected amenities
    /*const selectedCards = document.querySelectorAll('.amenity-card.selected');
    selectedCards.forEach(card => {
        const id = card.getAttribute('data-id');
        const type = card.getAttribute('data-type');
        const name = card.querySelector('.amenity-name').textContent;
        const price = parseFloat(card.getAttribute('data-price'));
        
        selectedAmenities.push({
            type: type,
            id: id,
            name: name,
            price: price
        });
    });*/
    
    // Update the display
    container.innerHTML = '';
    
    if (selectedAmenities.length === 0) {
        container.innerHTML = '<div class="no-selection">No amenities selected yet</div>';
    } else {
        selectedAmenities.forEach(amenity => {
            const itemDiv = document.createElement('div');
            itemDiv.className = 'selected-item';
            itemDiv.innerHTML = `
                <span class="item-name">${amenity.name} - ₱${amenity.price.toFixed(2)}</span>
                <button type="button" class="remove-btn" onclick="removeAmenity('${amenity.type}', '${amenity.id}')">×</button>
            `;
            container.appendChild(itemDiv);
        });
    }
    
    // Update total price
    updateTotalPrice(selectedAmenities);
}

// Function to remove an amenity
function removeAmenity(type, id) {
    const card = document.querySelector(`.amenity-card[data-type="${type}"][data-id="${id}"]`);
     if (!card) return;
        card.classList.remove('selected');
        const btn = card.querySelector('.select-btn');
        if (btn) { btn.textContent = 'Select'; btn.style.backgroundColor = ''; }
        const checkbox = card.querySelector('.amenity-check');
        if (checkbox) checkbox.checked = false;
        updateSelectedAmenities();
    }


function getReservedHours() {
  const start = document.getElementById('startTime')?.value || document.getElementById('starttime')?.value || '';
  const end   = document.getElementById('endTime')?.value   || document.getElementById('endtime')?.value   || '';

  if (!start || !end) return 0;

  const [sh, sm] = start.split(':').map(Number);
  const [eh, em] = end.split(':').map(Number);

  const startMin = sh * 60 + sm;
  const endMin   = eh * 60 + em;

  const diffMin = endMin - startMin;
  if (diffMin <= 0) return 0; // invalid or zero-length

  // exact decimal hours (e.g., 1.5 hours)
  const hours = diffMin / 60;

  return hours;
}

// Function to update total price
function updateTotalPrice(amenities) {
    const totalAmount = document.getElementById('total-amount');
    const hours = getReservedHours();

    let base = 0;
    amenities.forEach(a => { base += Number(a.price) || 0; });

    let total = hours > 0 ? base * hours : base;
    
    totalAmount.textContent = `₱${total.toFixed(2)}${hours ? ` (${hours} hr${hours === 1 ? '' : 's'})` : ''}`;
}



// Validation before form submission
function validateSelection() {
    const selectedAmenities = document.querySelectorAll('.amenity-check:checked');
    const startTime = document.getElementById("startTime").value;
    const endTime = document.getElementById("endTime").value;
    const errorMessageContainer = document.getElementById("error-message");

    // Validate if end time is after start time
    if (endTime <= startTime && endTime !== "") {
        alert("End time must be later than the start time.");
        return false; // Prevent form submission
    }

    // If no amenities are selected
    if (selectedAmenities.length === 0) {
        errorMessageContainer.style.display = "block"; // Show the error message
        return false; // Prevent form submission
    }

    // If amenities are selected, hide the error message
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

    // Handle tab switching
    document.querySelectorAll('.tab-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const tab = this.getAttribute('data-tab');
            
            // Update active tab
            document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            
            // Show corresponding tab content
            document.querySelectorAll('.amenities-grid').forEach(content => {
                content.style.display = 'none';
            });
            document.getElementById(`${tab}-tab`).style.display = 'grid';
        });
    });

    // Handle amenity selection
    document.querySelectorAll('.select-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const card = this.closest('.amenity-card');
            const checkbox = card.querySelector('.amenity-check');
            
            /*if (card.classList.contains('selected')) {
                // Deselect
                card.classList.remove('selected');
                this.textContent = 'Select';
                this.style.backgroundColor = '';
            } else {
                // Select
                card.classList.add('selected');
                this.textContent = 'Selected';
                this.style.backgroundColor = 'var(--error-color)';
            }*/

                const selecting = !card.classList.contains('selected');
                    card.classList.toggle('selected', selecting);
                    this.textContent = selecting ? 'Selected' : 'Select';
                    this.style.backgroundColor = selecting ? 'var(--error-color)' : '';

                    // toggle form value
                    if (checkbox) checkbox.checked = selecting;
            
            updateSelectedAmenities();
        });
    });

    // Update minimum end time based on selected start time
    document.getElementById("startTime").addEventListener("change", function () {
        let startTime = this.value;
        document.getElementById("endTime").setAttribute("min", startTime);

        // Fetch updated amenities based on the new start and end times
        fetchAvailableAmenities(getSelectedDate(), getStartTime(), getEndTime());
        updateSelectedAmenities();
    });

    document.getElementById("endTime").addEventListener("change", function () {
        // Fetch updated amenities based on the new end time
        fetchAvailableAmenities(getSelectedDate(), getStartTime(), getEndTime());
        updateSelectedAmenities();
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

    // Function to update the available amenities dynamically
    function updateAvailableAmenities(cottages, tables) {
        // Check if cottages and tables are arrays
        if (!Array.isArray(cottages) || !Array.isArray(tables)) {
            return;
        }

        // Update Cottage Cards
        const cottageCards = document.querySelectorAll('#cottages-tab .amenity-card');
        cottageCards.forEach(card => {
            const id = card.getAttribute('data-id');
            const isAvailable = cottages.some(cottage => cottage.id == id);
            
            const statusElement = card.querySelector('.amenity-status');
            if (isAvailable) {
                statusElement.classList.remove('unavailable');
                statusElement.classList.add('available');
                statusElement.innerHTML = '<span class="status-dot"></span> Available';
                card.querySelector('.select-btn').disabled = false;
            } else {
                statusElement.classList.remove('available');
                statusElement.classList.add('unavailable');
                statusElement.innerHTML = '<span class="status-dot"></span> Unavailable';
                card.querySelector('.select-btn').disabled = true;
                
                // If card was selected but now unavailable, deselect it
                if (card.classList.contains('selected')) {
                    card.classList.remove('selected');
                    const button = card.querySelector('.select-btn');
                    button.textContent = 'Select';
                    button.style.backgroundColor = '';
                }
            }
        });

        // Update Table Cards
        const tableCards = document.querySelectorAll('#tables-tab .amenity-card');
        tableCards.forEach(card => {
            const id = card.getAttribute('data-id');
            const isAvailable = tables.some(table => table.id == id);
            
            const statusElement = card.querySelector('.amenity-status');
            if (isAvailable) {
                statusElement.classList.remove('unavailable');
                statusElement.classList.add('available');
                statusElement.innerHTML = '<span class="status-dot"></span> Available';
                card.querySelector('.select-btn').disabled = false;
            } else {
                statusElement.classList.remove('available');
                statusElement.classList.add('unavailable');
                statusElement.innerHTML = '<span class="status-dot"></span> Unavailable';
                card.querySelector('.select-btn').disabled = true;
                
                // If card was selected but now unavailable, deselect it
                if (card.classList.contains('selected')) {
                    card.classList.remove('selected');
                    const button = card.querySelector('.select-btn');
                    button.textContent = 'Select';
                    button.style.backgroundColor = '';
                }
            }
        });
        
        // Update selected amenities display after refreshing available items
        updateSelectedAmenities();
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
});

// Logout Modal Functions
/*
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
    if (modal) modal.style.display = 'flex';
}

function closeModal(id) {
    const modal = document.getElementById(id);
    if (modal) modal.style.display = 'none';
}
*/
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

