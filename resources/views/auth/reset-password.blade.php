<!DOCTYPE html>
<html>
<head>
    <title>Resetovanje lozinke</title>
</head>
<body>
    <h1>Resetovanje lozinke</h1>
    <form action="{{ url('api/korisnici/' . $userId . '/promena-lozinke/' . $token) }}" method="POST">
        @csrf
        <div class="input-group">
            <label>Nova lozinka:</label>
            <input type="password" name="password" required>
        </div>
        <div class="input-group">
            <label>Potvrda nove lozinke:</label>
            <input type="password" name="password_confirmation" required>
        </div>
        <button type="submit">Resetuj lozinku</button>
    </form>
</body>
</html>