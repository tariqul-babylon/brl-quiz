@extends('admin.layout.master')

@section('content')
    <div class="page-title">
        <div class="d-flex justify-content-between align-items-end">
            <h1 class="title">Edit Exam Category</h1>
        </div>
    </div>

    <div class="page-content">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('exam-categories.update', $examCategory->id) }}" method="POST">
                    @method('PUT')
                    @csrf

                    <div class="row row-cols-2 g-3">
                        <!-- Category Name -->
                        <div>
                            <label for="name">Category Name</label>
                            <input value="{{ old('name', $examCategory->name) }}" id="name" name="name"
                                   class="form-control @error('name') is-invalid @enderror" type="text"
                                   placeholder="Exam Category Name">
                            @error('name')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Parent Category -->
                        <div>
                            <label for="parent_id">Parent Category</label>
                            <select name="parent_id" id="parent_id"
                                    class="form-control @error('parent_id') is-invalid @enderror">
                                <option value="">None</option>
                                @foreach($examCategories as $category)
                                    @if ($category->id !== $examCategory->id)
                                        <option value="{{ $category->id }}"
                                            {{ old('parent_id', $examCategory->parent_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                            @error('parent_id')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-3 text-end">
                        <button class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
