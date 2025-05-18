@extends('front.layouts.app')
@push('css')
<style>

.exam-title {
    font-size: 15px;
    font-weight: 600;
    margin: 0;
    color: #1a1a1a;
}

.exam-tagline {
    font-size: 0.95rem;
    color: #666;
    margin: 0;
}

.exam-code {
    font-size: 0.9rem;
    color: #555;
    display: inline-block;
}
    </style>
@endpush
@section('content')
    <section class="login-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-8">
                    <div class="login-card">
                        <div class="login-header">
                            <div class="exam-code">Exam Code: <strong>{{ $exam->exam_code }}</strong></div>
                            <h2 class="exam-title m-0">{{ $exam->title }}</h2>
                            <p class="exam-tagline">{{ $exam->tagline }}</p>
                        </div>
                        <form class="signup-form">
                            @auth
                                <div class="form-group">
                                    <label for="name">Enter Full Name</label>
                                    <div class="input-with-icon">
                                        <span class="material-symbols-outlined input-icon">person</span>
                                        <input value="{{ auth()->user()->name }}" type="text" name="name">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="phone">Enter Phone Number</label>
                                    <div class="input-with-icon">
                                        <span class="material-symbols-outlined input-icon">phone</span>
                                        <input value="{{ auth()->user()->contact }}" type="tel" name="contact">
                                    </div>
                                </div>
                            @endauth
                            @guest
                                <div class="form-group">
                                    <label for="name">Enter Full Name</label>
                                    <div class="input-with-icon">
                                        <span class="material-symbols-outlined input-icon">person</span>
                                        <input type="name" name="name" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="phone">Enter Phone Number</label>
                                    <div class="input-with-icon">
                                        <span class="material-symbols-outlined input-icon">phone</span>
                                        <input type="tel" name="contact" required>
                                    </div>
                                </div>
                            @endguest

                            @if ($exam->id_no_placeholder)
                                <div class="form-group">
                                    <label for="phone">{{ $exam->id_no_placeholder }}</label>
                                    <div class="input-with-icon">
                                        <span class="material-symbols-outlined input-icon">phone</span>
                                        <input type="text" name="id_no" required>
                                    </div>
                                </div>
                            @endif

                            <button type="submit" class="btn-login">Start Exam</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
