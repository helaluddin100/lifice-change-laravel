<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- fave-icon  -->
    <link rel="shortcut icon" href="assets/images/icon/fave-icon.png" type="image/png">

    <link href="https://fonts.googleapis.com/css2?family=Urbanist:wght@300;400;500;600;700;900&amp;display=swap"
        rel="stylesheet">

    @include('layouts.backend.style')

</head>

<body>
    <div class="body-bg">
        {{-- @include('sweetalert::alert') --}}
        @include('layouts.backend.sidebar')
        @include('layouts.backend.nav')
        @yield('content')
        @include('layouts.backend.js')
        @yield('js')
    </div>

</body>

</html>
