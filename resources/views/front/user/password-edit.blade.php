@extends('front.layouts.app')

@section('content')
    <div class="container py-5">
        <div class="page-title">
            <div class="d-flex justify-content-between align-items-end">
                <h1 class="title">Update Profile</h1>
            </div>
        </div>

        <div class="page-content">
            <div class="card p-3">
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success">{{ session('status') }}</div>
                    @endif

                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        <div class="row row-cols-1 row-cols-md-2 g-3">
                            {{-- Current Password --}}
                            <div class="form-group position-relative">
                                <label for="current_password">Current Password</label>
                                <div class="input-with-icon password">
                                    <span class="material-symbols-outlined input-icon">lock</span>
                                    <input type="password" name="current_password" id="current_password"
                                        class="form-control ps-5" required>
                                    <button type="button"
                                        class="show-password position-absolute top-50 end-0 translate-middle-y me-2"
                                        data-target="current_password" aria-label="Toggle password visibility">
                                        <span class="material-symbols-outlined visibility-icon">visibility_off</span>
                                    </button>
                                </div>
                                @error('current_password')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- New Password --}}
                            <div class="form-group position-relative">
                                <label for="new_password">New Password</label>
                                <div class="input-with-icon password">
                                    <span class="material-symbols-outlined input-icon">lock</span>
                                    <input type="password" name="new_password" id="new_password" class="form-control ps-5"
                                        required>
                                    <button type="button"
                                        class="show-password position-absolute top-50 end-0 translate-middle-y me-2"
                                        data-target="new_password" aria-label="Toggle password visibility">
                                        <span class="material-symbols-outlined visibility-icon">visibility_off</span>
                                    </button>
                                </div>
                                @error('new_password')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- Confirm New Password --}}
                            <div class="form-group position-relative">
                                <label for="new_password_confirmation">Confirm New Password</label>
                                <div class="input-with-icon password">
                                    <span class="material-symbols-outlined input-icon">lock</span>
                                    <input type="password" name="new_password_confirmation" id="new_password_confirmation"
                                        class="form-control ps-5" required>
                                    <button type="button"
                                        class="show-password position-absolute top-50 end-0 translate-middle-y me-2"
                                        data-target="new_password_confirmation" aria-label="Toggle password visibility">
                                        <span class="material-symbols-outlined visibility-icon">visibility_off</span>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="text-end">
                            <button class="btn btn-primary">Update Password</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection
