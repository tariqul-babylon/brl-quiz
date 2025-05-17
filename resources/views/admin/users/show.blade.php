@extends('admin.layout.master')
@section('content')
    <div class="page-header">
        <div class="head">
            <h1 class="title">User Details</h1>
        </div>
    </div>

    <table class="table table-show">
        <tr>
            <td width="160">Name</td>
            <td width="30" class="text-center">:</td>
            <th>{{ $user->name }}</th>
        </tr>
        <tr>
            <td>Email</td>
            <td class="text-center">:</td>
            <th>{{ $user->email }}</th>
        </tr>
        <tr>
            <td>Employment Status</td>
            <td class="text-center">:</td>
            <th>{{ $user->status ?? 'N/A' }}</th> {{-- assuming 'status' is a field --}}
        </tr>

    </table>

    <div class="mt-4">
        <a href="" class="btn btn-outline-secondary">
            Back
        </a>
    </div>
@endsection
