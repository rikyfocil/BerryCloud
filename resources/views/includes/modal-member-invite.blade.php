<div aria-labelledby="ShareFile" tabindex="-1" role="dialog" id="modal-member-add" class="modal fade">
    <div role="document" class="modal-dialog">
        <div class="modal-content">
            <form action="{{route('groups.member.add', [$group->id])}}" method="POST">
                <div class="form-group form-name">
                    <label for="user">Adding (Email):</label>
                    <input type="email" name="email" id="email" class="col-xs-12 form-control">
                </div>
                {{ Form::token() }}
                <button type="submit" id="submit-folder" class="btn btn-large">Add</button>
            </form>
        </div>
    </div>
</div>

