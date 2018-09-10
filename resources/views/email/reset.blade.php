<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>

<div>
    Hi {{ $name }},
    <br>
    Below is the code to reset your password:
    <br>
    Reset code: <b>{{ $reset_code }}</b>
    <br><br>
    Use the above code to reset your password from here:
    <br>
    <a href="{{ $reset_app_url }}">Reset Password</a>
    <br/>
</div>

</body>
</html>