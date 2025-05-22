@extends('front.layouts.app')
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

        <form action="{{ route('front.exam_questions.update', [$exam->id, $question->id]) }}" method="POST">
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
@endsection

@push('js')
    <script>
        const questionType = document.getElementById('question_type');
        const mcqWrapper = document.getElementById('mcq-options');
        const binaryWrapper = document.getElementById('binary-options');
        const mcqOptionsWrapper = document.getElementById('mcq-options-wrapper');
        const binaryOptionsWrapper = document.getElementById('binary-options-wrapper');
        const addMcqBtn = document.getElementById('add-mcq-option');

        let mcqCount = 0;

        const existingOptions = @json($question->options);
        const correctOptionIndex = existingOptions.findIndex(o => o.is_correct);

        let optionCache = {
            mcq: [],
            binary2: [], // for True/False (type=2)
            binary3: [], // for Yes/No (type=3)
        };
        let correctCache = {
            mcq: 0,
            binary2: 0,
            binary3: 0,
        };

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

        const loadInitialMcqs = (options = [], correctIndex = 0) => {
            mcqWrapper.innerHTML = '';

            // Ensure minimum 2 options, pad empty if less
            while (options.length < 2) {
                options.push('');
            }

            options.forEach((val, idx) => {
                const isChecked = idx === correctIndex ? 'checked' : '';
                mcqWrapper.innerHTML += `
                  <div class="input-group mt-2">
                    <div class="input-group-text">
                      <input type="radio" name="correct_option" value="${idx}" required data-type="mcq" ${isChecked}>
                    </div>
                    <input type="text" name="options[]" class="form-control" required value="${val}" data-type="mcq">
                    <button class="btn btn-danger remove-option" type="button" ${options.length <= 2 ? 'disabled' : ''}>-</button>
                  </div>
                `;
            });
        };


        const setBinaryOptions = (type) => {
            binaryOptionsWrapper.innerHTML = '';

            const defaults = type === '2'
                ? ['True', 'False']
                : ['Yes', 'No'];

            defaults.forEach((val, idx) => {
                binaryOptionsWrapper.innerHTML += `
                  <div class="input-group mt-2">
                    <div class="input-group-text">
                      <input type="radio" name="correct_option" value="${idx}" required data-type="binary" ${idx === 0 ? 'checked' : ''}>
                    </div>
                    <input type="text" name="options[]" class="form-control" required value="${val}" data-type="binary">
                  </div>
                `;
            });
        };


        const cacheCurrentInputs = (currentType, questionTypeValue) => {
            const values = [];
            let correctIndex = 0;

            document.querySelectorAll(`input[name="options[]"]`).forEach((input, idx) => {
                if (input.dataset.type === currentType) {
                    values.push(input.value);
                }
            });

            const checkedInput = document.querySelector(`input[name="correct_option"]:checked`);
            if (checkedInput && checkedInput.dataset.type === currentType) {
                correctIndex = parseInt(checkedInput.value);
            }

            if (currentType === 'mcq') {
                optionCache.mcq = values;
                correctCache.mcq = correctIndex;
            } else if (currentType === 'binary') {
                if (questionTypeValue === '2') {
                    optionCache.binary2 = values;
                    correctCache.binary2 = correctIndex;
                } else if (questionTypeValue === '3') {
                    optionCache.binary3 = values;
                    correctCache.binary3 = correctIndex;
                }
            }
        };

        const renderByType = (value) => {
            if (value === '1') {
                mcqWrapper.style.display = 'block';
                binaryWrapper.style.display = 'none';
                loadInitialMcqs(optionCache.mcq.length ? optionCache.mcq : [], correctCache.mcq);
            } else if (value === '2') {
                mcqWrapper.style.display = 'none';
                binaryWrapper.style.display = 'block';
                setBinaryOptions('2'); // always reset to True/False
            } else if (value === '3') {
                mcqWrapper.style.display = 'none';
                binaryWrapper.style.display = 'block';
                setBinaryOptions('3'); // always reset to Yes/No
            } else {
                mcqWrapper.style.display = 'none';
                binaryWrapper.style.display = 'none';
            }
        };

        const initializeCache = () => {
            const type = "{{ $question->question_type }}";
            if (type === '1') {
                optionCache.mcq = existingOptions.map(o => o.title);
                correctCache.mcq = correctOptionIndex;
            } else if (type === '2') {
                optionCache.binary2 = existingOptions.map(o => o.title);
                correctCache.binary2 = correctOptionIndex;
            } else if (type === '3') {
                optionCache.binary3 = existingOptions.map(o => o.title);
                correctCache.binary3 = correctOptionIndex;
            }
        };

        questionType.addEventListener('change', function () {
            let prevType = null;
            let questionTypeValue = this.value;

            if (mcqWrapper.style.display === 'block') prevType = 'mcq';
            else if (binaryWrapper.style.display === 'block') prevType = 'binary';

            if (prevType) cacheCurrentInputs(prevType, questionTypeValue);
            renderByType(questionTypeValue);
        });


        addMcqBtn.addEventListener('click', function (e) {
            e.preventDefault();
            createMcqOption();
        });

        mcqOptionsWrapper.addEventListener('click', function (e) {
            if (e.target.classList.contains('remove-option')) {
                e.target.closest('.mcq-option').remove();
            }
        });

        window.addEventListener('DOMContentLoaded', function () {
            initializeCache();
            questionType.dispatchEvent(new Event('change'));
        });

        const form = document.querySelector('form');

        form.addEventListener('submit', function(e) {
            if (questionType.value === '1') {
                const options = [...document.querySelectorAll('input[name="options[]"][data-type="mcq"]')];
                const filledOptions = options.filter(opt => opt.value.trim() !== '');

                if (filledOptions.length < 2) {
                    e.preventDefault();
                    alert('Please provide at least 2 options for MCQ.');
                    options[0].focus();
                }
            }
        });


    </script>

@endpush
