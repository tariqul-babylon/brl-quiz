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