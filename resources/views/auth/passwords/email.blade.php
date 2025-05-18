@extends('auth.layouts.master')

@section('content')
    <section class="login-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-8">
                    <div class="login-card">
                        <div class="login-header">
                            <h2>Forget Password?</h2>
                            <small class="text-muted">Please enter your email to reset your password</small>
                        </div>

                        {{-- Success message --}}
                        @if (session('status'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>Success!</strong> {{ session('status') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        {{-- Error message --}}
                        @error('email')
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Oops!</strong> {{ $message }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @enderror

                        <form method="POST" action="{{ route('password.email') }}" class="signup-form">
                            @csrf

                            <div class="form-group">
                                <label for="email">Email</label>
                                <div class="input-with-icon">
                                    <span class="material-symbols-outlined input-icon">mail</span>
                                    <input id="email" type="email" name="email" value="{{ old('email') }}"
                                        class="@error('email') is-invalid @enderror" placeholder="Enter your email" required
                                        autocomplete="email" autofocus>
                                </div>
                            </div>

                            <button type="submit" class="btn-login">Send Reset Link</button>

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
