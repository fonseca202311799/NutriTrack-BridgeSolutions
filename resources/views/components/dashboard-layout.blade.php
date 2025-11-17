<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login and Registration</title>

    @vite(['resources/css/dashboard.css', 'resources/js/dashboard.js'])
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/7c33d9b7cf.js" crossorigin="anonymous"></script>
    <link rel="icon" type="image/png" href="{{ asset('images/small_logo.png') }}">
</head>
<body>
    <div class="header">
        {{ $slot }}
    </div>
</body>
</html>
