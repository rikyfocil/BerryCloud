<div class="row">
    <div class="breadcrumbs col-sm-12 col-md-6 col-md-offset-1">
        <a href="{{ route('home') }}">Home </a> 
        @if(isset($parent))
            @foreach ($parent->hierarchy() as $p)
                <i class="fa fa-caret-right" aria-hidden="true"></i> <a href="{{ route('file.show', $p->id) }}"> {{$p->name}} </a>
            @endforeach
        @endif
    </div>
    <div class="col-xs-6 col-sm-6 col-md-2">
        <button type="button" class="btn create-button pull-right" data-toggle="modal" data-target="#modal-upload">
            Upload File
        </button>
    </div>
    <div class="col-xs-6 col-sm-6 col-md-2">
        <button type="button" class="btn create-button" data-toggle="modal" data-target="#modal-folder">
            New Folder
        </button>
    </div>
</div>