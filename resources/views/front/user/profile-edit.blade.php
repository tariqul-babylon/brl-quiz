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
                        <div class="row">
                            {{-- Name --}}
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" name="name" id="name" class="form-control"
                                        value="{{ old('name', $user->name) }}">
                                    @error('name')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            {{-- Email --}}
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" name="email" id="email" class="form-control"
                                        value="{{ old('email', $user->email) }}">
                                    @error('email')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            {{-- Contact --}}
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="contact" class="form-label">Contact</label>
                                    <input type="text" name="contact" id="contact" class="form-control"
                                        value="{{ old('contact', $user->contact) }}">
                                    @error('contact')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            {{-- Profile Photo --}}
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="photo" class="form-label">Profile Photo</label>
                                    <input type="file" name="photo" id="photo" class="form-control">
                                    @error('photo')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            {{-- Org Logo --}}
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="org_logo" class="form-label">Organization Logo</label>
                                    <input type="file" name="org_logo" id="org_logo" class="form-control">
                                    @if ($user->org_logo)
                                        <div class="mt-2">
                                            <img src="{{ asset('storage/' . $user->org_logo) }}" alt="Organization Logo"
                                                width="80" height="80"
                                                class="rounded border shadow-sm object-fit-contain">
                                        </div>
                                    @endif
                                    @error('org_logo')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>


                        <div class="text-end">
                            <button class="btn btn-primary">Update Profile</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
