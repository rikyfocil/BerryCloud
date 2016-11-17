@extends('layouts.main')

@push('css')
    <link href="{{ elixir('css/basic.css') }}" rel="stylesheet">
@endpush

@push('scripts')
    <script src="#"></script>
@endpush

@section('content')


@if (count($groups) != 0)
    <div class="col-sm-12 col-md-10 col-md-offset-1">
        @include('layouts.groups')
    </div>

@else
    <div class="jumbotron text-center" id="no-files">
        <h1>Your have no groups yet.</h1>
        <h2>You can start one <br>
            <button type="button" class="btn btn-primary" id="register-button" data-toggle="modal" data-target="#modal-create">
                here
            </button>
        </h2>
    </div>
@endif

@include('includes.modal-group-create')
@endsection
