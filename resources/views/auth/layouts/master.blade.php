<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Skillshoper Quiz System</title>
    <link rel="shortcut icon" href="img/Favicon.png" type="image/x-icon">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

    <link rel="shortcut icon" href="img/favicon.png" type="image/png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/auth-main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/auth-style.css') }}">
</head>

<body>
    <header id="header" class="light">
        <div class="overlay">
            <div class="container">
                <nav class="navbar navbar-expand">
                    <a class="navbar-brand" href="#">
                        <img class="logo" src="{{ asset('assets/images/design/logo/Logo Dark-01.png') }}"
                            alt="">
                        <span class="tag">Quiz System</span>
                    </a>
                </nav>
            </div>
        </div>
    </header>

    @yield('content')

    <footer id="footer">
        <div class="container">
            <div class="content">
                <div class="copyright">
                    &copy; 2023 SKILLSHOPER.COM
                </div>
                <div class="menu">
                    <a href="">Help</a>
                    <a href="">Terms</a>
                    <a href="">Privacy</a>
                    <a href="">About</a>
                    <a href="">Cookie Policy</a>
                </div>
                <div class="social">
                    <a href="" class="social-link">
                        <img src="{{ asset('assets/images/design/logo/in.png') }}" alt="">
                    </a>
                    <a href="" class="social-link">
                        <img src="{{ asset('assets/images/design/logo/twitter.png') }}" alt="">
                    </a>
                    <a href="" class="social-link">
                        <img src="{{ asset('assets/images/design/logo/f.png') }}" alt="">
                    </a>
                    <a href="" class="social-link">
                        <img src="{{ asset('assets/images/design/logo/ytd.png') }}" alt="">
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js">
    </script>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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
    </script>
</body>

</html>
