@extends('admin.layout.master')

@section('content')
    <div class="page-header">
        <div class="head">
            <h1 class="title">Create Permission</h1>
        </div>
    </div>

    <div class="row row-cols-3 gx-3 gy-3">

        <div>
            <label for="">Permission Name</label>
            <input type="text" class="form-control">
        </div>
    </div>
    <div class="row row-cols-5 g-2 mt-3">
        <div>
            <input type="checkbox" class="form-check-input me-1" id="permission1">
            <label for="permission1" class="user-select-none">Create User</label>
        </div>
        <div>
            <input type="checkbox" class="form-check-input me-1" id="permission2">
            <label for="permission2" class="user-select-none">Edit User</label>
        </div>
        <div>
            <input type="checkbox" class="form-check-input me-1" id="permission3">
            <label for="permission3" class="user-select-none">Delete User</label>
        </div>
        <div>
            <input type="checkbox" class="form-check-input me-1" id="permission4">
            <label for="permission4" class="user-select-none">View User</label>
        </div>
        <div>
            <input type="checkbox" class="form-check-input me-1" id="permission5">
            <label for="permission5" class="user-select-none">Create Role</label>
        </div>
        <div>
            <input type="checkbox" class="form-check-input me-1" id="permission6">
            <label for="permission6" class="user-select-none">Edit Role</label>
        </div>
        <div>
            <input type="checkbox" class="form-check-input me-1" id="permission7">
            <label for="permission7" class="user-select-none">Delete Role</label>
        </div>
        <div>
            <input type="checkbox" class="form-check-input me-1" id="permission8">
            <label for="permission8" class="user-select-none">View Role</label>
        </div>
        <div>
            <input type="checkbox" class="form-check-input me-1" id="permission9">
            <label for="permission9" class="user-select-none">Manage Permissions</label>
        </div>
        <div>
            <input type="checkbox" class="form-check-input me-1" id="permission10">
            <label for="permission10" class="user-select-none">Create Post</label>
        </div>
        <div>
            <input type="checkbox" class="form-check-input me-1" id="permission11">
            <label for="permission11" class="user-select-none">Edit Post</label>
        </div>
        <div>
            <input type="checkbox" class="form-check-input me-1" id="permission12">
            <label for="permission12" class="user-select-none">Delete Post</label>
        </div>
        <div>
            <input type="checkbox" class="form-check-input me-1" id="permission13">
            <label for="permission13" class="user-select-none">View Post</label>
        </div>
        <div>
            <input type="checkbox" class="form-check-input me-1" id="permission14">
            <label for="permission14" class="user-select-none">Publish Post</label>
        </div>
        <div>
            <input type="checkbox" class="form-check-input me-1" id="permission15">
            <label for="permission15" class="user-select-none">Unpublish Post</label>
        </div>
        <div>
            <input type="checkbox" class="form-check-input me-1" id="permission16">
            <label for="permission16" class="user-select-none">Manage Settings</label>
        </div>
        <div>
            <input type="checkbox" class="form-check-input me-1" id="permission17">
            <label for="permission17" class="user-select-none">View Dashboard</label>
        </div>
        <div>
            <input type="checkbox" class="form-check-input me-1" id="permission18">
            <label for="permission18" class="user-select-none">Generate Reports</label>
        </div>
        <div>
            <input type="checkbox" class="form-check-input me-1" id="permission19">
            <label for="permission19" class="user-select-none">Access API</label>
        </div>
        <div>
            <input type="checkbox" class="form-check-input me-1" id="permission20">
            <label for="permission20" class="user-select-none">Manage API Keys</label>
        </div>

    </div>

    <div class="mt-4">
        <a href="" class="btn btn-outline-secondary">
            Back
        </a>
        <button class="btn btn-primary">Submit</button>
    </div>
@endsection
