<div aria-labelledby="NewFolder" tabindex="-1" role="dialog" id="modal-folder" class="modal fade">
    <div role="document" class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('folder.create') }}" enctype="multipart/form-data" method="POST">
                <div class="form-group form-name">
                    <label for="name">Folder Name: </label>
                    <input type="text" class="form-control" value="" name="name" placeholder="Name">
                </div>
                @if(isset($parent))
                    <input type="hidden" class="text" value="{{$parent->id}}" name="parent">
                @endif
                    <button type="submit" id="submit-folder" class="btn btn-large">Upload</button>
                {{ Form::token() }}
            </form>
        </div>
    </div>
</div>

