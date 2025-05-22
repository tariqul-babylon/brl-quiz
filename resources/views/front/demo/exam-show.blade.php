@extends('front.layouts.app')
@push('css')
<style>
    :root {
        --primary: #4285F4;
        --danger: #EA4335;
        --success: #34A853;
        --warning: #FBBC05;
        --dark: #202124;
        --light-bg: #f8f9fa;
        --correct: #E6F4EA;
    }

    .container.custom {
        max-width: 800px;
        margin: 0 auto;
    }

    .exam-header-card {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        padding: 24px;
        margin-bottom: 24px;
    }

    .exam-title {
        font-size: 1.5rem;
        color: var(--dark);
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .exam-tagline {
        color: #5f6368;
        font-size: 1rem;
        margin-bottom: 20px;
    }

    .exam-meta {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 16px;
        margin-top: 20px;
    }

    .meta-item {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .meta-icon {
        color: #5f6368;
    }

    .meta-label {
        font-size: 0.9rem;
        color: #5f6368;
    }

    .meta-value {
        font-weight: 500;
        margin-top: 2px;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        padding: 6px 12px;
        border-radius: 16px;
        font-size: 0.8rem;
        font-weight: 500;
        margin-top: 16px;
    }

    .status-active {
        background: #E6F4EA;
        color: #34A853;
    }

    .status-pending {
        background: #FEF7E0;
        color: #FBBC05;
    }

    /* Questions Section */
    .questions-container {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        padding: 24px;
    }

    .section-title {
        font-size: 1.2rem;
        color: var(--dark);
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .question-card {
        padding: 16px;
        margin-bottom: 20px;
        border: 1px solid #f1f3f4;
        border-radius: 8px;
    }

    .question-text {
        font-size: 1rem;
        font-weight: 500;
        margin-bottom: 16px;
        display: flex;
        gap: 8px;
    }

    .question-number {
        color: var(--primary);
        font-weight: 600;
    }

    .options-list {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .option-item {
        display: flex;
        align-items: center;
        padding: 12px;
        border-radius: 4px;
        background: #f8f9fa;
        gap: 8px;
    }

    .option-item.correct {
        background: var(--correct);
        border-left: 3px solid var(--success);
    }

    .option-letter {
        font-weight: 600;
        color: #5f6368;
    }

    .correct-icon {
        color: var(--success);
        margin-left: auto;
    }

    @media (max-width: 600px) {
        .exam-meta {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')


    <div class="container custom mt-4 my-5">
        <!-- Exam Header -->
        <div class="exam-header-card">
            <div class="d-flex justify-content-between flex-wrap align-items-start">
                <div>
                    <table class="table mb-0 table-borderless table-sm">
                        <tr>
                            <td>Exam Code: <b>EXAM-12345</b></td>
                        </tr>
                        <tr>
                            <td><h1 class="exam-title m-0">Chemistry Practical Exam</h1></td>
                        </tr>
                        <tr>
                            <td><div class="text-muted">Laboratory skills assessment</div></td>
                        </tr>
                    </table>
                </div>
                <div class="text-end text-muted">
                    <small>Exam Status </small> <br>
                    <span class="badge bg-success">Active</span>
                </div>
            </div>

            <hr class="my-2">
            
            <div class="exam-meta">
                <div class="meta-item">
                    <span class="material-symbols-outlined meta-icon">schedule</span>
                    <div>
                        <div class="meta-label">Duration</div>
                        <div class="meta-value">03:00:00</div>
                    </div>
                </div>
                <div class="meta-item">
                    <span class="material-symbols-outlined meta-icon">grade</span>
                    <div>
                        <div class="meta-label">Marks per Question</div>
                        <div class="meta-value">1.25</div>
                    </div>
                </div>
                <div class="meta-item">
                    <span class="material-symbols-outlined meta-icon">remove_circle</span>
                    <div>
                        <div class="meta-label">Negative Marking</div>
                        <div class="meta-value">0.50</div>
                    </div>
                </div>
                <div class="meta-item">
                    <span class="material-symbols-outlined meta-icon">badge</span>
                    <div>
                        <div class="meta-label">Registration Number</div>
                        <div class="meta-value">Reg. No.</div>
                    </div>
                </div>
                <div class="meta-item">
                    <span class="material-symbols-outlined meta-icon">shuffle</span>
                    <div>
                        <div class="meta-label">Question Order</div>
                        <div class="meta-value">Randomized</div>
                    </div>
                </div>
                <div class="meta-item">
                    <span class="material-symbols-outlined meta-icon">visibility</span>
                    <div>
                        <div class="meta-label">Results</div>
                        <div class="meta-value">Visible to Students</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Questions Section -->
        <div class="questions-container">
            <h2 class="section-title">
                <span class="material-symbols-outlined">quiz</span>
                Exam Questions
            </h2>

            <!-- Question 1 -->
            <div class="question-card">
                <div class="question-text">
                    <span class="question-number">Q1.</span>
                    What is the color change observed when phenolphthalein is added to a basic solution?
                </div>
                <div class="options-list">
                    <div class="option-item correct">
                        <span class="option-letter">A)</span>
                        Colorless to pink
                        <span class="material-symbols-outlined correct-icon">check_circle</span>
                    </div>
                    <div class="option-item">
                        <span class="option-letter">B)</span>
                        Pink to colorless
                    </div>
                    <div class="option-item">
                        <span class="option-letter">C)</span>
                        Blue to red
                    </div>
                    <div class="option-item">
                        <span class="option-letter">D)</span>
                        No color change
                    </div>
                </div>
            </div>

            <!-- Question 2 -->
            <div class="question-card">
                <div class="question-text">
                    <span class="question-number">Q2.</span>
                    Which apparatus is essential for measuring precise liquid volumes in titration?
                </div>
                <div class="options-list">
                    <div class="option-item">
                        <span class="option-letter">A)</span>
                        Beaker
                    </div>
                    <div class="option-item correct">
                        <span class="option-letter">B)</span>
                        Burette
                        <span class="material-symbols-outlined correct-icon">check_circle</span>
                    </div>
                    <div class="option-item">
                        <span class="option-letter">C)</span>
                        Test tube
                    </div>
                    <div class="option-item">
                        <span class="option-letter">D)</span>
                        Funnel
                    </div>
                </div>
            </div>

            <!-- Question 3 -->
            <div class="question-card">
                <div class="question-text">
                    <span class="question-number">Q3.</span>
                    What safety equipment should always be worn in the chemistry lab?
                </div>
                <div class="options-list">
                    <div class="option-item">
                        <span class="option-letter">A)</span>
                        Sandals
                    </div>
                    <div class="option-item">
                        <span class="option-letter">B)</span>
                        Loose clothing
                    </div>
                    <div class="option-item correct">
                        <span class="option-letter">C)</span>
                        Safety goggles
                        <span class="material-symbols-outlined correct-icon">check_circle</span>
                    </div>
                    <div class="option-item">
                        <span class="option-letter">D)</span>
                        Headphones
                    </div>
                </div>
            </div>
        </div>

        <button class="btn mt-3 btn-outline-secondary d-flex align-items-center gap-2">
            <span class="material-symbols-outlined">arrow_back</span>
            Back to Exams List
        </button>
    </div>


@endsection