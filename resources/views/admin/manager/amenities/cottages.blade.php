<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cottages Management</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}"> <!-- Adjust if needed -->
</head>
<body>
    <h1>Cottages</h1>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Add Cottage Form -->
    <form action="{{ route('admin.cottages') }}" method="POST">
        @csrf
        <input type="text" name="name" placeholder="Cottage Name" required>
        <input type="number" name="price" placeholder="Price" required step="0.01">
        <button type="submit">Add Cottage</button>
    </form>

    <!-- Include Table Component -->
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Price</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cottages as $cottage)
                <tr>
                    <td>{{ $cottage->id }}</td>
                    <td>{{ $cottage->name }}</td>
                    <td>{{ $cottage->price }}</td>
                    <td>
                        <!-- Edit Button -->
                        <a href="{{ route('cottages.edit', $cottage->id) }}">Edit</a>
    
                        <!-- Archive Button -->
                        <form action="{{ route('cottages.archive', $cottage->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('PATCH')
                            <button type="submit">Archive</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    

</body>
</html>
