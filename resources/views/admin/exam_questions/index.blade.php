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
                        <select name="question_type" id="question_type" class="form-select" required>
                            <option value="">Select Question Type</option>
                            <option value="1" {{ old('question_type') == '1' ? 'selected' : '' }}>MCQ</option>
                            <option value="2" {{ old('question_type') == '2' ? 'selected' : '' }}>True / False</option>
                            <option value="3" {{ old('question_type') == '3' ? 'selected' : '' }}>Yes / No</option>
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
            mcqCount++;
            const wrapper = document.createElement('div');
            wrapper.classList.add('input-group', 'mt-2', 'mcq-option');
            wrapper.innerHTML = `
            <div class="input-group-text">
                <input type="radio" name="correct_option" value="${mcqCount}" required>
            </div>
            <input type="text" name="options[]" class="form-control" placeholder="Option ${mcqCount}" required value="${value}">
            <span class="input-group-text text-danger remove-option" role="button">&times;</span>
        `;
            mcqOptionsWrapper.appendChild(wrapper);
        };

        const loadInitialMcqs = () => {
            mcqOptionsWrapper.innerHTML = '';
            mcqCount = 0;
            for (let i = 0; i < 4; i++) createMcqOption();
        };

        const setBinaryOptions = (type) => {
            binaryOptionsWrapper.innerHTML = '';
            const values = type === '2' ? ['True', 'False'] : ['Yes', 'No'];
            values.forEach((val, idx) => {
                binaryOptionsWrapper.innerHTML += `
                <div class="input-group mt-2">
                    <div class="input-group-text">
                        <input type="radio" name="correct_option" value="${val}" required>
                    </div>
                    <input type="text" name="options[]" class="form-control" required value="${val}">
                </div>
            `;
            });
        };

        questionType.addEventListener('change', function () {
            const value = this.value;

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

        // Remove option (minimum 2 options required)
        mcqOptionsWrapper.addEventListener('click', function (e) {
            if (e.target.classList.contains('remove-option')) {
                const allOptions = mcqOptionsWrapper.querySelectorAll('.mcq-option');
                if (allOptions.length > 2) {
                    e.target.closest('.mcq-option').remove();
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
