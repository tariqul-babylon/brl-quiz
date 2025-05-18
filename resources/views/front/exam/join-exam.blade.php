@extends('front.layouts.app')

@section('content')
<section class="login-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-8">
                <div class="login-card">
                    <div class="login-header">
                        <h2>Join Exam</h2>
                    </div>

                    <form class="signup-form" action="{{route('front.join-exam-submit')}}" method="POST">
                        @csrf
                        <div class="form-group">
                            <div class="input-with-icon password">
                                <span class="material-symbols-outlined input-icon">lock</span>
                                <input type="text" name="exam_code" class="@err('exam_code') form-control  " placeholder="Exam Code" >
                            </div>
                            @errtext('exam_code')
                        </div>
                        <button type="submit" class="btn-login">Join Exam</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
