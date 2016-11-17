<div aria-labelledby="ModalUpload" tabindex="-1" role="dialog" id="modal-new-version" class="modal fade">
    <div role="document" class="modal-dialog">
        <div class="modal-content">
            <form action="" enctype="multipart/form-data" method="POST" id="mobileUploadForm">
                <div class="dropzone text-center" id="myDropzone"></div>
                <div class="col-md-2 col-md-offset-5">
                    <button type="submit" id="submit-all" class="btn btn-large">Upload</button>
                </div>
                {{ Form::token() }}
            </form>
        </div>
    </div>
</div>

