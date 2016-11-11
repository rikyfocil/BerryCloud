$(document).ready(function(){
    Dropzone.options.myDropzone= {
        url: 'http://localhost:8000/file/upload',
        autoProcessQueue: false,
        uploadMultiple: false,
        maxFiles: 1,
        addRemoveLinks: true,
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
}
}
