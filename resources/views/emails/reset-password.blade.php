<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
</head>
<body>
    <h1>Forget Password Email</h1>
    You can reset password from bellow link:
    <a href="{{ route('admin.reset.password', $token) }}">Reset Password</a>
    <br>
    If you did not request a password reset, please ignore this email. Your account remains secure, and no changes have been made.
    <br>
    Best regards,<br>
    {{ $email_template->name }} company<br>
    Address : {{ $email_template->address }} <br>
    Email :{{ $email_template->email }} <br>
    Phone :{{ $email_template->phone }} <br>
</body>
</html>
