@extends('admin.layout.master')

@section('content')
    <div class="page-title mb-3">
        <div class="d-flex  justify-content-between align-items-center">
            <h1 class="title">Update Permission </h1>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('permission.update', $permission->id) }}" method="POST">
                @method('PUT')
                @csrf
                <div class="row">
                    <div class="col-lg-6">
                        <div class="mb-2">
                            <label for="role_name">Permission Name</label>
                            <input value="{{ $permission->name }}" id="role_name" name="name"
                                class="form-control @error('name') is-invalid @enderror" type="text"
                                placeholder="Permission Name">
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
                <div>
                    <button class="btn btn-primary">Submit</button>
                </div>
            </form>

        </div>
    </div>
@endsection
