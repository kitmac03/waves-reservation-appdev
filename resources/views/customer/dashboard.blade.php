<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Reservation</title>
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
    </style>
</head>
<body>
    <div class="container">
        <h2>Create a Reservation</h2>
        @if(session('success'))
        <div style="color: green;">{{ session('success') }}</div>
        @endif
        <form action="{{ route('reservation.store') }}" method="POST">
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
        
            <!-- Cottage Selection -->
            <label for="cottage">Cottage</label>
            <select name="cottage" id="cottage">
                <option value="">Select a Cottage</option>
                @foreach ($cottages as $cottage)
                    <option value="{{ $cottage->id }}">{{ $cottage->name }} - ₱{{ number_format($cottage->price, 2) }}</option>
                @endforeach
            </select>
        
            <!-- Table Selection -->
            <label for="tables">Tables</label>
            <select name="tables" id="tables">
                <option value="">Select a Table</option>
                @foreach ($tables as $table)
                    <option value="{{ $table->id }}">{{ $table->name }} - ₱{{ number_format($table->price, 2) }}</option>
                @endforeach
            </select>
        
            <!-- Submit button -->
            <button type="submit">Submit Reservation</button>
        </form>
    </div>
</body>
</html>
