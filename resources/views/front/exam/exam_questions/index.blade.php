@extends('front.layouts.app')
@section('content')
    <div class="container">
        <h2>Manage Questions for Exam: {{ $exam->title }}</h2>

        <div class="row">
            <!-- Left column: Question List -->
            <div class="col-md-8">
                <div class="card p-4">
                    <h4>Questions List</h4>
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($questions as $question)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $question->title }}</td>
                                <td>{{ \App\Models\ExamQuestion::QUESTION_TYPE[$question->question_type] ?? 'Unknown' }}</td>
                                <td>{{ $question->status ? 'Active' : 'Inactive' }}</td>
                                <td>
                                    <a href="{{ route('front.exam_questions.edit', [$exam->id, $question->id]) }}" class="btn btn-sm btn-warning">Edit</a>

                                    <form action="{{ route('front.exam_questions.destroy', [$exam->id, $question->id]) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this question?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center">No questions added yet.</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Right column: Add Question Form -->
            <div class="col-md-4">
                <div class="card p-4">
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

                    <form action="{{ route('front.exam_questions.store', $exam->id) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="title" class="form-label">Question Title</label>
                            <input type="text" id="title" name="title" class="form-control" required value="{{ old('title') }}">
                        </div>

                        @php use App\Models\ExamQuestion; @endphp

                        <div class="mb-3">
                            <label for="questionTypeSelect" class="form-label">Question Type</label>
                            <select name="question_type" id="questionTypeSelect" class="form-select" required>
                                <option value="">Select Question Type</option>
                                @foreach (ExamQuestion::QUESTION_TYPE as $key => $label)
                                    <option value="{{ $key }}" {{ old('question_type') == $key ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- MCQ Options -->
                        <div id="mcqOptionsContainer" class="mb-3" style="display: none;">
                            <label class="form-label">Options</label>
                            <div id="mcqOptionsWrapper"></div>
                            <div class="text-center">
                                <a href="#" id="addMcqOptionBtn" class="mt-2 d-block text-decoration-none">Add More Option</a>
                            </div>
                        </div>

                        <!-- True/False or Yes/No -->
                        <div id="binaryOptionsContainer" class="mb-3" style="display: none;">
                            <label class="form-label">Options</label>
                            <div id="binaryOptionsWrapper"></div>
                        </div>

                        <button type="submit" class="btn btn-primary">Add Question</button>
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

        let mcqCount = 0;

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

        function loadInitialMcqs() {
            mcqOptionsWrapper.innerHTML = '';
            mcqCount = 0;
            for (let i = 0; i < 4; i++) createMcqOption();
        }

        function toggleInputsByType(type) {
            const allInputs = document.querySelectorAll('[data-type]');
            allInputs.forEach(input => {
                input.disabled = (type === '1' && input.dataset.type === 'binary') ||
                    (type !== '1' && input.dataset.type === 'mcq');
            });
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
            mcqOptionsWrapper.innerHTML = '';
            binaryOptionsWrapper.innerHTML = '';

            if (selectedValue === '1') {
                mcqOptionsContainer.style.display = 'block';
                binaryOptionsContainer.style.display = 'none';
                loadInitialMcqs();
            } else if (selectedValue === '2' || selectedValue === '3') {
                mcqOptionsContainer.style.display = 'none';
                binaryOptionsContainer.style.display = 'block';
                setBinaryOptions(selectedValue);
            } else {
                mcqOptionsContainer.style.display = 'none';
                binaryOptionsContainer.style.display = 'none';
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
            const oldType = "{{ old('question_type') }}";
            if (oldType) {
                questionTypeSelect.value = oldType;
                questionTypeSelect.dispatchEvent(new Event('change'));
            }
        });
    </script>
@endpush
