@extends('front.layouts.app')
@push('css')
<style>
    :root {
        --primary: #4a6bff;
        --danger: #ff4757;
        --warning: #ffa502;
        --success: #2ed573;
        --dark: #2f3542;
        --light: #f1f2f6;
        --published: #d1fae5;
        --closed: #fee2e2;
        --upcoming: #dbeafe;
    }


    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        flex-wrap: wrap;
        gap: 15px;
    }

    .header h1 {
        color: var(--dark);
    }

    .search-filter {
        display: flex;
        gap: 10px;
    }

    .search-filter input {
        padding: 8px 15px;
        border: 1px solid #ddd;
        border-radius: 5px;
        min-width: 250px;
    }

    .exam-list {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .exam-card {
        background: white;
        border-radius: 8px;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
        padding: 20px;
        display: flex;
        flex-direction: column;
        gap: 15px;
        transition: all 0.3s;
    }

    .exam-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
    }

    .exam-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 15px;
    }

    .exam-info {
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 5px;
    }

    .exam-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--primary);
    }

    .exam-tagline {
        color: #666;
        font-size: 0.9rem;
    }

    .exam-status {
        display: inline-block;
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: bold;
    }

    .status-published {
        background: var(--published);
        color: #065f46;
    }

    .status-closed {
        background: var(--closed);
        color: #b91c1c;
    }

    .status-upcoming {
        background: var(--upcoming);
        color: #1e40af;
    }

    .exam-details {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
        font-size: 0.85rem;
        color: #555;
    }

    .detail-group {
        display: flex;
        flex-direction: column;
        gap: 5px;
    }

    .detail-group span {
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .exam-actions {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        padding-top: 10px;
        border-top: 1px solid #eee;
    }

    .btn {
        padding: 8px 12px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 0.8rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 5px;
        transition: all 0.2s;
    }

    .btn:hover {
        opacity: 0.9;
        transform: translateY(-2px);
    }

    .btn-add {
        background: var(--warning);
        color: white;
    }

    .btn-edit {
        background: var(--primary);
        color: white;
    }

    .btn-delete {
        background: var(--danger);
        color: white;
    }

    .btn-show {
        background: var(--success);
        color: white;
    }

    .btn-result {
        background: #8e44ad;
        color: white;
    }

    @media (max-width: 600px) {
        .exam-header {
            flex-direction: column;
        }
        .search-filter {
            width: 100%;
        }
        .search-filter input {
            min-width: unset;
            flex-grow: 1;
        }
    }
</style>
@endpush

@section('content')

    
<body>
    <div class="container">
        <div class="header">
            <h1>Exam List</h1>
            <div class="search-filter">
                <input type="text" placeholder="Search exams...">
                <button class="btn btn-primary">
                    <i class="fas fa-filter"></i> Filter
                </button>
            </div>
        </div>

        <div class="exam-list">
            <!-- Exam Card 1 -->
            <div class="exam-card">
                <div class="exam-header">
                    <div class="exam-info">
                        <h3 class="exam-title">Physics Intermediate</h3>
                        <p class="exam-tagline">Physics Exam - Intermediate Level</p>
                    </div>
                    <span class="exam-status status-published">Published</span>
                </div>

                <div class="exam-details">
                    <div class="detail-group">
                        <span><i class="far fa-calendar-alt"></i> 23 May 2025 - 24 May 2025</span>
                        <span><i class="far fa-clock"></i> Duration: 02:00:00</span>
                        <span><i class="fas fa-info-circle"></i> No calculators allowed.</span>
                    </div>
                    <div class="detail-group">
                        <span><i class="fas fa-check-circle"></i> Marks: 1.00 per Q</span>
                        <span><i class="fas fa-times-circle"></i> Penalty: -0.10</span>
                        <span><i class="fas fa-user-graduate"></i> Student ID required</span>
                    </div>
                    <div class="detail-group">
                        <span><i class="fas fa-random"></i> Options randomized</span>
                        <span><i class="fas fa-eye-slash"></i> Answers hidden</span>
                        <span><i class="fas fa-chart-bar"></i> Results visible</span>
                    </div>
                </div>

                <div class="exam-actions">
                    <button class="btn btn-add">
                        <i class="fas fa-plus"></i> Add Question
                    </button>
                    <button class="btn btn-edit">
                        <i class="fas fa-edit"></i> Edit
                    </button>
                    <button class="btn btn-delete">
                        <i class="fas fa-trash"></i> Delete
                    </button>
                    <button class="btn btn-show">
                        <i class="fas fa-eye"></i> Show
                    </button>
                </div>
            </div>

           
        </div>
    </div>

@endsection