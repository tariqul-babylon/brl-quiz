@extends('admin.layout.master')

@section('content')
    <div class="page-title">
        <div class="d-flex justify-content-between align-items-end">
            <h1 class="title">Edit Exam</h1>
        </div>
    </div>

    <div class="page-content">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('exams.update', $exam->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row row-cols-3 g-3">
                        <div>
                            <label>Title</label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $exam->title) }}">
                            @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <label>Tagline</label>
                            <input type="text" name="tagline" class="form-control @error('tagline') is-invalid @enderror" value="{{ old('tagline', $exam->tagline) }}">
                            @error('tagline')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <label>Start Date & Time</label>
                            <input type="text" id="exam_start_time" name="exam_start_time"
                                   class="form-control @error('exam_start_time') is-invalid @enderror"
                                   value="{{ old('exam_start_time', \Carbon\Carbon::parse($exam->exam_start_time)->format('Y-m-d H:i')) }}">
                            @error('exam_start_time')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <label>End Date & Time</label>
                            <input type="text" id="exam_end_time" name="exam_end_time"
                                   class="form-control @error('exam_end_time') is-invalid @enderror"
                                   value="{{ old('exam_end_time', \Carbon\Carbon::parse($exam->exam_end_time)->format('Y-m-d H:i')) }}">
                            @error('exam_end_time')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <label>Full Mark</label>
                            <input type="number" name="full_mark" class="form-control @error('full_mark') is-invalid @enderror" value="{{ old('full_mark', $exam->full_mark) }}">
                            @error('full_mark')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mt-3">
                            <label>Negative Mark per Wrong Question</label>
                            <input type="number" name="negative_mark" class="form-control" step="0.01" value="{{ old('negative_mark', $exam->negative_mark) }}">
                            @error('negative_mark')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <label>Duration</label>
                            <div class="input-group">
                                <input type="number" name="duration_hours" class="form-control @error('duration_hours') is-invalid @enderror" placeholder="Hours" min="0" value="{{ old('duration_hours', \Carbon\Carbon::createFromFormat('H:i:s', $exam->duration)->format('H')) }}">
                                <span class="input-group-text">hr</span>
                                <input type="number" name="duration_minutes" class="form-control @error('duration_minutes') is-invalid @enderror" placeholder="Minutes" min="0" max="59" value="{{ old('duration_minutes', \Carbon\Carbon::createFromFormat('H:i:s', $exam->duration)->format('i')) }}">
                                <span class="input-group-text">min</span>
                            </div>

                            @error('duration_hours')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            @error('duration_minutes')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <label>ID No Placeholder</label>
                            <input type="text" name="id_no_placeholder" class="form-control @error('id_no_placeholder') is-invalid @enderror" value="{{ old('id_no_placeholder', $exam->id_no_placeholder) }}">
                            @error('id_no_placeholder')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <label>Logo</label>
                            <input type="file" name="logo" id="logoInput" class="form-control @error('logo') is-invalid @enderror" accept="image/*">

                            <div class="mt-1">
                                <img id="logoPreview"
                                     src="{{ $exam->logo ? asset('storage/' . $exam->logo) : '#' }}"
                                     alt="Logo"
                                     style="height: 50px; {{ $exam->logo ? '' : 'display: none;' }}">
                            </div>

                            @error('logo')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <label>Exam Link</label>
                            <input type="text" name="exam_link" class="form-control @error('exam_link') is-invalid @enderror" value="{{ old('exam_link', $exam->exam_link) }}">
                            @error('exam_link')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-3">
                        <label>Instruction</label>
                        <textarea name="instruction" class="form-control @error('instruction') is-invalid @enderror" rows="3">{{ old('instruction', $exam->instruction) }}</textarea>
                        @error('instruction')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row row-cols-3 g-3 mt-3">
                        @foreach([
                            'is_bluer', 'is_timer', 'is_date_enabled',
                            'exam_status', 'user_result_view', 'user_answer_view',
                            'is_question_random', 'is_option_random',
                            'is_sign_in_required', 'is_specific_student'
                        ] as $boolean)
                            <div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="{{ $boolean }}" id="{{ $boolean }}" {{ old($boolean, $exam->$boolean) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="{{ $boolean }}">{{ ucwords(str_replace('_', ' ', $boolean)) }}</label>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-4 text-end">
                        <button class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')

    <script>
        $(document).ready(function () {
            $('#logoInput').on('change', function (e) {
                const file = e.target.files[0];
                if (file && file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        $('#logoPreview').attr('src', e.target.result).show();
                    };
                    reader.readAsDataURL(file);
                } else {
                    $('#logoPreview').hide();
                }
            });
        });
    </script>

    <script>
        flatpickr("#exam_start_time", {
            enableTime: true,
            dateFormat: "Y-m-d H:i",
            minDate: "today",
            onChange: function(selectedDates, dateStr, instance) {
                if (selectedDates.length > 0) {
                    endPicker.set('minDate', selectedDates[0]);
                }
            }
        });

        const endPicker = flatpickr("#exam_end_time", {
            enableTime: true,
            dateFormat: "Y-m-d H:i",
            minDate: "{{ \Carbon\Carbon::parse($exam->exam_start_time)->format('Y-m-d H:i') }}"
        });
    </script>
@endpush

