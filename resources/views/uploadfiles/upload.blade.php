@extends('layouts/contentLayoutMaster')

@section('title', 'File Uploader')

@section('vendor-style')
<!-- vendor css files -->
<link rel="stylesheet" href="{{ asset(mix('vendors/css/file-uploaders/dropzone.min.css')) }}">
@endsection
@section('page-style')
<!-- Page css files -->
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-file-uploader.css')) }}">
@endsection

@section('content')
<!-- Dropzone section start -->
<section id="dropzone-examples">



    <!-- multi file upload starts -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Multiple Files Upload</h4>
                </div>
                <div class="card-body">
                    <!-- <p class="card-text">
                        By default, dropzone is a multiple file uploader. User can either click on the dropzone area and select
                        multiple files or just drop all selected files in the dropzone area. This example is the most basic setup
                        for dropzone.
                    </p> -->
                    <form action="{{route('admin.images.store')}}" method="POST" class="dropzone dropzone-area" id="dpz-multiple-files" enctype="multipart/form-data">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- multi file upload ends -->

</section>
<!-- Dropzone section end -->
@endsection

@section('vendor-script')
<!-- vendor files -->
<script src="{{ asset(mix('vendors/js/file-uploaders/dropzone.min.js')) }}"></script>
@endsection
@section('page-script')
<!-- Page js files -->
<script type="text/javascript">
    $(document).ready(function() {
        Dropzone.options.dropzone = {
            maxFilesize: 12,
            url: "{!! route('admin.images.store') !!}",

            renameFile: function(file) {
                var dt = new Date();
                var time = dt.getTime();
                return time + file.name;
            },
            acceptedFiles: ".jpeg,.jpg,.png",
            addRemoveLinks: true,
            timeout: 50000,
            removedfile: function(file) {
                var name = file.upload.filename;
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    type: 'POST',
                    url: '{!! route("admin.images.remove") !!}',
                    data: {
                        filename: name
                    },
                    success: function(data) {
                        console.log("File has been successfully removed!!");
                    },
                    error: function(e) {
                        toastr.error("error", 'file not removed');

                        console.log(e);
                    }
                });
                var fileRef;
                return (fileRef = file.previewElement) != null ?
                    fileRef.parentNode.removeChild(file.previewElement) : void 0;
            },

            success: function(file, response) {
                toastr.success(file, response)

                console.log(response);
            },
            error: function(file, response) {
                // toast error

                toastr.error(response, file)

                return false;
            }
        };
    })
</script>
@endsection
