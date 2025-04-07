<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Reservation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Add some styling for better presentation -->
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
        }
        input, select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 4px;
            border: 1px solid #ccc;
            font-size: 14px;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            font-size: 16px;
            cursor: pointer;
            border-radius: 4px;
        }
        button:hover {
            background-color: #45a049;
        }
        .dropdown {
            position: relative;
            display: inline-block;
            width: 100%;
            margin-bottom: 15px;
        }

        .dropdown-btn {
            width: 100%;
            padding: 10px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 4px;
            background-color: white;
            text-align: left;
            cursor: pointer;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: white;
            width: 100%;
            border: 1px solid #ccc;
            box-shadow: 0px 4px 6px rgba(0,0,0,0.1);
            z-index: 1;
            max-height: 200px;
            overflow-y: auto;
            padding: 10px;
        }

        .dropdown-content label {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
        }

        .dropdown-content input[type="checkbox"] {
            margin-right: 6px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Create a Reservation</h2>
        @if(session('success'))
        <div style="color: green;">{{ session('success') }}</div>
        @endif
        <form action="{{ route('reservation.store') }}" method="POST" onsubmit="return validateSelection()">
            @csrf
        
            <!-- Date picker -->
            <label for="date">Reservation Date</label>
            <input type="date" id="date" name="date" required>
        
            <!-- Start time picker -->
            <label for="startTime">Start Time</label>
            <input type="time" id="startTime" name="startTime" required>
        
            <!-- End time picker -->
            <label for="endTime">End Time</label>
            <input type="time" id="endTime" name="endTime" required>
        
            <!-- Cottages Dropdown -->
            <label for="cottagesDropdown" class="form-label">Cottages</label>
            <div class="dropdown mb-3">
                <button class="btn btn-outline-secondary dropdown-toggle w-100" type="button" id="cottagesDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    Select Cottages
                </button>
                <ul class="dropdown-menu w-100 px-3" aria-labelledby="cottagesDropdown" style="max-height: 200px;">
                    @foreach ($cottages as $cottage)
                        @if ($cottage->is_active)
                            <li class="form-check">
                                <input class="form-check-input p-2" type="checkbox" name="cottages[]" value="{{ $cottage->id }}" id="cottage-{{ $cottage->id }}">
                                <label class="form-check-label ps-3 pt-1" for="cottage-{{ $cottage->id }}">
                                    {{ $cottage->name }} - ₱{{ number_format($cottage->price, 2) }}
                                </label>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </div>

            <!-- Tables Dropdown -->
            <label for="tablesDropdown" class="form-label">Tables</label>
            <div class="dropdown mb-3">
                <button class="btn btn-outline-secondary dropdown-toggle w-100" type="button" id="tablesDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    Select Tables
                </button>
                <ul class="dropdown-menu w-100 px-3" aria-labelledby="tablesDropdown" style="max-height: 300px; overflow-y: auto;">
                    @foreach ($tables as $table)
                        @if ($table->is_active)
                            <li class="form-check">
                                <input class="form-check-input p-2" type="checkbox" name="tables[]" value="{{ $table->id }}" id="table-{{ $table->id }}">
                                <label class="form-check-label ps-3 pt-1" for="table-{{ $table->id }}">
                                    {{ $table->name }} - ₱{{ number_format($table->price, 2) }}
                                </label>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </div>
        
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
            const cottageChecked = document.querySelectorAll('input[name="cottages[]"]:checked').length > 0;
            const tableChecked = document.querySelectorAll('input[name="tables[]"]:checked').length > 0;

            if (!cottageChecked && !tableChecked) {
                alert("Please select at least one Cottage or Table before submitting.");
                return false;
            }

            return true;
        }
</script>

    </script>
</body>
</html>
