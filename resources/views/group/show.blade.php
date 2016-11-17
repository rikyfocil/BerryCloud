@extends('layouts.main')

@push('css')
    <link href="{{ elixir('css/basic.css') }}" rel="stylesheet">
@endpush

@push('scripts')
    <script src="{{ asset('/js/group.js') }}"></script>
@endpush

@section('content')

<div class="container">
    <div class="row text-center">
        <i class="fa fa-groups center-block img-responsive" aria-hidden="true" id="icon-file-show"></i>
    </div>
    <div class="row">
    <div class="col-xs-10 col-xs-offset-1">
        <h3 class="text-center">{{$group->name}}</h3>
        <p id="group-data" data-id="{{$group->id}}" hidden></p>
    </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-5 col-xs-offset-10 col-sm-offset-6">

            <div class="col-xs-6">
             {!! Helper::createButtonAction('DELETE', ['groups.destroy',$group->id], "Delete", "") !!}
            </div>
            <div class="col-xs-6">
                <button type="button" class="btn action-button pull-right" data-toggle="modal" data-target="#modal-member-add">
                    Add member
                </button>
            </div>
        </div>

    </div>
</div>

<div class="row">
    <div class="col-sm-10 col-sm-offset-1" id="shared-table">
        
        <table class="table table-hover">
            <thead>
            <tr>
            <th >Member</th>
            <th class="text-right">Options</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($members as $member)
                 <tr>
                    <td><i class="fa fa-id-badge"></i> {{$member->user()->first()->email}} </td>
                    <td>
                        <div class="btn-group pull-right" role="group" aria-label="actionGroup">
                              {!! Helper::createButtonWithIcon('DELETE', ['groups.member.delete', $group->id, $member->id], "Delete", "btn btn-default", "glyphicon-trash") !!}
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@include('includes.modal-member-invite')

@endsection