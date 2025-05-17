@extends('admin.layout.master')
@section('content')
    <div class="page-title">
        <div class="d-flex justify-content-between align-items-end">
            <h1 class="title">Users List</h1>
            <a href="" class="btn btn-primary">
                <span class="material-symbols-outlined">
                    add
                </span>
                New
            </a>
        </div>
    </div>

    <div class="page-content">
        <div>
            <div>
                <div class="row justify-content-between">
                    <div class="col-9">
                        <div class="row row-cols-4 g-2 mb-3">
                            <div class="">
                                <select name="" class="form-select form-select-sm" id="">
                                    <option value="">Select Type</option>
                                    <option value="">Select</option>
                                    <option value="">Select</option>
                                    <option value="">Select</option>
                                </select>
                            </div>
                            <div class="">
                                <select name="" class="form-select form-select-sm" id="">
                                    <option value="">Select Type</option>
                                    <option value="">Select</option>
                                    <option value="">Select</option>
                                    <option value="">Select</option>
                                </select>
                            </div>
                            <div class="">
                                <select name="" class="form-select form-select-sm" id="">
                                    <option value="">Select Type</option>
                                    <option value="">Select</option>
                                    <option value="">Select</option>
                                    <option value="">Select</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <input type="text" placeholder="Search" class="form-control form-select-sm">
                    </div>
                </div>

            </div>

            <div class="table-responsiv bg-white">
                <table class="table  table-bordered">
                    <thead class="">
                        <tr>
                            <th class="text-center">No</th>
                            <th>Name</th>
                            <th class="">Username</th>
                            <th class="">Email</th>
                            <th class="">Roles</th>
                            <th class="">Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $key => $user)
                            <tr>
                                <td>
                                    {{  $loop->index }}
                                </td>
                                <td>
                                    {{ $user->name }}
                                </td>
                                <td>{{ $user->username }}</td>
                                <td>{{ $user->email }}</td>
                                <td>

                                </td>
                                <td>
                                    <span class="badge bg-success">Active</span>
                                </td>
                                <td class="text-end">
                                    <div class="dropdown action">
                                        <button class="btn" type="button" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                            Action <span class="material-symbols-outlined">
                                                expand_more
                                            </span>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="{{ route('users.show', $user->id) }}">
                                                    <span class="material-symbols-outlined">
                                                        visibility
                                                    </span>
                                                    View
                                                </a></li>
                                            <li><a class="dropdown-item" href="{{ route('users.edit', $user->id) }}">
                                                    <span class="material-symbols-outlined">
                                                        edit
                                                    </span>
                                                    Edit action
                                                </a></li>
                                            <li><a class="dropdown-item" href="#">
                                                    <span class="material-symbols-outlined">
                                                        delete
                                                    </span>
                                                    Delete
                                                </a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {!! $users->links() !!}
        </div>

    </div>
@endsection
