@extends('admin.layout.master')

@section('content')
    <div class="page-title">
        <div class="d-flex justify-content-between align-items-end">
            <h1 class="title">Permission Create</h1>
        </div>
    </div>

    <div class="page-content">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('permission.store') }}" method="POST">
                    @csrf
                    <div class="row row-cols-4 g-3">
                        <div>
                            <label for="role_name">Permission Name</label>
                            <input value="{{ old('name') }}" id="role_name" name="name"
                                class="form-control @error('name') is-invalid @enderror" type="text"
                                placeholder="Permission Name">
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>                        
                    </div>
                    <div class="mt-3 text-end">
                        <button class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
