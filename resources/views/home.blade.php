@extends('layouts.main')

@push('css')
    <link href="{{ elixir('css/basic.css') }}" rel="stylesheet">
@endpush

@push('scripts')
    <script src="{{ asset('/js/share.js') }}"></script>
@endpush

@section('content')


@include('includes.breadcrumb')


@if (count($files) != 0)
    <div class="col-sm-12 col-md-10 col-md-offset-1">
        @include('layouts.files')
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
@include('includes.modal-folder')
@if(isset($parent))
    @include('includes.modal-share-file')
@endif
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
                    @if(isset($parent))
                    formData.append("parent", {{$parent->id}});
                    @endif
                });
            }
        }
    </script>
@endpush
