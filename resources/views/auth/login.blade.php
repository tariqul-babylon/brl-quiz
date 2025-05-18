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

                        <form method="POST" action="{{ route('login') }}" class="login-form">
                            @csrf

                            <div class="form-group">
                                <label for="email">Email</label>
                                <div class="input-with-icon">
                                    <span class="material-symbols-outlined input-icon">mail</span>
                                    <input type="email" id="email" name="email"
                                        class="@error('email') is-invalid @enderror" placeholder="Enter your email"
                                        value="{{ old('email') }}" required autocomplete="email" autofocus>
                                </div>
                                @error('email')
                                    <span class="text-danger" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="password">Password</label>
                                <div class="input-with-icon password">
                                    <span class="material-symbols-outlined input-icon">lock</span>
                                    <input type="password" id="password" name="password"
                                        class="@error('password') is-invalid @enderror" placeholder="Enter your password"
                                        required autocomplete="current-password">
                                    <button type="button" class="show-password" aria-label="Toggle password visibility">
                                        <span class="material-symbols-outlined visibility-icon">visibility_off</span>
                                    </button>
                                </div>
                                @error('password')
                                    <span class="text-danger" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <div class="form-options">
                                <label>
                                    <input type="checkbox" name="remember" id="remember"
                                        {{ old('remember') ? 'checked' : '' }}>
                                    Remember me
                                </label>
                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" class="forgot-password">Forgot password?</a>
                                @endif
                            </div>

                            <button type="submit" class="btn-login">Login</button>

                            <div class="divider">
                                <span>or continue with</span>
                            </div>

                            <div class="social-login">
                                <a href="{{ url('/auth/google') }}" class="social-btn google">
                                    <img src="{{ asset('assets/images/design/logo/google.png') }}" alt="Google">
                                    Continue with Google
                                </a>
                            </div>

                            <div class="register-link">
                                Don't have an account? <a href="{{ route('register') }}">Sign up</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
