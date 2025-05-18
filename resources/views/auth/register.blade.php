@extends('auth.layouts.master')

@section('content')
    <section class="login-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-8">
                    <div class="login-card">
                        <div class="login-header">
                            <h2>Create Account</h2>
                            <p>Register to start using your account</p>
                        </div>

                        <form class="login-form" method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="form-group">
                                <label for="name">Name</label>
                                <div class="input-with-icon">
                                    <span class="material-symbols-outlined input-icon">person</span>
                                    <input type="text" name="name" id="name" placeholder="Enter your name"
                                        required value="{{ old('name') }}">
                                </div>
                                @error('name')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="email">Email</label>
                                <div class="input-with-icon">
                                    <span class="material-symbols-outlined input-icon">mail</span>
                                    <input type="email" name="email" id="email" placeholder="Enter your email"
                                        required value="{{ old('email') }}">
                                </div>
                                @error('email')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="password">Password</label>
                                <div class="input-with-icon password">
                                    <span class="material-symbols-outlined input-icon">lock</span>
                                    <input type="password" name="password" id="password" placeholder="Enter your password"
                                        required>
                                    <button type="button" class="show-password" aria-label="Toggle password visibility">
                                        <span class="material-symbols-outlined visibility-icon">visibility_off</span>
                                    </button>
                                </div>
                                @error('password')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="password_confirmation">Confirm Password</label>
                                <div class="input-with-icon password">
                                    <span class="material-symbols-outlined input-icon">lock</span>
                                    <input type="password" name="password_confirmation" id="password_confirmation"
                                        placeholder="Confirm password" required>
                                </div>
                            </div>

                            <button type="submit" class="btn-login">Register</button>

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
                                Already have an account? <a href="{{ route('login') }}">Login</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('js')
    <script></script>
@endpush
