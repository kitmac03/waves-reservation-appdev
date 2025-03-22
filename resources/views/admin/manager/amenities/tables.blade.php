<!DOCTYPE html>
<html>

<head>
    <title>Tables</title>
</head>

<body>
    <h1>Tables</h1>
    <form method="POST" action="{{ route('admin/tables') }}">
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