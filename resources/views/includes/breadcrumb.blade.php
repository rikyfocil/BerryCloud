<div class="row">
    <div class="breadcrumbs col-sm-12 col-md-4 col-md-offset-1">
        @if( Route::current()->getUri() == 'shared')
            <a href="{{ route('shared') }}">Shared  </a> 
        @elseif( Route::current()->getUri() == 'trash')
            <a href="{{ route('trash') }}">Trash </a> 
        @else
            <a href="{{ route('home') }}">Home </a> 
        @endif
        @if(isset($parent))
            @foreach ($parent->hierarchy() as $p)
                <i class="fa fa-caret-right" aria-hidden="true"></i> <a href="{{ route('file.show', $p->id) }}"> {{$p->name}} </a>
            @endforeach
        @endif
    </div>
    @if( Route::current()->getUri() != 'shared' || Route::current()->getUri() != 'trash')
        @if(isset($parent))
            <div class="col-xs-6 col-sm-6 col-md-2">
                <button type="button" class="btn action-button pull-right" data-toggle="modal" data-target="#modal-share">
                    Share With Someone
                </button>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-2">
                <button type="button" class="btn action-button pull-right" data-toggle="modal" data-target="#modal-upload">
                    Upload File
                </button>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-2">
                <button type="button" class="btn action-button" data-toggle="modal" data-target="#modal-folder">
                    New Folder
                </button>
            </div>
        @else
            <div class="col-xs-6 col-sm-6 col-md-2 col-md-offset-2">
                <button type="button" class="btn action-button pull-right" data-toggle="modal" data-target="#modal-upload">
                    Upload File
                </button>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-2">
                <button type="button" class="btn action-button" data-toggle="modal" data-target="#modal-folder">
                    New Folder
                </button>
            </div>
        @endif
    @endif
</div>
