<html>
    <head>

    </head>
    <body>
        <tr>
            <td style="text-align: center;">
                <h1><strong>{{ $email_template->name }}</strong></h1>
            </td>
        </tr><br>
        <tr><td>Dear {{ $name }}</td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>Your Vendor Email is confirmed. Please login and add your personal, business and bank details so that your account will get approved.</td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>Your Vendor Account Details are as below :-<br></td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>Name :{{ $name }}</td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>Mobile :{{ $mobile }}</td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>Email :{{ $email }}</td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>Password : ******(as chosen by you)</td></tr>
        <tr><td>&nbsp;</td></tr>
        <br>
        Best regards,<br>
        {{ $email_template->name }} company<br>
        Address : {{ $email_template->address }} <br>
        Email :{{ $email_template->email }} <br>
        Phone :{{ $email_template->phone }} <br>
    </body>
</html>
