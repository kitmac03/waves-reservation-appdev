<!DOCTYPE html>
<html>

<head>
    <title>Cottages</title>
</head>

<body>
    <h1>Cottages</h1>
    <form method="POST" action="{{ route('admin/cottages') }}">
        @csrf
        <div>
            <label for="name">Name:</label>
            <input type="text" name="name" required>
        </div>
        <div>
            <label for="name">Price:</label>
            <input type="text" name="price" required placeholder="500.00">
        </div>
        <button type="submit">Save</button>
    </form>
</body>

</html>