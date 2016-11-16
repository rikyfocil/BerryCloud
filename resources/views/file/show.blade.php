@extends('layouts.main')

@push('css')
    <link href="{{ asset('css/jquery-ui.css') }}" rel="stylesheet">
    <link href="{{ elixir('css/basic.css') }}" rel="stylesheet">
@endpush

@push('scripts')
    <script src="{{ asset('/js/share.js') }}"></script>
@endpush

@section('content')


<div class="container">
    <div class="row text-center">
        <i class="fa fa-file center-block img-responsive" aria-hidden="true" id="icon-file-show"></i>
    </div>
    <div class="row">
    <div class="col-xs-10 col-xs-offset-1">
        <h3 class="text-center">{{$file->name}}</h3>
        <p id="file-data" data-id="{{$file->id}}" hidden>
        <p class="text-center"> The current version was uploaded at {{ $versions[0]->created_at }} </p>
    </div>
    </div>
    <div class="row">
        @if($file->isOwner())
            <div class="col-xs-12 col-sm-4">
                {!! Helper::createButtonAction('GET', ['file.download',$file->id], "Download", "") !!}
            </div>
            <div class="col-xs-12 col-sm-4">
                <button type="button" class="btn action-button pull-right" data-toggle="modal" data-target="#modal-new-version">
                    Upload File
                </button>
            </div>
            @if($file->publicRead)
                <div class="col-xs-12 col-sm-4">
                    {!! Helper::createButtonAction('POST', ['file.unpublish', $file->id], "Make private", "") !!}
                </div>
            @else
                <div class="col-xs-12 col-sm-4">
                    {!! Helper::createButtonAction('POST', ['file.publish', $file->id], "Make public", "") !!}
                </div>
            @endif
            <div class="col-xs-12 col-sm-4">
                {!! Helper::createButtonAction('DELETE', ['file.delete',$file->id], "Move to trash", "") !!}
            </div>
            <div class="col-xs-12 col-sm-4">
                {!! Helper::createButtonAction('DELETE', ['file.delete.hard',$file->id], "Delete permanently", "") !!}
            </div>
            <div class="col-xs-12 col-sm-4">
                <button type="button" class="btn action-button pull-right" data-toggle="modal" data-target="#modal-share">
                    Share With Someone
                </button>
            </div>
        @else
        <div class="col-xs-12">
            {!! Helper::createButtonAction('GET', ['file.download',$file->id], "Download", "") !!}
        </div>
        @endif
</div>


<div class="row">
    @include('includes.version-table')
</div>
@if($file->isOwner())
    <div class="row">
        @include('includes.shared-table')
    </div>
    @include('includes.modal-share-file')
@endif



{{Form::open([
'method' => 'DELETE',
'route' => ['file.share.delete', $file->id, ':ID'],
'id' => 'share-form-del'
])}}
{{Form::close()}}


@include('includes.modal-new-version')

@endsection

@push('scripts')
    <script src="{{ asset('/js/dropzone.js') }}"></script>
    <script>
        Dropzone.options.myDropzone= {
            url: '{{ route('uploadVersion',[$file->id])}}',
            autoProcessQueue: false,
            uploadMultiple: false,
            maxFiles: 1,
            addRemoveLinks: true,
            createImageThumbnails: false,
            dictResponseError: "Error while uploading the file",
            init: function() {
                dzClosure = this; // Makes sure that 'this' is understood inside the functions below.

                // for Dropzone to process the queue (instead of default form behavior):
                document.getElementById("submit-all").addEventListener("click", function(e) {
                    // Make sure that the form isn't actually being sent.
                    e.preventDefault();
                    e.stopPropagation();
                    dzClosure.processQueue();
                });

                this.on("complete", function(file) {
                    location.reload(true);
                    this.removeAllFiles();
                });
                this.on("sending", function (file, xhr, formData) {
                    formData.append("_token", "{{ csrf_token() }}");
                    @if(isset($parent))
                    formData.append("parent", {{$parent->id}});
                    @endif
                });
            }
        }
    </script>
@endpush
