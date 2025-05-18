@extends('admin.layout.master')
@section('content')
    <div class="page-title">
        <div class="d-flex justify-content-between align-items-end">
            <h1 class="title">Exams List</h1>
            <a href="{{ route('exams.create') }}" class="btn btn-primary">
                <span class="material-symbols-outlined">add</span>
                New
            </a>
        </div>
    </div>

    <div class="page-content">
        <div class="table-responsive bg-white">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>No</th>
                    <th>Title</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Full Mark</th>
                    <th>Duration (Hr)</th>
                    <th>Exam Status</th>
                    <th>Logo</th>
                    <th>Flags</th>
                    <th class="text-end">Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($exams as $key => $exam)
                    <tr>
                        <td>{{ $exams->firstItem() + $loop->index }}</td>
                        <td>{{ $exam->title }}</td>
                        <td>{{ \Carbon\Carbon::parse($exam->exam_start_time)->format('d-m-Y H:i') }}</td>
                        <td>{{ \Carbon\Carbon::parse($exam->exam_end_time)->format('d-m-Y H:i') }}</td>
                        <td>{{ $exam->full_mark }}</td>
                        <td>{{ $exam->duration }}</td>
                        <td>
                            @if($exam->exam_status)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-secondary">Inactive</span>
                            @endif
                        </td>
                        <td>
                            @if($exam->logo)
                                <img src="{{ asset('storage/' . $exam->logo) }}" alt="Logo" style="height: 40px;">
                            @else
                                N/A
                            @endif
                        </td>
                        <td>
                            @php
                                $flags = [
                                    'is_bluer', 'is_timer', 'is_date_enabled',
                                    'user_result_view', 'user_answer_view',
                                    'is_question_random', 'is_option_random',
                                    'is_sign_in_required', 'is_specific_student'
                                ];
                            @endphp

                            @foreach($flags as $flag)
                                @if($exam->$flag)
                                    <span class="badge bg-info text-dark me-1" title="{{ ucwords(str_replace('_', ' ', $flag)) }}">
                                            {{ ucwords(str_replace('_', ' ', $flag)) }}
                                        </span>
                                @endif
                            @endforeach
                        </td>
                        <td class="text-end">
                            <div class="dropdown action">
                                <button class="btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Action <span class="material-symbols-outlined">expand_more</span>
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('exams.show', $exam->id) }}">
                                            <span class="material-symbols-outlined">visibility</span> View
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('exams.edit', $exam->id) }}">
                                            <span class="material-symbols-outlined">edit</span> Edit
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('exam_questions.index', $exam->id) }}">
                                            <span class="material-symbols-outlined">quiz</span> Questions Add
                                        </a>
                                    </li>

                                    @if(!$exam->exam_link)
                                        <li>
                                            <a class="dropdown-item" href="{{ route('exam.create-link', $exam->id) }}">
                                                <span class="material-symbols-outlined">link</span> Create Exam Link
                                            </a>
                                        </li>
                                    @endif

                                    <li>
                                        <form action="{{ route('exams.destroy', $exam->id) }}" method="POST" onsubmit="return confirm('Are you sure to delete this exam?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger" style="border: none; background: none;">
                                                <span class="material-symbols-outlined">delete</span> Delete
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {!! $exams->links() !!}
        </div>
    </div>
@endsection
