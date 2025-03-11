<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Email</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        .container {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            max-width: 500px;
            margin: auto;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        .btn {
            display: inline-block;
            background: #3490dc;
            color: #fff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 10px;
        }
        .code {
            font-size: 20px;
            font-weight: bold;
            color: #333;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Hello, {{ $user->name }}</h2>
        <p>Your 6-digit verification code is:</p>
        <p class="code">{{ $verificationCode }}</p>
        <p>Or, click the button below to verify your email:</p>
        <a href="{{ $url }}" class="btn">Verify Email</a>
        <p>If you didn't request this, you can ignore this email.</p>
    </div>
</body>
</html>
