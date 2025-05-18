@extends('admin.layout.master')
@section('content')
    <div class="page-title">
        <div class="d-flex justify-content-between align-items-end">
            <h1 class="title">Exams Category List</h1>
            <a href="{{ route('exam-categories.create') }}" class="btn btn-primary">
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
                <div class="row justify-content-end my-2">
                    <div class="col-9 d-none">
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
                            <th>No</th>
                            <th>Name</th>
                            <th>Parent</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($examCategories as $key => $examCategory)
                            <tr>
                                <td>
                                    {{ $examCategories->firstItem() + $loop->index }}
                                </td>
                                <td>
                                    {{ $examCategory->name }}
                                </td>

                                <td>
                                    {{ $examCategory->parent->name ?? 'N/A' }}
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
                                            <li><a class="dropdown-item" href="#">
                                                    <span class="material-symbols-outlined">
                                                        visibility
                                                    </span>
                                                    View
                                                </a></li>
                                            <li><a class="dropdown-item" href="{{ route('exam-categories.edit', $examCategory->id) }}">
                                                    <span class="material-symbols-outlined">
                                                        edit
                                                    </span>
                                                    Edit action
                                                </a></li>
                                            <li>
                                                <form action="{{ route('exam-categories.destroy', $examCategory->id) }}" method="POST"
                                                      onsubmit="return confirm('Are you sure you want to delete this category?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item text-danger" style="border: none; background: none;">
                                                        <span class="material-symbols-outlined">delete</span>
                                                        Delete
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

            {{-- <ul class="pagination">
                <li class="page-item disabled">
                    <span class="page-link">Previous</span>
                </li>
                <li class="page-item">
                    <a class="page-link" href="#">1</a>
                </li>
                <li class="page-item active">
                    <span class="page-link">2</span>
                </li>
                <li class="page-item">
                    <a class="page-link" href="#">3</a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="#">Next</a>
                </li>
            </ul> --}}
            {!! $examCategories->links() !!}
        </div>

    </div>
@endsection
