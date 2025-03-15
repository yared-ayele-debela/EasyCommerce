<html>
    <head>

    </head>
    <body>
        <h1 style="align-items: center"><strong>{{ $email_template->name }}</strong></h1>
        <br>
        <tr><td>Dear {{ $name }}</td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>Your Vendor Account has been approved. Now you can login and add Products.</td></tr>
        <tr><td>&nbsp;<br><br></td></tr>
        <tr><td>Your Vendor Account Details are as below :-<br></td></tr>
        <tr><td>&nbsp;<br></td></tr>
        <tr><td>Name :{{ $name }}</td></tr>
        <tr><td>&nbsp;<br></td></tr>
        <tr><td>Mobile :{{ $mobile }}</td></tr>
        <tr><td>&nbsp;<br></td></tr>
        <tr><td>Email :{{ $email }}</td></tr>
        <tr><td>&nbsp;<br></td></tr>
        <tr><td>Password : ******(as chosen by you)</td></tr>
        <tr><td>&nbsp;<br></td></tr>
        <br>
        Best regards,<br>
        {{ $email_template->name }} company<br>
        Address : {{ $email_template->address }} <br>
        Email :{{ $email_template->email }} <br>
        Phone :{{ $email_template->phone }} <br>
    </body>
</html>
