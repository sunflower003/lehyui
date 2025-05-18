<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'LehyUI')</title>

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}"> <!-- nếu cần -->
</head>
<body>
    @yield('content')

    <!-- JS -->
    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
