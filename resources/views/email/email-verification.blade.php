<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
</head>
<body>
    <h1>Email Verification</h1>
    <p>Please verify your email address by clicking the link below:</p>
    <a   target="_blank" href="{{url('check_email/'.$user->remember_token)}}">Verify Email</a>
</body>
</html>