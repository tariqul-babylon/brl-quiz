@extends('front.layouts.app')

@section('content')
    <section class="login-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-8">
                    <div class="login-card">
                        <div class="login-header">
                            <h2>Reset Password</h2>
                        </div>

                        <form method="POST" action="{{ route('password.update') }}" class="signup-form">
                            @csrf
                            <input type="hidden" name="token" value="{{ $token }}">

                            <div class="form-group">
                                <label for="email">Email</label>
                                <div class="input-with-icon">
                                    <span class="material-symbols-outlined input-icon">mail</span>
                                    <input id="email" type="email" name="email" value="{{ $email ?? old('email') }}"
                                        class="@error('email') is-invalid @enderror" placeholder="Enter your email" required
                                        autocomplete="email" autofocus>
                                </div>
                                @error('email')
                                    <span class="text-danger"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="password">Password</label>
                                <div class="input-with-icon password">
                                    <span class="material-symbols-outlined input-icon">lock</span>
                                    <input id="password" type="password" name="password"
                                        class="@error('password') is-invalid @enderror" placeholder="Enter your password"
                                        required autocomplete="new-password">
                                    <button type="button" class="show-password" aria-label="Toggle password visibility">
                                        <span class="material-symbols-outlined visibility-icon">visibility_off</span>
                                    </button>
                                </div>
                                @error('password')
                                    <span class="text-danger"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="password-confirm">Confirm Password</label>
                                <div class="input-with-icon password">
                                    <span class="material-symbols-outlined input-icon">lock</span>
                                    <input id="password-confirm" type="password" name="password_confirmation"
                                        placeholder="Confirm password" required autocomplete="new-password">
                                    <button type="button" class="show-password" aria-label="Toggle password visibility">
                                        <span class="material-symbols-outlined visibility-icon">visibility_off</span>
                                    </button>
                                </div>
                            </div>

                            <button type="submit" class="btn-login">Reset Password</button>

                            <div class="register-link mt-3">
                                Go to <a href="{{ route('login') }}">Login</a>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
