<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/del_req.css') }}">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <title>Account Deletion</title>
</head>

<body>

    <div class="main-content">
        <h1>Customer Reservation Details: {{ $customer->name }}</h1>
        <p><strong>Email:</strong> {{ $customer->email }}</p>
        <p><strong>Phone:</strong> {{ $customer->number }}</p>

        <div class="reservations-section">
            <h2 class="reservations-title">Customer’s Reservations</h2>
            <div class="legend">
                <span class="legend-item verified">Verified</span>
                <span class="legend-item pending">Pending</span>
                <span class="legend-item cancelled">Cancelled</span>
                <span class="legend-item completed">Completed</span>
            </div>

            <div class="columns">
                <!-- Cancelled / Invalid -->
                <div class="column cancelled-column">
                    <h3 class="column-title">Cancelled / Invalid</h3>
                    @forelse($redReservations as $res)
                        <div class="reservation">
                            <span>#{{ $res->id }}</span>
                            <span>{{ optional($res->reservedAmenities->first()->amenity)->name ?? 'No Amenity' }}</span>
                            <span>{{ $res->date }}</span>
                            <span>{{ $res->time }}</span>
                        </div>
                    @empty
                        <p>No records</p>
                    @endforelse
                </div>

                <!-- Pending -->
                <div class="column current-column">
                    <h3 class="column-title">Pending</h3>
                    @forelse($pendingReservations as $res)
                        <div class="reservation">
                            <span>#{{ $res->id }}</span>
                            <span>{{ optional(optional($res->reservedAmenities->first())->amenity)->name ?? 'No Amenity' }}</span>
                            <span>{{ $res->date }}</span>
                            <span>{{ $res->time }}</span>
                        </div>
                    @empty
                        <p>No records</p>
                    @endforelse
                </div>

                <!-- Verified / Current -->
                <div class="column current-column">
                    <h3 class="column-title">Verified (Current)</h3>
                    @forelse($verifiedReservations as $res)
                        <div class="reservation">
                            <span>#{{ $res->id }}</span>
                            <span>{{ optional($res->reservedAmenities->first()->amenity)->name ?? 'No Amenity' }}</span>
                            <span>{{ $res->date }}</span>
                            <span>{{ $res->time }}</span>
                        </div>
                    @empty
                        <p>No records</p>
                    @endforelse
                </div>

                <!-- Completed -->
                <div class="column completed-column">
                    <h3 class="column-title">Completed</h3>
                    @forelse($completedReservations as $res)
                        <div class="reservation">
                            <span>#{{ $res->id }}</span>
                            <span>{{ optional($res->reservedAmenities->first()->amenity)->name ?? 'No Amenity' }}</span>
                            <span>{{ $res->date }}</span>
                            <span>{{ $res->time }}</span>
                        </div>
                    @empty
                        <p>No records</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</body>

</html>