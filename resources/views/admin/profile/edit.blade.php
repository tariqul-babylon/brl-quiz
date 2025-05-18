@extends('admin.layout.master')

@section('content')
    <div class="page-title">
        <div class="d-flex justify-content-between align-items-end">
            <h1 class="title">Update Profile</h1>
        </div>
    </div>

    <div class="page-content">
        <div class="card">
            <div class="card-body">
                @if (session('status'))
                    <div class="alert alert-success">{{ session('status') }}</div>
                @endif
                <div class="text-center mb-3">
                    @if ($user->photo)
                        <img src="{{ asset('storage/' . $user->photo) }}" alt="{{ $user->name }}'s profile photo"
                            class="rounded-circle shadow mt-2" width="100" height="100" style="object-fit: cover;"
                            loading="lazy">
                    @else
                        <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center mt-2"
                            style="width: 100px; height: 100px; background-color:'#6c757d';">
                            <span class="text-white fw-bold" style="font-size: 2rem;">
                                {{ substr($user->name, 0, 1) }}
                            </span>
                        </div>
                    @endif
                </div>
                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="row row-cols-1 row-cols-md-2 g-3">
                        <div>
                            <label for="name" class="form-label">Name</label>
                            <input value="{{ old('name', $user->name) }}" type="text" name="name"
                                class="form-control @error('name') is-invalid @enderror">
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div>
                            <label for="email" class="form-label">Email</label>
                            <input value="{{ old('email', $user->email) }}" type="email" name="email"
                                class="form-control @error('email') is-invalid @enderror">
                            @error('email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div>
                            <label for="contact" class="form-label">Contact</label>
                            <input value="{{ old('contact', $user->contact) }}" type="text" name="contact"
                                class="form-control @error('contact') is-invalid @enderror">
                            @error('contact')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div>
                            <label for="photo" class="form-label">Profile Photo</label>
                            <input type="file" name="photo" class="form-control @error('photo') is-invalid @enderror">
                            @error('photo')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div>
                            <label for="org_logo" class="form-label">Organization Logo</label>
                            <input type="file" name="org_logo"
                                class="form-control @error('org_logo') is-invalid @enderror">
                            @if ($user->org_logo)
                                <img src="{{ asset('storage/' . $user->org_logo) }}" alt="Org Logo" width="80"
                                    class="mt-2">
                            @endif
                            @error('org_logo')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-3 text-end">
                        <button class="btn btn-primary" type="submit">Update Profile</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
