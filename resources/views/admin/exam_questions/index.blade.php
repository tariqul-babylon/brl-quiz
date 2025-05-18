@extends('admin.layout.master')

@section('content')
    <div class="container">
        <h2>Manage Questions for Exam: {{ $exam->title }}</h2>

        <div class="row">
            <!-- Left column: Question List -->
            <div class="col-md-6">
                <h4>Questions List</h4>
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Type</th>
                        <th>Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($questions as $question)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $question->title }}</td>
                            <td>{{ $question->question_type ? 'Type A' : 'Type B' }}</td>
                            <td>{{ $question->status ? 'Active' : 'Inactive' }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-center">No questions added yet.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Right column: Add Question Form -->
            <div class="col-md-6">
                <h4>Add New Question</h4>
                <form action="{{ route('exam_questions.store', $exam->id) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="title" class="form-label">Question Title</label>
                        <input type="text" id="title" name="title" class="form-control" required value="{{ old('title') }}">
                    </div>

                    <div class="mb-3">
                        <label for="question_type" class="form-label">Question Type</label>
                        <select name="question_type" id="question_type" class="form-control" required>
                            <option value="1" {{ old('question_type') == '1' ? 'selected' : '' }}>Type A</option>
                            <option value="0" {{ old('question_type') == '0' ? 'selected' : '' }}>Type B</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" id="status" class="form-control" required>
                            <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Add Question</button>
                </form>
            </div>
        </div>
    </div>
@endsection
