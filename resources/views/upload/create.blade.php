<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Fajla</title>
</head>
<body>
    <h1>Upload Fajla</h1>
    <!-- Forma za upload fajla -->
    <form action="{{ route('upload.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div>
            <label for="file">Izaberite fajl:</label>
            <input type="file" id="file" name="file" required>
        </div>
        <button type="submit">Upload</button>
    </form>
</body>
</html>