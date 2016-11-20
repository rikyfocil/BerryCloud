<div aria-labelledby="ShareFile" tabindex="-1" role="dialog" id="modal-share" class="modal fade">
    <div role="document" class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('file.share.create', $file->id) }}" enctype="multipart/form-data" method="POST">
                <div class="form-group form-name">
                    <label for="user">Share with (Email or group name):</label>
                    <input type="email" name="user" id="share-email" class="col-xs-12 form-control">
                </div>
                <div class="form-group form-name">
                    <label for="idPermissionType">Sharing type:</label>
                    {{Form::select('idPermissionType', $sharing_types, null, ['class'=>'col-xs-12 form-control'])}}
                </div>
                <div class="form-group form-name">
                    <label for="dueDate">Due date (optional):</label>
                    <input type="text" name="dueDate" id="dueDate" class="col-xs-12 form-control datepicker">
                </div>
                <div class="form-group form-name">
                    <label>&nbsp;</label>
                    <button class="col-xs-12 form-control btn btn-success">Share!</button> 
                    <img src="{{asset('img/Preloader_3.gif')}}" width="64px" height="64px" hidden>
                </div>
                {{ Form::token() }}
            </form>
        </div>
    </div>
</div>

