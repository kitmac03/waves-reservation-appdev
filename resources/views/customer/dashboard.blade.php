<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WAVES Beach Resort</title>
    <link rel="stylesheet" href="{{ asset('css/res.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Jaldi&family=Allura&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <header>
        <div class="logo">
            <!-- Correct path to image in the public/images folder -->
            <img src="{{ asset('images/logs.png') }}" alt="WAVES Logo">
            <h1 class="title">WAVES <span>Beach Resort</span></h1>
        </div>
        <nav>
            <a href="#">Book Now</a>
            <a href="#">About Us</a>
            <i class="fas fa-user-circle"></i>
        </nav>
    </header>

    <section class="booking">
        <div class="booking-form">
            <h2>Enjoy Your Vacation</h2>
            <p>7:00 AM - 9:00 PM</p>
            <input type="date">
            <input type="time">
            <label for="cottage">Cottage:</label>
            <select id="cottage">
                <option>Select</option>
            </select>
            <label for="table">Table:</label>
            <select id="table">
                <option>Select</option>
            </select>
        
            <!-- Submit button -->
            <button type="submit">Submit Reservation</button>
        </form>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let today = new Date().toISOString().split('T')[0];
            document.getElementById("date").setAttribute("min", today);
            document.getElementById("date").value = today;
        });
    
        document.getElementById("startTime").addEventListener("change", function () {
            let startTime = this.value;
            document.getElementById("endTime").setAttribute("min", startTime);
        });
    
        function validateSelection() {
            let cottage = document.getElementById("cottage").value;
            let table = document.getElementById("tables").value;
    
            if (!cottage && !table) {
                alert("Please select either a Cottage or a Table before submitting.");
                return false;
            }
    
            return true;
        }
    </script>
</body>
</html>
