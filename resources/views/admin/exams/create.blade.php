@extends('admin.layout.master')

@section('content')
    <div class="page-title">
        <div class="d-flex justify-content-between align-items-end">
            <h1 class="title">Create Exam</h1>
        </div>
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

    <div class="page-content">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('exams.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row row-cols-3 g-3">
                        <div>
                            <label>Title</label>
                            <input type="text" name="title" class="form-control" value="{{ old('title') }}">
                        </div>
                        <div>
                            <label>Tagline</label>
                            <input type="text" name="tagline" class="form-control" value="{{ old('tagline') }}">
                        </div>

                        <div>
                            <label>Start Date & Time</label>
                            <input type="text" id="exam_start_time" name="exam_start_time"
                                class="form-control @error('exam_start_time') is-invalid @enderror"
                                value="{{ old('exam_start_time') }}">
                            @error('exam_start_time')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <label>End Date & Time</label>
                            <input type="text" id="exam_end_time" name="exam_end_time"
                                class="form-control @error('exam_end_time') is-invalid @enderror"
                                value="{{ old('exam_end_time') }}">
                            @error('exam_end_time')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <label>Full Mark</label>
                            <input type="number" name="full_mark" class="form-control" value="{{ old('full_mark') }}">
                        </div>

                        <div class="mt-3">
                            <label>Negative Mark per Wrong Question</label>
                            <input type="number" name="negative_mark" class="form-control" step="0.01"
                                value="{{ old('negative_mark') }}">
                        </div>

                        <div>
                            <label>Duration</label>
                            <div class="input-group">
                                <input type="number" name="duration_hours" class="form-control" min="0"
                                    max="23" value="{{ old('duration_hours') }}">
                                <span class="input-group-text">Hour</span>
                                <input type="number" name="duration_minutes" class="form-control" min="0"
                                    max="59" value="{{ old('duration_minutes') }}">
                                <span class="input-group-text">Minute</span>
                            </div>
                        </div>

                        <div>
                            <label>ID No Placeholder</label>
                            <input type="text" name="id_no_placeholder" class="form-control"
                                value="{{ old('id_no_placeholder') }}">
                        </div>

                        <div>
                            <label>Logo</label>
                            <input type="file" name="logo" id="logoInput" class="form-control">
                            <img id="previewImage" src="#" alt="Preview"
                                style="display: none; max-height: 100px; margin-top: 10px;">
                        </div>
                    </div>

                    <div class="mt-3">
                        <label>Instruction</label>
                        <div id="quill-editor" style="height: 200px;">{!! old('instruction') !!}</div>
                        <input type="hidden" name="instruction" id="instruction">
                    </div>


                    <div class="row row-cols-3 g-3 mt-3">
                        @foreach (['is_bluer', 'is_timer', 'is_date_enabled', 'exam_status', 'user_result_view', 'user_answer_view', 'is_question_random', 'is_option_random', 'is_sign_in_required', 'is_specific_student'] as $boolean)
                            <div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="{{ $boolean }}"
                                        id="{{ $boolean }}" {{ old($boolean) ? 'checked' : '' }}>
                                    <label class="form-check-label"
                                        for="{{ $boolean }}">{{ ucwords(str_replace('_', ' ', $boolean)) }}</label>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-4 text-end">
                        <button class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            const quill = new Quill('#quill-editor', {
                theme: 'snow',
                modules: {
                    toolbar: [
                        [{
                            'header': '1'
                        }, {
                            'header': '2'
                        }],
                        [{
                            'font': []
                        }],
                        [{
                            'size': ['small', 'medium', 'large', 'huge'] // Custom size options
                        }],
                        [{
                            'list': 'ordered'
                        }, {
                            'list': 'bullet'
                        }],
                        [{
                            'align': []
                        }],
                        ['bold', 'italic', 'underline'],
                        ['link'],
                        [{
                            'color': []
                        }, {
                            'background': []
                        }],
                        ['blockquote', 'code-block']
                    ]
                }
            });

            // Set old value if available
            const oldValue = $('#instruction').val();
            quill.root.innerHTML = oldValue;

            // Update hidden input on text change
            quill.on('text-change', function() {
                $('#instruction').val(quill.root.innerHTML);
            });

            $('#logoInput').on('change', function(event) {
                let input = event.target;
                if (input.files && input.files[0]) {
                    let reader = new FileReader();
                    reader.onload = function(e) {
                        $('#previewImage').attr('src', e.target.result).show();
                    };
                    reader.readAsDataURL(input.files[0]);
                }
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let now = new Date();

            const startPicker = flatpickr("#exam_start_time", {
                enableTime: true,
                dateFormat: "Y-m-d H:i",
                minDate: now,
                onChange: function(selectedDates, dateStr, instance) {
                    if (selectedDates.length) {
                        endPicker.set('minDate', selectedDates[0]);
                    }
                }
            });

            const endPicker = flatpickr("#exam_end_time", {
                enableTime: true,
                dateFormat: "Y-m-d H:i",
                minDate: now
            });
        });
    </script>
@endsection
