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
    <title>Customer Reservations</title>
</head>

<body>
    <div class="main-content">
        <h1>Customer Reservation Details: {{ $customer->name }}</h1>
        <div class="customer-info">
            <p><span class="material-icons">email</span> {{ $customer->email }}</p>
            <p><span class="material-icons">phone</span> {{ $customer->number }}</p>
        </div>

        <div class="reservation-container">
            <h2 class="reservations-title">Customer's Reservations</h2>
            <div class="legend">
                <span class="legend-item verified">Verified</span>
                <span class="legend-item pending">Pending</span>
                <span class="legend-item completed">Completed</span>
                <span class="legend-item cancelled">Cancelled/Invalid</span>
            </div>

            <div class="columns">
                <!-- Verified (Current) -->
                <div class="column verified-column">
                    <h3 class="column-title">Verified (Current)</h3>
                    <div class="reservation-list">
                        @forelse($verifiedReservations as $res)
                            <div class="reservation-card verified">
                                <div class="reservation-id">#{{ $res->id }}</div>
                                <div class="reservation-amenity">
                                    <span class="material-icons">apartment</span>
                                    {{ optional(optional($res->reservedAmenities->first())->amenity)->name ?? 'No Amenity' }}
                                </div>
                                <div class="reservation-datetime">
                                    <div class="reservation-date">
                                        <span class="material-icons">calendar_today</span>
                                        {{ $res->date }}
                                    </div>
                                    <div class="reservation-time">
                                        <span class="material-icons">schedule</span>
                                        {{ $res->time }}
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="empty-state">
                                <span class="material-icons">info</span>
                                No records
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Pending -->
                <div class="column pending-column">
                    <h3 class="column-title">Pending</h3>
                    <div class="reservation-list">
                        @forelse($pendingReservations as $res)
                            <div class="reservation-card pending">
                                <div class="reservation-id">#{{ $res->id }}</div>
                                <div class="reservation-amenity">
                                    <span class="material-icons">apartment</span>
                                    {{ optional(optional($res->reservedAmenities->first())->amenity)->name ?? 'No Amenity' }}
                                </div>
                                <div class="reservation-datetime">
                                    <div class="reservation-date">
                                        <span class="material-icons">calendar_today</span>
                                        {{ $res->date }}
                                    </div>
                                    <div class="reservation-time">
                                        <span class="material-icons">schedule</span>
                                        {{ $res->time }}
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="empty-state">
                                <span class="material-icons">info</span>
                                No records
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Completed -->
                <div class="column completed-column">
                    <h3 class="column-title">Completed</h3>
                    <div class="reservation-list">
                        @forelse($completedReservations as $res)
                            <div class="reservation-card completed">
                                <div class="reservation-id">#{{ $res->id }}</div>
                                <div class="reservation-amenity">
                                    <span class="material-icons">apartment</span>
                                    {{ optional(optional($res->reservedAmenities->first())->amenity)->name ?? 'No Amenity' }}
                                </div>
                                <div class="reservation-datetime">
                                    <div class="reservation-date">
                                        <span class="material-icons">calendar_today</span>
                                        {{ $res->date }}
                                    </div>
                                    <div class="reservation-time">
                                        <span class="material-icons">schedule</span>
                                        {{ $res->time }}
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="empty-state">
                                <span class="material-icons">info</span>
                                No records
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Cancelled/Invalid -->
                <div class="column cancelled-column">
                    <h3 class="column-title">Cancelled/Invalid</h3>
                    <div class="reservation-list">
                        @forelse($redReservations as $res)
                            <div class="reservation-card cancelled">
                                <div class="reservation-id">#{{ $res->id }}</div>
                                <div class="reservation-amenity">
                                    <span class="material-icons">apartment</span>
                                    {{ optional(optional($res->reservedAmenities->first())->amenity)->name ?? 'No Amenity' }}
                                </div>
                                <div class="reservation-datetime">
                                    <div class="reservation-date">
                                        <span class="material-icons">calendar_today</span>
                                        {{ $res->date }}
                                    </div>
                                    <div class="reservation-time">
                                        <span class="material-icons">schedule</span>
                                        {{ $res->time }}
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="empty-state">
                                <span class="material-icons">info</span>
                                No records
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
