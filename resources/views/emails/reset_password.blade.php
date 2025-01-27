<!-- resources/views/emails/reset_password.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
</head>
<body>
    <h1>Reset Password</h1>
    <p>Click the link below to reset your password:</p>
    <a href="http://localhost:3000/reset-password">Reset Password</a>
    <p>Your token: {{ $token }}</p>
</body>
</html>
<!--  OPCIJA DA SE ODMA U MEJLU ISPRAVE LOZINKA I MEJL....

<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
</head>
<body>
    <h1>Reset Password</h1>
    <form action="{{ url('password/reset') }}" method="POST">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <label for="email">Email:</label>
        <input type="email" name="email" required>
        <label for="password">New Password:</label>
        <input type="password" name="password" required>
        <label for="password_confirmation">Confirm Password:</label>
        <input type="password" name="password_confirmation" required>
        <button type="submit">Reset Password</button>
    </form>
</body>
</html>


 -->