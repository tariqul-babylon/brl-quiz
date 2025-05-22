@extends('front.layouts.app')
@push('css')
    
@endpush
@section('content')
<section class="" id="submit-success">
    <div class="container">
        <div class="content">
            <svg width="120" height="120" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="12" cy="12" r="10" fill="#FEE2E2"/>
                <path d="M12 7V13" stroke="#DC2626" stroke-width="2" stroke-linecap="round"/>
                <circle cx="12" cy="16" r="1" fill="#DC2626"/>
                <path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" stroke="#FCA5A5" stroke-width="1.5" stroke-dasharray="2 2"/>
              </svg>

            <div class="title" style="font-size: 24px; color: #DC2626;">{{$message}}</div>
            
            <div class="buttons mt-4">
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
                window.history.replaceState(null, null, window.location.href);
            }
            document.querySelectorAll('form input, form textarea, form select').forEach(el => el.value = '');
        };
    </script>
@endpush