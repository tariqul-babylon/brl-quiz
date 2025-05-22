@extends('front.layouts.app')

@push('css')
    <style>
        .container {
            max-width: 800px;
            margin: 0 auto;
        }

        .form-card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 24px;
        }

        .form-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 24px;
            padding-bottom: 16px;
            border-bottom: 1px solid #f1f3f4;
        }

        .form-header .material-symbols-outlined {
            color: var(--primary);
            font-size: 2rem;
        }

        .form-title {
            font-size: 1.5rem;
            color: var(--dark);
            font-weight: 500;
        }

        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 5px;
            margin-top: 8px;
        }

        .checkbox-group input {
            width: auto;
            padding: 0;
        }

        .form-control:focus {
            box-shadow: none;
        }
    </style>
@endpush

@section('content')
    <div class="container mt-4">
        <div class="form-card">
            <div class="form-header">
                <span class="material-symbols-outlined text-primary">quiz</span>
                <h1 class="form-title">Create New Exam</h1>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('exams.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row g-3 py-3">
                    <div class="col-12">
                        <label for="title">Exam Title</label>
                        <input type="text" name="title" class="form-control" value="{{ old('title') }}">
                    </div>

                    <div class="col-12">
                        <label for="tagline">Tagline/Description</label>
                        <input type="text" name="tagline" class="form-control" value="{{ old('tagline') }}">
                    </div>

                    <div class="col-md-6">
                        <label>Mark per Question</label>
                        <input type="number" name="mark_per_question" class="form-control" min="0" step="0.5" value="{{ old('mark_per_question') }}">
                    </div>

                    <div class="col-md-6">
                        <label>Negative Mark per Wrong Answer</label>
                        <input type="number" name="negative_mark" class="form-control" step="0.25" min="0" value="{{ old('negative_mark', 0) }}">
                    </div>

                    <div class="col-md-6">
                        <label>Duration</label>
                        <div class="input-group">
                            <input type="number" name="duration_hours" class="form-control" step="1" min="0" max="23" value="{{ old('duration_hours') }}">
                            <span class="input-group-text">Hours</span>
                            <input type="number" name="duration_minutes" class="form-control" step="1" min="0" max="59" value="{{ old('duration_minutes') }}">
                            <span class="input-group-text">Minutes</span>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label>Collect Student ID (Optional)</label>
                        <input type="text" name="id_no_placeholder" class="form-control" placeholder="e.g. ID No or Reg. No" value="{{ old('id_no_placeholder') }}">
                    </div>

                    <div class="col-12">
                        <b>Exam Settings</b>
                        <div class="checkbox-group">
                            <input type="checkbox" class="me-1" name="is_question_random" id="is_question_random" {{ old('is_question_random') ? 'checked' : '' }}>
                            <label for="is_question_random">Randomize Questions</label>
                        </div>
                        <div class="checkbox-group">
                            <input type="checkbox" class="me-1" name="is_option_random" id="is_option_random" {{ old('is_option_random') ? 'checked' : '' }}>
                            <label for="is_option_random">Randomize Options</label>
                        </div>
                        <div class="checkbox-group">
                            <input type="checkbox" class="me-1" name="is_sign_in_required" id="is_sign_in_required" {{ old('is_sign_in_required') ? 'checked' : '' }}>
                            <label for="is_sign_in_required">Require Student Login</label>
                        </div>
                        <div class="checkbox-group">
                            <input type="checkbox" class="me-1" name="user_result_view" id="user_result_view" {{ old('user_result_view') ? 'checked' : '' }}>
                            <label for="user_result_view">Show Results to Students</label>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between border-top pt-3">
                    <a href="{{ route('exams.index') }}" class="btn btn-outline-secondary d-none d-md-block">Back to Exam List</a>
                    <button type="submit" class="btn btn-primary">Create Exam</button>
                </div>
            </form>
        </div>
    </div>
@endsection
