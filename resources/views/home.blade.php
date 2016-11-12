@extends('layouts.main')

@push('css')
    <link href="{{ elixir('css/basic.css') }}" rel="stylesheet">
@endpush

@section('content')

@if (count($files) != 0)
    <div class="col-sm-12 col-md-10 col-md-offset-1" id="file-navbar">
        <!-- <a href="{{route('uploadGet')}}" class="btn btn&#45;success" id="new&#45;file&#45;button">Nuevo</a> -->
        <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#modal-upload">
            Nuevo
        </button>
    </div>
    <div class="col-sm-12 col-md-10 col-md-offset-1">
        <table class="table table-hover">
            <tr>
                <th>File name</th>
                <th class="text-right hidden-xs">Last version modified</th>
                <th class="text-right">Options</th>
            </tr>
        @foreach ($files as $file)
            <tr>
                <td><a href="{{route('file.show', $file->id)}}">{{$file->name}}</a></td>
                <td class="text-right hidden-xs">
                    {{ $file->currentVersion()->updated_at }}
                </td>
                <td>
                <div class="btn-group visible-xs-* hidden-xs hidden-sm pull-right" role="group" aria-label="actionGroup">
                    {!! Helper::createButtonWithIcon('GET', ['file.download',$file->id], "Download", "btn btn-default", "glyphicon-download-alt") !!}
                    {!! Helper::createButtonWithIcon('DELETE', ['file.delete', $file->id], "Delete", "btn btn-default", "glyphicon-trash") !!}
                </div>
                <div class="dropdown pull-right hidden-md hidden-lg">
                    <button class="btn btn-default dropdown-toggle" type="button" id="mobileActionId" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        Actions
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-right mobileActionId" aria-labelledby="mobileActionId">
                        <li>{!! Helper::createButton('GET', ['file.download',$file->id], "Download", "") !!}</li>
                        <li>{!! Helper::createButton('DELETE', ['file.delete', $file->id], "Delete", "") !!}</li>
                    </ul>
                </div>
                </td>
            </tr>

        @endforeach
        </table>
    </div>

@else
    <div class="jumbotron text-center" id="no-files">
        <h1>Your have no files yet.</h1>
        <h2>Come fly with us and upload a file <br>
			<button type="button" class="btn btn-primary" id="register-button" data-toggle="modal" data-target="#modal-upload">
	            here
     	   	</button>
		</h2>
    </div>
@endif


@include('includes.modal-upload')


@endsection

@push('scripts')
    <script src="{{ asset('/js/dropzone.js') }}"></script>
    <script>
        Dropzone.options.myDropzone= {
            url: '{{ route('upload')}}',
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
                });
            }
        }
    </script>
@endpush
