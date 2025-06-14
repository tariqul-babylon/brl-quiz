<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Skillshoper Quiz System</title>
    <link rel="shortcut icon" href="{{ asset('front') }}/img/Favicon.png" type="image/x-icon">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link href="{{ asset('front') }}/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('front') }}/scss/main.css">
    <link rel="stylesheet" href="{{ asset('front') }}/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" />
    <style>
        .form-control:focus,
        .form-select:focus {
            box-shadow: none;
        }

        #header .overlay nav .navbar-nav .nav-item .nav-link {
            padding: 5px 12px;
        }
    </style>
    @stack('css')
    @livewireStyles
</head>

<body>
    <header id="header" class="light">
        <div class="overlay">
            <div class="container">
                @include('front.layouts.navbar')
            </div>
        </div>
    </header>

    <div class="mb-5" style="min-height: 80vh;">
        @yield('content')
    </div>


    @include('front.layouts.footer')
    <script src="{{ asset('front') }}/js/jquery-3.7.0.min.js"></script>
    <script src="{{ asset('front') }}/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    @stack('js')
    <script>
        $(document).ready(function() {
            $('.password .show-password').on('click', function() {
                const input = $(this).siblings('input');
                const icon = $(this).find('.visibility-icon');
                if (input.attr('type') === 'password') {
                    input.attr('type', 'text');
                    icon.text('visibility');
                } else {
                    input.attr('type', 'password');
                    icon.text('visibility_off');
                }
            });
        });
        flatpickr("#exam_start_time", {
            enableTime: true,
            dateFormat: "Y-m-d H:i",
            time_24hr: true,
            // optionally set minDate, maxDate here
        });

        flatpickr("#exam_end_time", {
            enableTime: true,
            dateFormat: "Y-m-d H:i",
            time_24hr: true,
            // optionally set minDate, maxDate here
        });
    </script>
    @livewireScripts
</body>

</html>
