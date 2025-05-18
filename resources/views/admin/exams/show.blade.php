@extends('admin.layout.master')

@section('content')
    <div class="container">
        <h2 class="mb-4">Exam Details</h2>

        <div class="row">
            <div class="col-8">
                <div class="card mb-4">
                    <div class="card-header">
                        <h4 class="card-title">{{ $exam->title }}</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tbody>
                            <tr>
                                <th>Tagline</th>
                                <td>{{ $exam->tagline }}</td>
                            </tr>
                            <tr>
                                <th>Exam Code</th>
                                <td>{{ $exam->exam_code }}</td>
                            </tr>
                            <tr>
                                <th>Start Time</th>
                                <td>{{ $exam->exam_start_time ? \Carbon\Carbon::parse($exam->exam_start_time)->format('d-m-Y H:i') : 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>End Time</th>
                                <td>{{ $exam->exam_end_time ? \Carbon\Carbon::parse($exam->exam_end_time)->format('d-m-Y H:i') : 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Full Mark</th>
                                <td>{{ $exam->full_mark }}</td>
                            </tr>
                            <tr>
                                <th>Negative Mark</th>
                                <td>{{ $exam->negative_mark }}</td>
                            </tr>
                            <tr>
                                <th>Duration</th>
                                <td>{{ $exam->duration }}</td>
                            </tr>
                            <tr>
                                <th>Instruction</th>
                                <td>{!! nl2br(e($exam->instruction)) !!}</td>
                            </tr>
                            <tr>
                                <th>ID No Placeholder</th>
                                <td>{{ $exam->id_no_placeholder ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Exam Link</th>
                                <td>{{ $exam->exam_link ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Exam Status</th>
                                <td>
                                    @if($exam->exam_status)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-secondary">Inactive</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Logo</th>
                                <td>
                                    @if($exam->logo)
                                        <img src="{{ asset('storage/' . $exam->logo) }}" alt="Logo" style="height: 60px;">
                                    @else
                                        N/A
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Flags</th>
                                <td>
                                    @php
                                        $flags = [
                                            'is_bluer' => 'Bluer',
                                            'is_timer' => 'Timer',
                                            'is_date_enabled' => 'Date Enabled',
                                            'user_result_view' => 'User Result View',
                                            'user_answer_view' => 'User Answer View',
                                            'is_question_random' => 'Question Random',
                                            'is_option_random' => 'Option Random',
                                            'is_sign_in_required' => 'Sign-In Required',
                                            'is_specific_student' => 'Specific Student'
                                        ];
                                    @endphp
                                    @foreach($flags as $key => $label)
                                        @if($exam->$key)
                                            <span class="badge bg-info text-dark me-1">{{ $label }}</span>
                                        @endif
                                    @endforeach
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-3">Questions</h4>
                    </div>
                    @forelse($exam->questions as $index => $question)
                        <div class="card p-4">
                            <div class="card-header">
                                <strong>Q{{ $index + 1 }}:</strong> {{ $question->title }}
                            </div>
                            <div class="card-body">
                                <ul class="list-group">
                                    @foreach($question->options as $option)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            {{ $option->title }}
                                            @if($option->is_correct)
                                                <span class="badge bg-success">✔️</span>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @empty
                        <p>No questions available for this exam.</p>
                    @endforelse
                </div>
            </div>
        </div>



    </div>
@endsection
