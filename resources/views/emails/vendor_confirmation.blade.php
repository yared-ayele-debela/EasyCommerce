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
        <tr><td>Please click on below link to confirm your Vendor Account :</td></tr>
        <tr><td> <a href="{{ url('vendor/confirm/'.$code) }}"> {{ url('vendor/confirm/'.$code) }} </a></td></tr>
        <tr><td>&nbsp;</td></tr>
        <br>
        Best regards,<br>
        {{ $email_template->name }} company<br>
        Address : {{ $email_template->address }} <br>
        Email :{{ $email_template->email }} <br>
        Phone :{{ $email_template->phone }} <br>
    </body>
</html>
