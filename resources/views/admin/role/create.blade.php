@extends('admin.layout.master')

@section('content')
    <div class="page-header">
        <div class="head">
            <h1 class="title">Create Permission</h1>
        </div>
    </div>
    <form action="{{ route('role.store') }}" method="POST">
        @csrf
        <div class="row row-cols-3 gx-3 gy-3">
            <div>
                <label for="role_name">Permission Name</label>
                <input value="{{ old('name') }}" id="role_name" name="name"
                    class="form-control @error('name') is-invalid @enderror" type="text" placeholder="Permission Name">
                @error('name')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>
        <div class="row row-cols-5 g-2 mt-3">
            @foreach ($permissions as $k => $permission)
                <div>
                    <input type="checkbox" class="form-check-input me-1" name="permission[]" value="{{ $permission->id }}"
                        id="{{ $permission->id }}">
                    <label for="{{ $permission->id }}" class="user-select-none">
                        {{ ucwords(str_replace('-', ' ', $permission->name)) }}
                    </label>
                </div>
            @endforeach
        </div>

        <div class="mt-4">
            <a href="" class="btn btn-outline-secondary">
                Back
            </a>
            <button class="btn btn-primary">Submit</button>
        </div>
    </form>
@endsection
