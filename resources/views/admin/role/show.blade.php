@extends('admin.layout.master')
@section('content')
    <div class="page-title mb-3">
        <div class="d-flex  justify-content-between align-items-center">
            <h1 class="title">Permission View</h1>
        </div>
        Role: <strong>{{ $role->name }}</strong>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4">
                @foreach ($permissions as $k => $permission)
                    <div class="@if (in_array($permission->name, config('app.permissions'))) d-none @endif">
                        <div class="mb-2">
                            <span class="d-flex align-items-center">
                                @if ($role->hasPermissionTo($permission->name))
                                    <span class="material-symbols-outlined text-success">
                                        check
                                    </span>
                                @else
                                    <span class="material-symbols-outlined text-danger">
                                        close
                                    </span>
                                @endif
                                <span class="ms-2">{{ $permission->name }}</span>
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection


@push('js')
    <script>
        @foreach ($rolePermissions as $key => $permission)
            $("input[value={{ $permission->permission_id }}]").attr('checked', '');
        @endforeach
        $('input[type=checkbox]').click(function() {
            return false;
        });
    </script>
@endpush
