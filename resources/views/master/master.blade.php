<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="Responsive HTML Admin Dashboard Template based on Bootstrap 5">
    <meta name="author" content="NobleUI">
    <meta name="keywords"
        content="nobleui, bootstrap, bootstrap 5, bootstrap5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

    <title>Admin BuyTiq | Build & Scale Your Online Store with the Best E-Commerce SaaS</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <!-- End fonts -->

    @include('layouts.backend.style')
</head>

<body>
    <div class="main-wrapper">
        @include('sweetalert::alert')

        @include('layouts.backend.sidebar')

        <!-- partial -->

        <div class="page-wrapper">

            <!-- partial:partials/_navbar.html -->
            @include('layouts.backend.nav')

            <!-- partial -->

            @yield('content')

            <!-- partial:partials/_footer.html -->
            @include('layouts.backend.footer')
            <!-- partial -->

        </div>
    </div>

    @include('layouts.backend.js')
    <!-- End custom js for this page -->
    @yield('js')
    <script>
        $(document).ready(function() {
            const body = $("body");

            // Sidebar toggle
            $(".sidebar-toggler").on("click", function(e) {
                e.preventDefault();

                $(".sidebar-toggler").toggleClass("active not-active");

                if (window.matchMedia("(min-width: 992px)").matches) {
                    body.toggleClass("sidebar-folded");
                } else {
                    body.toggleClass("sidebar-open");
                }
            });

            // Settings sidebar toggle
            $(".settings-sidebar-toggler").on("click", function(e) {
                body.toggleClass("settings-open");
            });

            // Close sidebar on outside click (mobile/tablet)
            $(document).on("click touchstart", function(e) {
                if (
                    !$(e.target).closest(
                        ".sidebar-toggler, .sidebar, .sidebar-body"
                    ).length
                ) {
                    if (body.hasClass("sidebar-open")) {
                        body.removeClass("sidebar-open");
                    }
                }
            });
        });
    </script>
</body>

</html>
