@extends('front.layouts.app')
@push('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css">
    <style>
        .desc-cell {
            word-wrap: break-word;
            /* Wrap long words to the next line */
            word-break: break-all;
            /* Break long strings like URLs */
            overflow-wrap: break-word;
            /* For compatibility */
        }
    </style>
@endpush

@section('content')
    <div class="container mt-4 mb-5">
        @livewire('list.activity')
    </div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endpush
