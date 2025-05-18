@extends('auth.layouts.master')

@section('content')
    <section class="login-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-8">
                    <div class="login-card">
                        <div class="login-header">
                            <h2>Welcome Back!</h2>
                            <p>Please login to your account</p>
                        </div>

                        <form class="login-form">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <div class="input-with-icon">
                                    <span class="material-symbols-outlined input-icon">mail</span>
                                    <input type="email" id="email" placeholder="Enter your email" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="password">Password</label>
                                <div class="input-with-icon password">
                                    <span class="material-symbols-outlined input-icon">lock</span>
                                    <input type="password" id="password" placeholder="Enter your password" required>
                                    <button type="button" class="show-password" aria-label="Toggle password visibility">
                                        <span class="material-symbols-outlined visibility-icon">visibility_off</span>
                                    </button>
                                </div>
                            </div>

                            <div class="form-options">
                                <label class="">
                                    <input type="checkbox" id="remember">
                                    Remember me
                                </label>
                                <a href="#" class="forgot-password">Forgot password?</a>
                            </div>

                            <button type="submit" class="btn-login">Login</button>

                            <div class="divider">
                                <span>or continue with</span>
                            </div>

                            <div class="social-login">
                                <a href="{{ url('/auth/google') }}" class="social-btn google">
                                    <img src="{{ asset('assets/images/design/logo/google.png') }}" alt="Google">
                                    Continue with google
                                </a>
                            </div>

                            <div class="register-link">
                                Don't have an account? <a href="signup.html">Sign up</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Register') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="row mb-3">
                                <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

                                <div class="col-md-6">
                                    <input id="name" type="text"
                                        class="form-control @error('name') is-invalid @enderror" name="name"
                                        value="{{ old('name') }}" required autocomplete="name" autofocus>

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="email"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required autocomplete="email">

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="username"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Username') }}</label>

                                <div class="col-md-6">
                                    <input id="username" type="text"
                                        class="form-control @error('username') is-invalid @enderror" name="username"
                                        value="{{ old('username') }}" required autocomplete="username" autofocus>

                                    @error('username')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>


                            <div class="row mb-3">
                                <label for="password"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="new-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password-confirm"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control"
                                        name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Register') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <a href="{{ url('/auth/google') }}" class="btn btn-danger">
                        <i class="fab fa-google"></i> Sign up with Google
                    </a>
                </div>
            </div>
        </div>
    </div> --}}
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            $('.password .show-password').on('click', function() {
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
@endpush
