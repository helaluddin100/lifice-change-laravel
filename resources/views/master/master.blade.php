<!DOCTYPE html>
<html
    lang="en"style="--headding-color: #fff; --paragraph-color: #E2E8F0; --primary-color-2: #22C55E; --primary-color-border: #2A313C; --primary-color: #22C55E; --warning-color: #FACC15; --alerts-color: #FF4747; --other-color: #FF784B; --grey-color: #2A313C; --grey-color-border: #edf2f7; --body-bg-color: #23262B; --bg-color: #1D1E24; --greyscale-3: #191B1F; --greyscale-4: #293644; --greyscale-5: #D9FBE6; --greyscale-200: rgba(226, 232, 240, 0.7); --greyscale-1: #2A313C; --bg-color-2: #23262B;">

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
    </div>
    @yield('js')


</body>

</html>
