<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>

<div>
    Hi {{ $name }},
    <br>
    Use the below link to reset your account password:
    <br>
    <a href="{{ $reset_app_url.''.$reset_code }}">Reset Password</a>
    <br/>
</div>

</body>
</html>