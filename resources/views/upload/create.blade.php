<!DOCTYPE html>
<html>

<head>
    <title>Upload File</title>
</head>

<body>
    <h1>Upload File</h1>
    <!-- <form action="{{ route('upload.store') }}" method="POST" enctype="multipart/form-data"> -->
    <form action="{{ route('upload.store') }}" method="POST" enctype="multipart/form-data">

        @csrf
        <div>
            <label for="file">Choose file:</label>
            <input type="file" id="file" name="file" required>
        </div>
        <button type="submit">Upload</button>
    </form>
</body>

</html>