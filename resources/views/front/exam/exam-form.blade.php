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
                        <form class="signup-form" action="{{ route('front.exam-form-submit', $exam->exam_code) }}" method="POST">
                            @csrf
                            @auth
                                <div class="form-group">
                                    <label for="name">Enter Full Name</label>
                                    <div class="input-with-icon">
                                        <span class="material-symbols-outlined input-icon">person</span>
                                        <input readonly value="{{ auth()->user()->name }}" type="text" name="name">
                                    </div>
                                    @error('name')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="contact">Enter Phone Number</label>
                                    <div class="input-with-icon">
                                        <span class="material-symbols-outlined input-icon">phone</span>
                                        <input @if( auth()->user()->contact) readonly @endif value="{{ auth()->user()->contact }}" type="tel" name="contact">
                                    </div>
                                    @error('contact')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            @endauth
                            @guest
                                <div class="form-group">
                                    <label for="name">Enter Full Name</label>
                                    <div class="input-with-icon">
                                        <span class="material-symbols-outlined input-icon">person</span>
                                        <input type="text" name="name" required>
                                    </div>
                                    @error('name')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="phone">Enter Phone Number</label>
                                    <div class="input-with-icon">
                                        <span class="material-symbols-outlined input-icon">phone</span>
                                        <input type="tel" name="contact" required>
                                    </div>
                                    @error('contact')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            @endguest

                            @if ($exam->id_no_placeholder)
                                <div class="form-group">
                                    <label for="phone">{{ $exam->id_no_placeholder }}</label>
                                    <div class="input-with-icon">
                                        <span class="material-symbols-outlined input-icon">phone</span>
                                        <input type="text" name="id_no" required>
                                    </div>
                                    @error('id_no')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
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
