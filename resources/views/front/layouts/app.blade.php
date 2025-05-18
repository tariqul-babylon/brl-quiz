<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Skillshoper Quiz System</title>
    <link rel="shortcut icon" href="{{asset('front')}}/img/Favicon.png" type="image/x-icon">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link href="{{asset('front')}}/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('front')}}/scss/main.css">
    <link rel="stylesheet" href="{{asset('front')}}/css/style.css">
    @stack('css')
</head>

<body>
    <header id="header" class="light">
        <div class="overlay">
            <div class="container">
                @include('front.layouts.navbar')
            </div>
        </div>
    </header>

    @yield('content')

    @include('front.layouts.footer')
    <script src="{{asset('front')}}/js/jquery-3.7.0.min.js"></script>
    <script src="{{asset('front')}}/js/bootstrap.bundle.min.js"></script>
    @stack('js')
    <script>
        $(document).ready(function () {
            $('.password .show-password').on('click', function () {
                const passwordField = $(this).find('input');
                if (passwordField.attr('type') == 'password') {
                    passwordField.attr('type', 'text');
                    $(this).find('.visibility-icon').text('visibility');
                } else {
                    passwordField.attr('type', 'password');
                    $(this).find('.visibility-icon').text('visibility_off');
                }
            });
        });
    </script>
</body>

</html>