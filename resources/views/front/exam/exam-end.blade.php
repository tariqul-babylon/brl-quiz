@extends('front.layouts.app')

@section('content')
<section class="" id="submit-success">
    <div class="container">
        <div class="content">
            <img src="{{ asset('front') }}/img/submit-success.png" alt="">
            <div class="title">Your quiz is successfully submitted!</div>
            <div class="tagline">
                Thank you for participating in our quiz session.
            </div>
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
@endsection