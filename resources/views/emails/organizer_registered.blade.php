<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Organizer Account</title>
</head>

<body>
    <h2>Hello, {{ $user->name }}</h2>
    <p>Welcome to our platform as an Organizer!</p>
    <p>Your account has been created successfully. Here are your login details:</p>
    <p><strong>Email:</strong> {{ $user->email }}</p>
    <p><strong>Password:</strong> {{ $randomPassword }}</p>
    <p>We recommend that you change your password after logging in for the first time.</p>
    <p>Thank you for joining us!</p>
</body>

</html>
