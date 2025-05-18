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
                            <td>{{ \App\Models\ExamQuestion::QUESTION_TYPE[$question->question_type] ?? 'Unknown' }}</td>
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

                <form action="{{ route('exam_questions.store', $exam->id) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="title" class="form-label">Question Title</label>
                        <input type="text" id="title" name="title" class="form-control" required value="{{ old('title') }}">
                    </div>
                    @php use App\Models\ExamQuestion; @endphp
                    <div class="mb-3">
                        <label for="question_type" class="form-label">Question Type</label>
                        <select name="question_type" id="question_type" class="form-select" required>
                            <option value="">Select Question Type</option>
                            @foreach (ExamQuestion::QUESTION_TYPE as $key => $label)
                                <option value="{{ $key }}" {{ old('question_type') == $key ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- MCQ Options -->
                    <div id="mcq-options" class="mb-3" style="display: none;">
                        <label class="form-label">Options</label>
                        <div id="mcq-options-wrapper">
                            <!-- JS will inject initial 4 options here -->
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

                    <button type="submit" class="btn btn-primary">Add Question</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        const questionType = document.getElementById('question_type');
        const mcqWrapper = document.getElementById('mcq-options');
        const binaryWrapper = document.getElementById('binary-options');
        const mcqOptionsWrapper = document.getElementById('mcq-options-wrapper');
        const binaryOptionsWrapper = document.getElementById('binary-options-wrapper');
        const addMcqBtn = document.getElementById('add-mcq-option');

        let mcqCount = 0;

        const createMcqOption = (value = '') => {
            const wrapper = document.createElement('div');
            wrapper.classList.add('input-group', 'mt-2', 'mcq-option');
            wrapper.innerHTML = `
                <div class="input-group-text">
                    <input type="radio" name="correct_option" value="${mcqCount}" required data-type="mcq">
                </div>
                <input type="text" name="options[]" class="form-control" placeholder="Option ${mcqCount + 1}" required value="${value}" data-type="mcq">
                <span class="input-group-text text-danger remove-option" role="button">&times;</span>
            `;
            mcqOptionsWrapper.appendChild(wrapper);
            mcqCount++;
        };

        const loadInitialMcqs = () => {
            mcqOptionsWrapper.innerHTML = '';
            mcqCount = 0;
            for (let i = 0; i < 4; i++) createMcqOption();
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
        };

        questionType.addEventListener('change', function () {
            const value = this.value;

            // Reset content
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

            toggleInputsByType(value);
        });


        addMcqBtn.addEventListener('click', function (e) {
            e.preventDefault();
            createMcqOption();
        });

        // Remove option (minimum 2 options required)
        mcqOptionsWrapper.addEventListener('click', function (e) {
            if (e.target.classList.contains('remove-option')) {
                const allOptions = mcqOptionsWrapper.querySelectorAll('.mcq-option');
                if (allOptions.length > 2) {
                    e.target.closest('.mcq-option').remove();
                    // After removal, reset mcqCount and re-index all MCQ options
                    const remaining = mcqOptionsWrapper.querySelectorAll('.mcq-option');
                    mcqCount = 0;
                    remaining.forEach((option, index) => {
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

        // Trigger change if old input exists
        window.addEventListener('DOMContentLoaded', () => {
            const oldType = "{{ old('question_type') }}";
            if (oldType) {
                questionType.value = oldType;
                questionType.dispatchEvent(new Event('change'));
            }
        });
    </script>

@endsection
