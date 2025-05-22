@extends('front.layouts.app')
@push('css')
<style>
   

    .container.custom {
        max-width: 800px;
        margin: 0 auto;
    }

    .form-card {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        padding: 24px;
    }

    .form-header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 24px;
        padding-bottom: 16px;
        border-bottom: 1px solid #f1f3f4;
    }

    .form-header .material-symbols-outlined {
        color: var(--primary);
        font-size: 2rem;
    }

    .form-title {
        font-size: 1.5rem;
        color: var(--dark);
        font-weight: 500;
    }

    

    .checkbox-group {
        display: flex;
        align-items: center;
        gap: 5px;
        margin-top:8px;
    }

    .checkbox-group input {
        width: auto;
        padding: 0;
    }
   
    .form-control:focus{
        box-shadow: none;
    }

</style>
@endpush
@section('content')

    <div class="container custom mt-4">
        <div class="form-card">
            <div class="form-header">
                <span class="material-symbols-outlined text-primary">quiz</span>
                <h1 class="form-title">Create New Exam</h1>
            </div>

            <form>
                <div class="row g-3 py-3">
                    <!-- Basic Information -->
                    <div class="col-12">
                        <label for="">Exam Title</label>
                        <input type="text" class="form-control">
                    </div>

                    <div class="col-12">
                        <label for="">Tagline/Description</label>
                        <input type="text" class="form-control">
                    </div>

                    <div class="col-md-6    ">
                        <label >Mark per Question</label>
                        <input type="number" class="form-control" min="0" step=".5">
                    </div>

                    <div class="col-md-6">
                        <label for="negative-mark">Negative Mark per Wrong Answer</label>
                            <input type="number" class="form-control" step=".25" min="0" value="0">
                    </div>

                    <div class="col-md-6">
                        <label for="negative-mark">Duration</label>
                        <div class="input-group">
                            <input type="number" class="form-control" step="1" min="0">
                            <span class="input-group-text">Hours</span>
                            <input type="number" class="form-control" step="1" min="0" >
                            <span class="input-group-text">Minutes</span>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="">Collect Student ID (Optional)</label>
                        <input type="text" class="form-control" placeholder="e.g. ID No or Reg. No">
                    </div>

                    <div class="col-12">
                        <b >Exam Settings</b>
                        <div class="checkbox-group">
                            <input type="checkbox" class="me-1" id="random-questions" checked>
                            <label for="random-questions">Randomize Questions</label>
                        </div>
                        <div class="checkbox-group">
                            <input type="checkbox" class="me-1" id="random-options" checked>
                            <label for="random-options">Randomize Options</label>
                        </div>
                        <div class="checkbox-group">
                            <input type="checkbox"  class="me-1" id="login-required">
                            <label for="login-required">Require Student Login</label>
                        </div>
                        <div class="checkbox-group">
                            <input type="checkbox"  class="me-1" id="show-results" checked>
                            <label for="show-results">Show Results to Students</label>
                        </div>
                    </div>
                </div>

                <div class="d-flex  justify-content-between border-top pt-3">
                    <button type="button" class="btn btn-outline-secondary d-none d-md-block">
                        Back to Exam List
                    </button>
                    <button type="submit" class="btn btn-primary">
                        Create Exam
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection