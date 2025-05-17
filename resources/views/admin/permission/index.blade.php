@extends('admin.layout.master')
@section('content')
    <div class="">
        <div class="page-title mb-3">
            <div class="d-flex  justify-content-between align-items-center">
                <h1 class="title">Permission Information</h1>
                @can('Add Permission')
                    <a class="btn btn-primary" href="{{ route('permission.create') }}">
                        New
                    </a>
                @endcan
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                @include('component.alert')

                <div class="table-responsive">
                    <table class="table striped">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th>Name</th>
                                <th width="120" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($permissions as $key => $permission)
                                <tr>
                                    <td class="text-center">
                                        {{ $permissions->firstItem() + $loop->index }}
                                    </td>
                                    <td>
                                        {{ $permission->name }}
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
                                                @can('Edit Permission')
                                                    <li>
                                                        <a class="dropdown-item"
                                                            href="{{ route('permission.edit', $permission->id) }}">
                                                            <i class="far fa-edit"></i>
                                                            Edit
                                                        </a>
                                                    </li>
                                                @endcan

                                                @can('Delete Permission')
                                                    <li>
                                                        <form action="{{ route('permission.destroy', $permission->id) }}"
                                                            method="post">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="delete-btn dropdown-item">
                                                                <i class="far fa-trash-alt"></i> Delete
                                                            </button>
                                                        </form>
                                                    </li>
                                                @endcan
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
                {!! $permissions->links() !!}
            </div>
        </div>
    </div>
@endsection
