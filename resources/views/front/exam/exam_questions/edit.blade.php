@extends('front.layouts.app')
@section('content')
    <div class="container mt-4 mb-5">
            <h2 class="text-center">Update Question</h2>
            <div class="text-center">
                <span>Exam Title: {{ $exam->title }}</span>
            </div>

        <div class="row mt-3 justify-content-center">
            <!-- Form for Editing Question -->
            <div class="col-md-6">
                <div class="card p-4">
                    <h4 class="text-center">Edit Question</h4>
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

                    <form action="{{ route('front.exam_questions.update', [$exam->id, $question->id]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="title" class="form-label">Question Title</label>
                            <input type="text" id="title" name="title" class="form-control" required value="{{ old('title', $question->title) }}">
                        </div>

                        @php use App\Models\ExamQuestion; @endphp

                        <div class="mb-3">
                            <label for="questionTypeSelect" class="form-label">Question Type</label>
                            <select name="question_type" id="questionTypeSelect" class="form-select" required>
                                <option value="">Select Question Type</option>
                                @foreach (ExamQuestion::QUESTION_TYPE as $key => $label)
                                    <option value="{{ $key }}" {{ old('question_type', $question->question_type) == $key ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- MCQ Options -->
                        <div id="mcqOptionsContainer" class="mb-3" style="{{ $question->question_type == 1 ? 'display: block;' : 'display: none;' }}">
                            <label class="form-label">Options</label>
                            <div id="mcqOptionsWrapper">
                                @foreach ($question->options as $index => $option)
                                    <div class="input-group mt-2 mcq-option">
                                        <div class="input-group-text">
                                            <input type="radio" name="correct_option" value="{{ $index }}" {{ $option->is_correct ? 'checked' : '' }} required data-type="mcq">
                                        </div>
                                        <input type="text" name="options[]" class="form-control" placeholder="Option {{ $index + 1 }}" required value="{{ old('options.' . $index, $option->title) }}" data-type="mcq">
                                        <span class="input-group-text text-danger remove-option material-symbols-outlined" role="button">close</span>
                                    </div>
                                @endforeach
                            </div>
                            <div class="text-center">
                                <a href="#" id="addMcqOptionBtn" class="mt-2 d-block text-decoration-none" style="{{ $question->question_type == 1 ? 'display: block;' : 'display: none;' }}">Add More Option</a>
                            </div>
                        </div>

                        <!-- True/False or Yes/No -->
                        <div id="binaryOptionsContainer" class="mb-3" style="{{ in_array($question->question_type, [2, 3]) ? 'display: block;' : 'display: none;' }}">
                            <label class="form-label">Options</label>
                            <div id="binaryOptionsWrapper">
                                @if (in_array($question->question_type, [2, 3]))
                                    @foreach ($question->options as $index => $option)
                                        <div class="input-group mt-2">
                                            <div class="input-group-text">
                                                <input type="radio" name="correct_option" value="{{ $index }}" {{ $option->is_correct ? 'checked' : '' }} required data-type="binary">
                                            </div>
                                            <input type="text" name="options[]" class="form-control" required value="{{ old('options.' . $index, $option->title) }}" data-type="binary">
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>

                       <div class="d-flex justify-content-between gap-2 mt-4">
                        <a href="{{ route('front.exam_questions.index', $exam->id) }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">Update Question</button>
                       </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        const questionTypeSelect = document.getElementById('questionTypeSelect');
        const mcqOptionsContainer = document.getElementById('mcqOptionsContainer');
        const binaryOptionsContainer = document.getElementById('binaryOptionsContainer');
        const mcqOptionsWrapper = document.getElementById('mcqOptionsWrapper');
        const binaryOptionsWrapper = document.getElementById('binaryOptionsWrapper');
        const addMcqOptionBtn = document.getElementById('addMcqOptionBtn');

        let mcqCount = {{ $question->options->count() }};

        function createMcqOption(value = '') {
            const wrapper = document.createElement('div');
            wrapper.classList.add('input-group', 'mt-2', 'mcq-option');
            wrapper.innerHTML = `
                <div class="input-group-text">
                    <input type="radio" name="correct_option" value="${mcqCount}" required data-type="mcq">
                </div>
                <input type="text" name="options[]" class="form-control" placeholder="Option ${mcqCount + 1}" required value="${value}" data-type="mcq">
                <span class="input-group-text text-danger remove-option material-symbols-outlined" role="button">close</span>
            `;
            mcqOptionsWrapper.appendChild(wrapper);
            mcqCount++;
        }

        function toggleInputsByType(type) {
            const allInputs = document.querySelectorAll('[data-type]');
            allInputs.forEach(input => {
                input.disabled = (type === '1' && input.dataset.type === 'binary') ||
                    (type !== '1' && input.dataset.type === 'mcq');
            });
            addMcqOptionBtn.style.display = type === '1' ? 'block' : 'none';
        }

        function setBinaryOptions(type) {
            binaryOptionsWrapper.innerHTML = '';
            const values = type === '2' ? ['True', 'False'] : ['Yes', 'No'];
            values.forEach((val, idx) => {
                binaryOptionsWrapper.innerHTML += `
                    <div class="input-group mt-2">
                        <div class="input-group-text">
                            <input type="radio" name="correct_option" value="${idx}" required data-type="binary">
                        </div>
                        <input type="text" name="options[]" class="form-control" required value="${val}" data-type="binary">
                    </div>
                `;
            });
        }

        questionTypeSelect.addEventListener('change', function () {
            const selectedValue = this.value;
            mcqOptionsContainer.style.display = selectedValue === '1' ? 'block' : 'none';
            binaryOptionsContainer.style.display = (selectedValue === '2' || selectedValue === '3') ? 'block' : 'none';
            addMcqOptionBtn.style.display = selectedValue === '1' ? 'block' : 'none';

            if (selectedValue === '1' && mcqOptionsWrapper.children.length === 0) {
                mcqOptionsWrapper.innerHTML = '';
                mcqCount = 0;
                for (let i = 0; i < 4; i++) createMcqOption();
            } else if (selectedValue === '2' || selectedValue === '3') {
                binaryOptionsWrapper.innerHTML = '';
                setBinaryOptions(selectedValue);
            }

            toggleInputsByType(selectedValue);
        });

        addMcqOptionBtn.addEventListener('click', function (e) {
            e.preventDefault();
            createMcqOption();
        });

        mcqOptionsWrapper.addEventListener('click', function (e) {
            if (e.target.classList.contains('remove-option')) {
                const allOptions = mcqOptionsWrapper.querySelectorAll('.mcq-option');
                if (allOptions.length > 2) {
                    e.target.closest('.mcq-option').remove();
                    mcqCount = 0;
                    mcqOptionsWrapper.querySelectorAll('.mcq-option').forEach((option, index) => {
                        const radio = option.querySelector('input[type="radio"]');
                        const text = option.querySelector('input[type="text"]');
                        radio.value = index;
                        text.placeholder = `Option ${index + 1}`;
                        mcqCount++;
                    });
                } else {
                    alert('At least 2 options are required.');
                }
            }
        });

        window.addEventListener('DOMContentLoaded', () => {
            const currentType = "{{ old('question_type', $question->question_type) }}";
            if (currentType) {
                questionTypeSelect.value = currentType;
                mcqOptionsContainer.style.display = currentType === '1' ? 'block' : 'none';
                binaryOptionsContainer.style.display = (currentType === '2' || currentType === '3') ? 'block' : 'none';
                addMcqOptionBtn.style.display = currentType === '1' ? 'block' : 'none';
                toggleInputsByType(currentType);
            }
        });
    </script>
@endpush
