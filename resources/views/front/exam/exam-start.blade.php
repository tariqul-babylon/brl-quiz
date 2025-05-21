@extends('front.layouts.app')

@push('css')
<link rel="stylesheet" href="{{ asset('front') }}/vendor/owlCarousel/owl.carousel.min.css">
<style>
    #quiz-question .options .option .form-check-input:checked[type="radio"] {
        --bs-form-check-bg-image: url("{{ asset('front') }}/img/check.png");
    }
    #quiz-question .options .option .form-check-input {
        --bs-form-check-bg-image: url("{{ asset('front') }}/img/uncheck.png");
    }
</style>
@endpush
@section('content')
<div class="body">
    <section id="quiz">
        <div class="container">
            <form class="content" action="{{ route('front.exam-submit') }}" id="questionForm" method="POST">
                @csrf
                <div class="head p-24">
                    <div class="timer">
                        <div class="success" style=""></div>
                        <div class="d-flex justify-content-between time-text">
                            <div class="time-remain">
                                <span class="material-symbols-outlined">
                                    timer
                                </span>
                                <span class="clock" id="totalTime">
                                </span>
                            </div>
                            <div class="total-time">
                                Exam Duration: {{ $exam->duration }}
                            </div>
                        </div>
                    </div>
                    <h3 class="title mb-0">
                        {{ $exam->title }}
                    </h3>
                    <div class="tagline text-center text-muted mb-1">
                        {{ $exam->tagline }}
                    </div>
                    <div class="summery">
                        <div class="question">
                            <span class="label">No. of Question</span>
                            <span class="value" id="totalNumberofQuestion"></span>
                        </div>
                        <div class="answered">
                            <span class="label">Answered</span>
                            <span class="value" id="totalQuestionAnswered"></span>
                        </div>
                        <div class="skipped d-none">
                            <span class="label">Not Answered</span>
                            <span class="value" id="totalQuestionSkipped"></span>
                        </div>
                    </div>
                </div>
                <div id="quiz-indicator">
                    <div class="owl-carousel">
                        @foreach ($response_questions as $key => $question)
                            @php
                                $qid = $question['id'];
                            @endphp
                            <div class="item">
                                <a href="#" id="car{{ $qid }}" index="{{ $qid }}"
                                    class="question @if ($loop->first) active @endif">
                                    {{ $loop->iteration }}
                                </a>
                            </div>
                        @endforeach
                    </div>
                    <div class="bar"></div>
                </div>
                <div id="quiz-question">
                    @foreach ($response_questions as $key => $question)
                        @php
                            $qid = $question['id'];
                        @endphp
                        <div class="question-section @if (!$loop->first) d-none @endif"
                            id="ans{{ $qid }}">
                            <div class="question-no">
                                Question {{ $loop->iteration }}:
                            </div>
                            <div class="question">
                                {{ $question['question'] }}
                            </div>
                            <div class="options">
                                @foreach ($question['options'] as $option)
                                    <label class="option" for="option-{{$loop->iteration}}{{ $qid }}">
                                        <input class="form-check-input" name="ans{{$qid}}"
                                            value="{{ $option['id'] }}" type="radio" id="option-{{$loop->iteration}}{{ $qid }}">
                                        <span class="form-check-label">{{ $option['title'] }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
                <div id="quiz-button">
                    <div class="d-flex flex-wrap justify-content-between">
                        <button id="prevBtn" disabled onclick="questionChange(-1)" type="button" class="btn back">
                            <span class="material-symbols-outlined">
                                chevron_left
                            </span>
                            Back
                        </button>
                        <div>
                            <button id="skipBtn" onclick="" type="button" class="btn d-none">
                                Reset
                            </button>
                            <button id="nextBtn" onclick="questionChange(1)" type="button" class="btn next">
                                <span class="text">Next</span>
                                <span class="material-symbols-outlined">
                                    chevron_right
                                </span>
                            </button>
                        </div>
                    </div>
                    <button id="submitBtn" class="btn submit" type="button" data-bs-toggle="modal"
                        data-bs-target="#submitFormModal">Submit My Quiz & Exit</button>
                </div>
            </form>
        </div>
    </section>
</div>
<div class="modal fade" id="submitFormModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <img src="{{ asset('front') }}/img/submit avater.png" alt="">
                <div class="title">Are you sure to submit your quiz?</div>
                <div class="summery">
                    Total Answer <span class="count" id="modalCount"></span>
                </div>
                <div class="buttons">
                    <button id="questionSubmitBtn" class="btn yes">
                        <span class="material-symbols-outlined">
                            check
                        </span>
                        Yes, I Confirm
                    </button>
                    <button class="btn cancel" data-bs-dismiss="modal">
                        <span class="material-symbols-outlined">
                            close
                        </span>
                        Back To Exam
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection

@push('js')
    <script src="{{ asset('front') }}/vendor/owlCarousel/owl.carousel.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
    <script>
        //question
        var currentIndex = 0;
        var totalQuestion = $('#quiz-question .question-section').length;
        var questions = [];
        var i = 0;
        const totalAnswered = new Set();

        var owl = $('#quiz-indicator .owl-carousel');
        owl.owlCarousel({
            center: false,
            autoWidth: true,
            loop: false,
            margin: 18,
            nav: false,
            dots: false,
            responsive: {
                575: {
                    margin: 24,
                }
            }
        });

        function setActiveClassInput() {
            let ss = $('#quiz-question .options .option input');
            console.log(totalAnswered.size, totalQuestion);
            if (totalAnswered.size == totalQuestion) {
                $("#submitBtn").addClass('btn-all');
            } else {
                $("#submitBtn").removeClass('btn-all');
            }
            ss.each(function() {
                let name = $(this).attr('name');
                let val = $('input[name=' + name + ']:checked').val();
                if (val) {
                    totalAnswered.add(name.substr(3))
                    if ($(this).prop('checked')) {
                        $(this).parent().addClass('active')
                    }

                }
            });
            headerChange();
        }
        setActiveClassInput();
        $('#quiz-question .options .option').click(function() {
            if ($(this).children('input').prop('checked')) {
                $(this).parent().children('.option').removeClass('active')
                $(this).addClass('active');
            } else {
                $(this).removeClass('active');
            }
            setActiveClassInput();
            skiBtnHide();
        });

        $('#quiz-question .options .option input').change(function() {

            if ($(this).prop('checked')) {
                $(this).parent().parent().children('.option').removeClass('active')
                $(this).parent().addClass('active');
            } else {
                $(this).parent().removeClass('active');
            }
            setActiveClassInput();
        });

        $('#quiz-question .question-section').each(function() {
            questions[i++] = $(this).attr('id').substr(3);
        });

        function skiBtnHide() {
            if (totalAnswered.has(questions[currentIndex])) {
                $("#skipBtn").removeClass('d-none');
                //  $("#nextBtn .text").html('Answer'); //Answer
            } else {
                $("#skipBtn").addClass('d-none');
                // $("#nextBtn .text").html('Skip');
            }
        }
        skiBtnHide();

        function questionChange(value) {
            let currectQuestion = questions[currentIndex];
            let nextQuestion = questions[currentIndex + value];
            currentIndex += value;
            if ((currentIndex - 1) < 0) {
                $('#prevBtn').attr('disabled', '');
            } else {
                $('#prevBtn').removeAttr('disabled');
            }
            if (currentIndex < 0) {
                currentIndex = 0;
                return;
            }

            if ((currentIndex + 1) >= totalQuestion) {
                $('#nextBtn').attr('disabled', '');
            } else {
                $('#nextBtn').removeAttr('disabled');
            }

            if (currentIndex >= totalQuestion) {
                currentIndex = totalQuestion;
                return;
            }
            let id = '#ans' + currectQuestion;
            let nextId = '#ans' + nextQuestion;
            let name = id + ' input[name=ans' + currectQuestion + ']';
            $(id).addClass('d-none');
            $(nextId).removeClass('d-none');
            skiBtnHide();
            owl.trigger('to.owl.carousel', [currentIndex, 300]);
            let currentCasousel = "#quiz-indicator .owl-item:nth-child(" + (currentIndex + 1) + ") .question";
            $("#quiz-indicator .question").removeClass('active');
            $(currentCasousel).addClass('active');
        }
        $("#questionSubmitBtn").click(function(e) {
            e.preventDefault();
            $('#questionForm').submit();
        });
        headerChange();

        function headerChange() {
            $("#modalCount").html(`${totalAnswered.size}/${totalQuestion}`);
            $("#totalNumberofQuestion").html(totalQuestion);
            $("#totalQuestionAnswered").html(totalAnswered.size);
            $("#totalQuestionSkipped").html(totalQuestion - totalAnswered.size);
            let loader = (totalAnswered.size / totalQuestion) * 100;
            $("#navLoader").css('width', loader + "%");
            $("#quiz-indicator .question").removeClass('answered');
            for (const value of totalAnswered) {
                let id = '#car' + value;
                $(id).addClass('answered');
            }
        }

        $("#skipBtn").click(function() {
            let id = "#ans" + questions[currentIndex] + ' input';
            let option = "#ans" + questions[currentIndex] + ' .options .option';
            $(id).prop('checked', false);
            $(option).removeClass('active');
            totalAnswered.delete(questions[currentIndex]);
            headerChange();
            skiBtnHide();
            setActiveClassInput();
        });

        const minuteSpent = parseInt("{{ $minute_spent }}") || 0;
        const secondSpent = parseInt("{{ $second_spent }}") || 0;

        const examDurationHours = parseInt("{{ $exam_duration_in_hours }}") || 0;
        const examDurationMinutes = parseInt("{{ $exam_duration_in_minutes }}") || 0;

        // Calculate total exam duration in seconds
        const totalExamSeconds = examDurationHours * 3600 + examDurationMinutes * 60;

        // Calculate total seconds already spent
        const spentSeconds = minuteSpent * 60 + secondSpent;

        // Remaining seconds
        let remainingSeconds = totalExamSeconds - spentSeconds;

        // Function to format seconds as HH:mm:ss
        function formatTime(seconds) {
            const h = Math.floor(seconds / 3600);
            const m = Math.floor((seconds % 3600) / 60);
            const s = seconds % 60;
            return [
                h.toString().padStart(2, '0'),
                m.toString().padStart(2, '0'),
                s.toString().padStart(2, '0')
            ].join(':');
        }

        // Update progress bar width (if you have one)
        function setTimerLoader() {
            let progress = ((remainingSeconds / totalExamSeconds) * 100).toFixed(2);
            $("#quiz .content .head .timer .success").css('width', progress + '%');
        }

        function clockStart() {
            if (remainingSeconds <= 0) {
                clearInterval(clock);
                $('#totalTime').html("00:00:00");
                $('#questionForm').submit();
            } else {
                $('#totalTime').html(formatTime(remainingSeconds));
                setTimerLoader();
                remainingSeconds--;
            }
        }

        // Initialize display right away
        $('#totalTime').html(formatTime(remainingSeconds));
        setTimerLoader();

        // Start the countdown timer
        const clock = setInterval(clockStart, 1000);

        $("#quiz-indicator .question").click(function(e) {
            e.preventDefault();
            let id = "#ans" + $(this).attr('id').substr(3);
            $('#quiz-question .question-section').addClass('d-none');
            $('#quiz-indicator .question').removeClass('active');
            $(this).addClass('active');
            $(id).removeClass('d-none');
            currentIndex = questions.indexOf($(this).attr('id').substr(3));

            if ((currentIndex - 1) < 0) {
                $('#prevBtn').attr('disabled', '');
            } else {
                $('#prevBtn').removeAttr('disabled');
            }
            if ((currentIndex + 1) >= totalQuestion) {
                $('#nextBtn').attr('disabled', '');
            } else {
                $('#nextBtn').removeAttr('disabled');
            }
            skiBtnHide();
        });
    </script>
@endpush
