@extends('front.layouts.app')
@push('css')
    <style>
        .result-container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        .result-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .result-header h1 {
            margin: 0;
            font-size: 32px;
        }
        .tagline {
            font-style: italic;
        }
        .exam-info {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin-bottom: 25px;
        }
        .info-box {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            border-left: 4px solid #3498db;
        }
        .info-box span {
            display: block;
            color: #7f8c8d;
            font-size: 14px;
        }
        .info-box strong {
            font-size: 16px;
            color: #2c3e50;
        }
        .performance-stats {
            display: flex;
            justify-content: space-between;
            margin-bottom: 25px;
            gap: 15px;
        }
        .stat-card {
            flex: 1;
            text-align: center;
            padding: 20px;
            border-radius: 5px;
            color: white;
        }
        .stat-card h3 {
            margin: 0 0 10px 0;
            font-size: 18px;
        }
        .stat-card p {
            margin: 0;
            font-size: 24px;
            font-weight: bold;
        }
        .correct {
            background-color: #d4edda; /* light green */
            color: #155724;   
        }
        .incorrect {
            background-color: #ffbebe; /* light red */
            color: #a71d2a; 
        }
        .unanswered {
            background-color: #fff3cd; /* light amber */
            color: #856404; 
        }
        .marks-summary {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin-bottom: 30px;
        }
        .marks-box {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
            text-align: center;
        }
        .marks-box span {
            display: block;
            color: #7f8c8d;
            font-size: 14px;
        }
        .marks-box strong {
            font-size: 24px;
            color: #2c3e50;
        }
        .negative strong {
            color: #e74c3c;
        }
        .total strong {
            color: #27ae60;
        }
        .print-btn {
            display: block;
            width: 100%;
            padding: 12px;
            background: #3498db;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s;
        }
        .print-btn:hover {
            background: #2980b9;
        }
        @media (max-width: 600px) {
            .exam-info, .performance-stats, .marks-summary {
                grid-template-columns: 1fr;
            }
            .performance-stats {
                flex-direction: column;
            }
        }
    </style>
@endpush
@section('content')

    <section class="mb-3" id="submit-success">
        <div class="container">
            <div class="content p-0">
                <div class="title">Your exam is successfully submitted!</div>                               
            </div>
        </div>
    </section>

    
    <div class="result-container mb-5">

        <header class="result-header">
            <small>Exam Code: {{ $exam->exam_code }}</small>
            <h1>{{ $exam->title }}</h1>
            <p class="tagline">{{ $exam->tagline }}</p>
        </header>

        <div class="exam-info">
            <div class="info-box">
                <span>Full Mark:</span>
                <strong id="full-mark">{{$answer->full_mark}}</strong>
            </div>
            <div class="info-box">
                <span>Total Questions:</span>
                <strong id="total-questions">{{$answer->answerOptions->count()}}</strong>
            </div>
            <div class="info-box">
                <span>Exam Duration:</span>
                <strong id="exam-duration">{{$answer->exam->duration}}</strong>
            </div>
            <div class="info-box">
                <span>Time Spent:</span>
                <strong id="time-spent">
                    {{Carbon\Carbon::createFromFormat('H:i:s.u', $answer->duration)->format('H:i:s')}}
                </strong>
            </div>
        </div>

        <div class="performance-stats">
            <div class="stat-card correct">
                <h3>Correct</h3>
                <p id="correct-answers">{{$answer->correct_ans}}</p>
            </div>
            <div class="stat-card incorrect">
                <h3>Incorrect</h3>
                <p id="incorrect-answers">{{$answer->incorrect_ans}}</p>
            </div>
            <div class="stat-card unanswered">
                <h3>Unanswered</h3>
                <p id="unanswered">{{$answer->not_answered}}</p>
            </div>
        </div>

        <div class="marks-summary">
            <div class="marks-box">
                <span>Obtained Mark:</span>
                <strong id="obtained-mark">{{$answer->obtained_mark}}</strong>
            </div>
            <div class="marks-box negative">
                <span>Negative Mark:</span>
                <strong id="negative-mark">{{$answer->negative_mark}}</strong>
            </div>
            <div class="marks-box total">
                <span>Net Total Mark:</span>
                <strong id="net-mark">{{$answer->final_obtained_mark}}</strong>
            </div>
        </div>

        <section class="mw-100" id="submit-success">
            <div class="container">
                <div class="content p-0">
                    <div class="buttons">
                        <a href="{{ url('/') }}" class="btn back">
                            <span class="material-symbols-outlined">
                                exit_to_app
                            </span>
                            Back To Home
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </div>

       

 
@endsection

@push('js')
    <script>
                window.onload = function() {
            if (window.history.replaceState) {
                // Prevent form resubmission dialog
                window.history.replaceState(null, null, window.location.href);
            }
            // Optionally clear form inputs
            document.querySelectorAll('form input, form textarea, form select').forEach(el => el.value = '');
        };
    </script>
@endpush