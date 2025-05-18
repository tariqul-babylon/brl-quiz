@extends('admin.layout.master')

@section('content')
    <div class="card p-4">
        <h4>Edit Question</h4>

        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Whoops!</strong> Please fix the following errors:
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('exam_questions.update', [$exam->id, $question->id]) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="title" class="form-label">Question Title</label>
                <input type="text" id="title" name="title" class="form-control" required value="{{ old('title', $question->title) }}">
            </div>

            @php use App\Models\ExamQuestion; @endphp
            <div class="mb-3">
                <label for="question_type" class="form-label">Question Type</label>
                <select name="question_type" id="question_type" class="form-select" required>
                    <option value="">Select Question Type</option>
                    @foreach (ExamQuestion::QUESTION_TYPE as $key => $label)
                        <option value="{{ $key }}" {{ old('question_type', $question->question_type) == $key ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- MCQ Options -->
            <div id="mcq-options" class="mb-3" style="display: none;">
                <label class="form-label">Options</label>
                <div id="mcq-options-wrapper">
                    <!-- We'll inject options here via JS -->
                </div>
                <div class="text-center">
                    <a href="#" id="add-mcq-option" class="mt-2 d-block text-decoration-none">Add More Option</a>
                </div>
            </div>

            <!-- True / False or Yes / No Options -->
            <div id="binary-options" class="mb-3" style="display: none;">
                <label class="form-label">Options</label>
                <div id="binary-options-wrapper">
                    <!-- JS will inject true/false or yes/no -->
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Update Question</button>
            <a href="{{ route('exam_questions.index', $exam->id) }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>

    <script>
        const questionType = document.getElementById('question_type');
        const mcqWrapper = document.getElementById('mcq-options');
        const binaryWrapper = document.getElementById('binary-options');
        const mcqOptionsWrapper = document.getElementById('mcq-options-wrapper');
        const binaryOptionsWrapper = document.getElementById('binary-options-wrapper');
        const addMcqBtn = document.getElementById('add-mcq-option');

        let mcqCount = 0;

        // The existing question's options from backend
        const existingOptions = @json($question->options);

        // Find which option is correct
        const correctOptionIndex = existingOptions.findIndex(o => o.is_correct);

        const createMcqOption = (value = '', isChecked = false) => {
            const wrapper = document.createElement('div');
            wrapper.classList.add('input-group', 'mt-2', 'mcq-option');
            wrapper.innerHTML = `
            <div class="input-group-text">
                <input type="radio" name="correct_option" value="${mcqCount}" required data-type="mcq" ${isChecked ? 'checked' : ''}>
            </div>
            <input type="text" name="options[]" class="form-control" placeholder="Option ${mcqCount + 1}" required value="${value}" data-type="mcq">
            <span class="input-group-text text-danger remove-option material-symbols-outlined" role="button">close</span>
        `;
            mcqOptionsWrapper.appendChild(wrapper);
            mcqCount++;
        };

        const loadInitialMcqs = () => {
            mcqOptionsWrapper.innerHTML = '';
            mcqCount = 0;
            existingOptions.forEach((option, index) => {
                createMcqOption(option.title, index === correctOptionIndex);
            });
        };

        const toggleInputsByType = (type) => {
            const allInputs = document.querySelectorAll('[data-type]');
            allInputs.forEach(input => {
                input.disabled = (type === '1' && input.dataset.type === 'binary') ||
                    (type !== '1' && input.dataset.type === 'mcq');
            });
        };

        const setBinaryOptions = (type) => {
            binaryOptionsWrapper.innerHTML = '';
            let values = type === '2' ? ['True', 'False'] : ['Yes', 'No'];
            // Overwrite values with existing options if available
            if (existingOptions.length && (type === '2' || type === '3')) {
                values = existingOptions.map(o => o.title);
            }
            values.forEach((val, idx) => {
                const isChecked = idx === correctOptionIndex ? 'checked' : '';
                binaryOptionsWrapper.innerHTML += `
                <div class="input-group mt-2">
                    <div class="input-group-text">
                        <input type="radio" name="correct_option" value="${idx}" required data-type="binary" ${isChecked}>
                    </div>
                    <input type="text" name="options[]" class="form-control" required value="${val}" data-type="binary">
                </div>
            `;
            });
        };

        questionType.addEventListener('change', function () {
            const value = this.value;

            mcqOptionsWrapper.innerHTML = '';
            binaryOptionsWrapper.innerHTML = '';

            if (value === '1') {
                mcqWrapper.style.display = 'block';
                binaryWrapper.style.display = 'none';
                loadInitialMcqs();
            } else if (value === '2' || value === '3') {
                mcqWrapper.style.display = 'none';
                binaryWrapper.style.display = 'block';
                setBinaryOptions(value);
            } else {
                mcqWrapper.style.display = 'none';
                binaryWrapper.style.display = 'none';
            }
        });

        addMcqBtn.addEventListener('click', function (e) {
            e.preventDefault();
            createMcqOption();
        });

        // Remove option event delegation
        mcqOptionsWrapper.addEventListener('click', function (e) {
            if (e.target.classList.contains('remove-option')) {
                e.target.closest('.mcq-option').remove();
            }
        });

        // On page load trigger the correct question type UI
        window.addEventListener('DOMContentLoaded', function () {
            questionType.dispatchEvent(new Event('change'));
        });
    </script>
@endsection
