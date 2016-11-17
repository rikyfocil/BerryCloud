<div aria-labelledby="ShareFile" tabindex="-1" role="dialog" id="modal-create" class="modal fade">
    <div role="document" class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('groups.store') }}" method="POST">
                <div class="form-group form-name">
                    <label for="name">Name:</label>
                    <input type="name" name="name" id="name" class="col-xs-12 form-control">
                </div>
                {{ Form::token() }}
                <button type="submit" id="submit-folder" class="btn btn-large">Create</button>
               
            </form>
        </div>
    </div>
</div>

