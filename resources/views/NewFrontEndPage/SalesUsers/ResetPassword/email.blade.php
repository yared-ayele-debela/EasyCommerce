<!-- resources/views/sales/passwords/email.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales User Forgot Password</title>
</head>
<body>
    <form method="POST" action="{{ route('sales.password.email') }}">
        @csrf
        <div>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus>
        </div>
        <div>
            <button type="submit">Send Password Reset Link</button>
        </div>
    </form>
</body>
</html>
