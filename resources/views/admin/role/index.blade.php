@extends('admin.layout.master')

@section('content')
    <div class="">
        <div class="page-title mb-3">
            <div class="d-flex  justify-content-between align-items-center">
                <h1 class="title">User Roles</h1>
                <a class="btn btn-primary" href="{{ route('role.create') }}">
                    New
                </a>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                @include('component.alert')
                {{-- <div class="d-flex mb-3 justify-content-end align-items-end">
                    <div>
                        <input type="text" class="form-control rounded-pill" placeholder="Search ....">
                    </div>
                </div> --}}

                <div class="table-responsiv bg-white">
                    <table class="table  table-bordered">
                        <thead class="">
                            <tr>
                                <th class="text-center">No</th>
                                <th>Name</th>
                                <th width="120" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($roles as $key => $role)
                                <tr>
                                    <td class="text-center">
                                        {{ ($roles->currentPage() - 1) * $roles->perPage() + $loop->iteration }}
                                    </td>
                                    <td>
                                        {{ $role->name }}
                                    </td>

                                    <td class="text-center">
                                        <div class="dropdown action">
                                            <button class="btn" type="button" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                Action
                                                <span class="material-symbols-outlined">
                                                    expand_more
                                                </span>
                                            </button>
                                            <ul class="dropdown-menu">
                                                
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('role.show', $role->id) }}">
                                                            <i class="far fa-eye"></i>
                                                            View
                                                        </a>
                                                    </li>
                                                

                                                
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('role.edit', $role->id) }}">
                                                            <i class="far fa-edit"></i>
                                                            Edit
                                                        </a>
                                                    </li>
                                               

                                                
                                                    <li>
                                                        <form action="{{ route('role.destroy', $role->id) }}" method="post">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="delete-btn dropdown-item">
                                                                <i class="far fa-trash-alt"></i> Delete
                                                            </button>
                                                        </form>
                                                    </li>
                                                
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {!! $roles->links() !!}
            </div>
        </div>
    </div>
@endsection
