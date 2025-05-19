@extends('front.layouts.app')
@push('css')
<style>
  

    .exam-container {
        max-width: 800px;
        margin: 2rem auto;
        padding: 2rem;
        background: white;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .exam-header {
        text-align: center;
        margin-bottom: 2rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #e0e0e0;
    }

    .exam-logo {
        width: 80px;
        height: 80px;
        margin-bottom: 1rem;
    }

    .exam-title {
        color: #1904e5;
        margin-bottom: 0.5rem;
    }

    .exam-tagline {
        color: #666;
        font-style: italic;
    }

    .exam-meta {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
        margin: 1.5rem 0;
        background: #f8f9fa;
        padding: 1rem;
        border-radius: 8px;
    }

    .meta-item {
        display: flex;
        align-items: center;
    }

    .meta-item i {
        margin-right: 10px;
        color: #1904e5;
    }

    .time-remaining {
        text-align: center;
        padding: 1rem;
        border-radius: 5px;
        font-weight: bold;
        grid-column: span 2;
        margin-top: 0.5rem;
    }

    .countdown-header {
        font-size: 1.2rem;
        margin-bottom: 1rem;
        color: #1904e5;
    }

    .countdown-timer {
        display: flex;
        justify-content: center;
        gap: 1rem;
        margin-top: 0.5rem;
        font-family: 'Courier New', monospace;
    }

    .countdown-box {
        background: #1904e5;
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 5px;
        min-width: 70px;
        text-align: center;
    }

    .countdown-value {
        font-size: 1.8rem;
        font-weight: bold;
        line-height: 1;
    }

    .countdown-label {
        font-size: 0.7rem;
        opacity: 0.9;
        text-transform: uppercase;
    }

    .instructions {
        margin: 2rem 0;
    }

    .instructions h2 {
        color: #1904e5;
        margin-bottom: 1rem;
        border-bottom: 2px solid #1904e5;
        padding-bottom: 0.5rem;
    }

    .instructions ol {
        padding-left: 1.5rem;
    }

    .instructions li {
        margin-bottom: 0.8rem;
    }

    .btn-start {
        display: block;
        width: 100%;
        padding: 12px;
        background: #1904e5;
        color: white;
        border: none;
        border-radius: 5px;
        font-size: 1.1rem;
        cursor: pointer;
        transition: background 0.3s;
    }

    .btn-start:hover {
        background: #1303b2;
    }

    .btn-start:disabled {
        background: #cccccc;
        cursor: not-allowed;
    }

    @media (max-width: 600px) {
        .exam-meta {
            grid-template-columns: 1fr;
        }
        .time-remaining {
            grid-column: span 1;
        }
        .countdown-timer {
            flex-wrap: wrap;
        }
    }
</style>
@endpush

@section('content')
<div class="exam-container">
        <div class="exam-header">
            <img src="{{asset('img/logo.png')}}" style="max-width: 150px; max-height:100px;">
            <h1 class="exam-title">{{ $exam->title }}</h1>
            <p class="exam-tagline">{{ $exam->tagline }}</p>
        </div>

        <div class="exam-meta">
            <div class="meta-item">
                <i>📅</i>
                <div>
                    <strong>Start Date:</strong> 
                    <time id="start-date" datetime="">Loading...</time>
                </div>
            </div>
            <div class="meta-item">
                <i>📅</i>
                <div>
                    <strong>End Date:</strong> 
                    <time id="end-date" datetime="">Loading...</time>
                </div>
            </div>
            <div class="meta-item">
                <i>💯</i>
                <div>
                    <strong>Total Marks:</strong> {{ $exam->total_marks }}
                </div>
            </div>
            <div class="meta-item">
                <i>❓</i>
                <div>
                    <strong>Total Questions:</strong> 50
                </div>
            </div>
            <div class="meta-item">
                <i>⏱️</i>
                <div>
                    <strong>Duration:</strong> 60 Minutes
                </div>
            </div>
            <div class="time-remaining">
                <div class="countdown-header">Time Until Exam Begins</div>
                <div class="countdown-timer" id="countdown-timer"></div>
            </div>
        </div>

        <div class="instructions">
            <h2>Exam Instructions</h2>
            <ol>
                <li>This exam will be available between <strong><span id="start-date-text">Loading...</span> and <span id="end-date-text">Loading...</span></strong>.</li>
                <li id="availability-notice"><!-- Filled by JavaScript --></li>
                <li>You have <strong>60 minutes</strong> to complete the exam once started.</li>
                <li>All questions are mandatory - there is <strong>no negative marking</strong>.</li>
                <li>Do not refresh the page during the exam.</li>
            </ol>
        </div>

        <button class="btn-start" id="start-exam-btn" disabled>Start Exam Now</button>
    </div>

    <script>
        // Set exam to start tomorrow at 9:00 AM by default
        const now = new Date();
        const startDate = new Date();
        startDate.setDate(now.getDate() +1 ); // Tomorrow
        startDate.setHours(0, 0, 9, 0); // 9:00 AM
        
        // Set exam to end 7 days after start (adjust as needed)
        const endDate = new Date(startDate);
        endDate.setDate(startDate.getDate() + 7);

        // Display dates
        document.getElementById('start-date').datetime = startDate.toISOString();
        document.getElementById('end-date').datetime = endDate.toISOString();
        document.getElementById('start-date').textContent = formatDate(startDate);
        document.getElementById('end-date').textContent = formatDate(endDate);
        document.getElementById('start-date-text').textContent = formatDate(startDate);
        document.getElementById('end-date-text').textContent = formatDate(endDate);

        // Initialize countdown
        updateCountdown();
        const countdownInterval = setInterval(updateCountdown, 1000);

        function updateCountdown() {
            const now = new Date();
            const countdownTimerEl = document.getElementById('countdown-timer');
            const availabilityEl = document.getElementById('availability-notice');
            const startBtn = document.getElementById('start-exam-btn');

            if (now < startDate) {
                // Exam not yet started - show countdown
                const diff = startDate - now;
                const days = Math.floor(diff / (1000 * 60 * 60 * 24));
                const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((diff % (1000 * 60)) / 1000);

                countdownTimerEl.innerHTML = `
                    <div class="countdown-box">
                        <div class="countdown-value">${days}</div>
                        <div class="countdown-label">Days</div>
                    </div>
                    <div class="countdown-box">
                        <div class="countdown-value">${hours}</div>
                        <div class="countdown-label">Hours</div>
                    </div>
                    <div class="countdown-box">
                        <div class="countdown-value">${minutes}</div>
                        <div class="countdown-label">Minutes</div>
                    </div>
                    <div class="countdown-box">
                        <div class="countdown-value">${seconds}</div>
                        <div class="countdown-label">Seconds</div>
                    </div>
                `;

                availabilityEl.innerHTML = `The exam will begin on <strong>${formatDate(startDate)}</strong>.`;
                startBtn.disabled = true;
            } 
            else if (now > endDate) {
                // Exam closed
                clearInterval(countdownInterval);
                document.querySelector('.countdown-header').textContent = 'Exam Period Has Ended';
                countdownTimerEl.innerHTML = '';
                availabilityEl.innerHTML = 'The exam closed on <strong>' + formatDate(endDate) + '</strong>.';
                startBtn.disabled = true;
            } 
            else {
                // Exam active
                clearInterval(countdownInterval);
                document.querySelector('.countdown-header').textContent = 'Exam Is Now Available!';
                countdownTimerEl.innerHTML = '';
                availabilityEl.innerHTML = 'Complete the exam before <strong>' + formatDate(endDate) + '</strong>.';
                startBtn.disabled = false;
            }
        }

        function formatDate(date) {
            return date.toLocaleString('en-US', { 
                month: 'long', 
                day: 'numeric', 
                year: 'numeric',
                hour: '2-digit', 
                minute: '2-digit'
            });
        }
    </script>

@endsection
