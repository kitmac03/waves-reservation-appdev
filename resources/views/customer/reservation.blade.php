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
    <style>
        /* Styling for the form and buttons */
        .custom-dropdown {
            position: relative;
            display: inline-block;
            width: 100%;
            /* Make the dropdown take full width like other inputs */
            margin-bottom: 20px;
            /* Add some space between the form elements */
        }

        .dropdown-btn {
            width: 100%;
            /* Make button width same as input fields */
            padding: 12px 15px;
            font-size: 16px;
            cursor: pointer;
            border: 1px solid #ccc;
            border-radius: 4px;
            background-color: white;
            text-align: left;
            /* Align text to the left */
        }

        .dropdown-menu {
            display: none;
            position: absolute;
            background-color: white;
            width: 100%;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.1);
            z-index: 1;
            max-height: 150px;
            overflow-y: auto;
            padding: 8px 0;
            /* Added padding to make the dropdown more spacious */
        }

        .dropdown-menu label {
            display: flex;
            align-items: center;
            padding: 8px 15px;
            cursor: pointer;
            font-size: 14px;
            width: 100%;
            /* Ensure that labels take up full width */
        }

        .dropdown-menu input[type="checkbox"] {
            margin-right: 10px;
            /* Add space between checkbox and label */
        }

        .dropdown-menu label:hover {
            background-color: #f1f1f1;
        }

        .custom-dropdown.open .dropdown-menu {
            display: block;
        }

        /* Space between the form fields */
        .date-time-container,
        .start-end-time-container,
        .cottage-table-container {
            margin-bottom: 20px;
        }
    </style>

</head>

<body>
    <header>
        <div class="logo">
            <img src="{{ asset('images/logs.png') }}" alt="WAVES Logo">
            <h1 class="title">WAVES <span>Beach Resort</span></h1>
        </div>
        <nav>
            <a href="#">Book Now</a>
            <a href="#">About Us</a>
            <div class="profile-container">
                <i class="fas fa-user-circle" id="profile-icon" style="font-size: 32px; cursor: pointer;"></i>
                <div class="dropdown-menu" id="dropdown-menu">
                    <a href="#">Profile</a>
                    <a href="#">Logout</a>
                </div>
            </div>
        </nav>
    </header>

    <section class="booking">
        <div class="booking-form">
            <h2>Enjoy Your Vacation</h2>
            <p>7:00 AM - 9:00 PM</p>
            @if(session('success'))
                <div style="color: green;">{{ session('success') }}</div>
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
                        <input type="time" id="startTime" name="startTime" required>
                    </div>
                    <div>
                        <label for="endTime">End Time</label>
                        <input type="time" id="endTime" name="endTime" required>
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

    <script>

        document.addEventListener("DOMContentLoaded", function () {
            // Set the minimum date to today for the date input field
            let today = new Date().toISOString().split('T')[0];
            document.getElementById("date").setAttribute("min", today);
            document.getElementById("date").value = today;
            console.log("Minimum date set to:", today); // Debugging statement

            // Handle dropdown visibility and checkbox selection
            document.querySelectorAll('.dropdown-btn').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    let dropdown = this.parentElement;
                    dropdown.classList.toggle('open');
                });
            });

            // Update minimum end time based on selected start time
            document.getElementById("startTime").addEventListener("change", function () {
                let startTime = this.value;
                document.getElementById("endTime").setAttribute("min", startTime);
            });

            // Fetch and update available amenities when a date is selected
            document.getElementById("date").addEventListener("change", function () {
                let selectedDate = this.value;

                fetch(`/customer/check-availability?date=${selectedDate}`)
                    .then(response => {
                        return response.json();
                    })
                    .then(data => {
                        updateAvailableAmenities(data.availableCottages, data.availableTables);
                    })
                    .catch(error => {
                        console.error("Error fetching availability data:", error); // Debugging statement
                    });

            });

            // Function to update the available cottages and tables dynamically
            function updateAvailableAmenities(cottages, tables) {

                // Check if cottages and tables are arrays
                if (!Array.isArray(cottages) || !Array.isArray(tables)) {
                    return;
                }

                // Update Cottage Dropdown
                let cottageMenu = document.getElementById("cottage-menu");
                cottageMenu.innerHTML = ''; // Clear existing items

                cottages.forEach(cottage => {
                    let label = document.createElement('label');
                    label.innerHTML = `
            <input type="checkbox" name="cottages[]" value="${cottage.id}" id="cottage-${cottage.id}">
            ${cottage.name} - ₱${cottage.price.toFixed(2)}
        `;
                    cottageMenu.appendChild(label);
                });

                // Update Table Dropdown
                let tableMenu = document.getElementById("table-menu");
                tableMenu.innerHTML = ''; // Clear existing items

                tables.forEach(table => {
                    let label = document.createElement('label');
                    label.innerHTML = `
            <input type="checkbox" name="tables[]" value="${table.id}" id="table-${table.id}">
            ${table.name} - ₱${table.price.toFixed(2)}
        `;
                    tableMenu.appendChild(label);
                });
            }


            // Validation before form submission
            function validateSelection() {
                const cottageChecked = document.querySelectorAll('input[name="cottages[]"]:checked').length > 0;
                const tableChecked = document.querySelectorAll('input[name="tables[]"]:checked').length > 0;

                if (!cottageChecked && !tableChecked) {
                    alert("Please select at least one Cottage or Table before submitting.");
                    return false;
                }

                return true;
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


    </script>

</body>

</html>