@extends('admin.layout.master')

@section('content')
<div class="container">
    <h2>Change Password</h2>

    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('password.update') }}">
        @csrf

        <div>
            <label>Current Password</label>
            <input type="password" name="current_password" required>
            @error('current_password') <div>{{ $message }}</div> @enderror
        </div>

        <div>
            <label>New Password</label>
            <input type="password" name="new_password" required>
            @error('new_password') <div>{{ $message }}</div> @enderror
        </div>

        <div>
            <label>Confirm New Password</label>
            <input type="password" name="new_password_confirmation" required>
        </div>

        <button type="submit">Update Password</button>
    </form>
</div>
@endsection
