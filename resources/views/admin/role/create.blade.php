@extends('admin.layout.master')

@section('content')
    <div class="page-title mb-3">
        <div class="d-flex  justify-content-between align-items-center">
            <h1 class="title">Add New Role</h1>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('role.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-lg-6">
                        <div class="mb-2">
                            <label for="role_name">Permission Name</label>
                            <input value="{{ old('name') }}" id="role_name" name="name"
                                class="form-control @error('name') is-invalid @enderror" type="text"
                                placeholder="Permission Name">
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4">
                    <label for="role_name"><b>Permission List</b></label>
                    <hr class="w-100">
                    @foreach ($permissions as $k => $permission)
                        <div class="@if (in_array($permission->name, config('app.permissions'))) d-none @endif">
                            <div class="mb-2 ">
                                <input type="checkbox" class="form-check-input" name="permission[]"
                                    value="{{ $permission->id }}" id="{{ $permission->id }}">
                                <label for="{{ $permission->id }}" class="optional">
                                    {{ ucwords(str_replace('-', ' ', $permission->name)) }}
                                </label>
                            </div>
                        </div>
                    @endforeach

                </div>
                <div class="mb-5">
                    @error('permission')
                        <small class="text-danger">Minimum One Permission Field Required</small>
                    @enderror
                </div>

                <div>
                    <button class="btn btn-primary">Submit</button>
                </div>
            </form>

        </div>
    </div>
@endsection
