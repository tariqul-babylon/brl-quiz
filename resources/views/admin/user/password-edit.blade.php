@extends('admin.layout.master')

@section('content')
    <div class="page-title">
        <div class="d-flex justify-content-between align-items-end">
            <h1 class="title">Change Password</h1>
        </div>
    </div>

    <div class="page-content">
        <div class="card">
            <div class="card-body">
                @if (session('status'))
                    <div class="alert alert-success">{{ session('status') }}</div>
                @endif

                <form method="POST" action="{{ route('admin.password.update') }}">
                    @csrf
                    <div class="row row-cols-1 row-cols-md-2 g-3">

                        {{-- Current Password --}}
                        <div>
                            <label for="current_password" class="form-label">Current Password</label>
                            <div class="position-relative">
                                <input type="password" id="current_password" name="current_password"
                                    class="form-control @error('current_password') is-invalid @enderror" required>
                                <button type="button"
                                    class="btn btn-sm btn-light position-absolute top-0 end-0 mt-2 me-2 toggle-password"
                                    data-target="current_password">
                                    <span class="material-symbols-outlined visibility-icon">visibility_off</span>
                                </button>
                            </div>
                            @error('current_password')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- New Password --}}
                        <div>
                            <label for="new_password" class="form-label">New Password</label>
                            <div class="position-relative">
                                <input type="password" id="new_password" name="new_password"
                                    class="form-control @error('new_password') is-invalid @enderror" required>
                                <button type="button"
                                    class="btn btn-sm btn-light position-absolute top-0 end-0 mt-2 me-2 toggle-password"
                                    data-target="new_password">
                                    <span class="material-symbols-outlined visibility-icon">visibility_off</span>
                                </button>
                            </div>
                            @error('new_password')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Confirm Password --}}
                        <div>
                            <label for="new_password_confirmation" class="form-label">Confirm New Password</label>
                            <div class="position-relative">
                                <input type="password" id="new_password_confirmation" name="new_password_confirmation"
                                    class="form-control" required>
                                <button type="button"
                                    class="btn btn-sm btn-light position-absolute top-0 end-0 mt-2 me-2 toggle-password"
                                    data-target="new_password_confirmation">
                                    <span class="material-symbols-outlined visibility-icon">visibility_off</span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="mt-3 text-end">
                        <button type="submit" class="btn btn-primary">Update Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <!-- Include Material Symbols if not already -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />

    <script>
        document.querySelectorAll('.toggle-password').forEach(button => {
            button.addEventListener('click', function() {
                const targetId = this.dataset.target;
                const input = document.getElementById(targetId);
                const icon = this.querySelector('.visibility-icon');
                if (input.type === 'password') {
                    input.type = 'text';
                    icon.textContent = 'visibility';
                } else {
                    input.type = 'password';
                    icon.textContent = 'visibility_off';
                }
            });
        });
    </script>
@endsection
