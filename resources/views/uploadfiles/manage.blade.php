@extends('layouts/contentLayoutMaster')

@section('title', 'Gallery')

@section('vendor-style')
<link rel="stylesheet" type="text/css" href="https://bootstrap-tagsinput.github.io/bootstrap-tagsinput/dist/bootstrap-tagsinput.css">

<style>
    .bootstrap-tagsinput .tag {
        color: black;
        background-color: white;
        border-radius: 5%;
        border: 1px solid blue;
        /* padding: 1px; */
        margin: 2px;
    }

    .bootstrap-tagsinput {
        background-color: #fff;
        border: 1px solid #ccc;
        box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
        display: block;
        padding: 10px 6px;
        color: #555;
        vertical-align: middle;
        border-radius: 4px;
        max-width: 100%;
        line-height: 22px;
        cursor: text;
    }

    .bootstrap-tagsinput input {
        border: none;
        box-shadow: none;
        outline: none;
        background-color: transparent;
        padding: 0 6px;
        margin: 0;
        width: auto;
        max-width: inherit;
    }

    .bootstrap-tagsinput .tag [data-role="remove"] {
        border-left: 1px solid #ccc;
        /* border: 1px  solid blue; */
        margin-left: 3px;
        cursor: pointer;
        font-size: 17px;
        color: red;
    }
</style>
@endsection
@section('content')

<a href="/admin/images/upload" class="btn btn-primary">Add images</a>

<!-- <form action="{{route('upload')}}" method="post"enctype="multipart/form-data">
    @csrf
    <input type="file" name="image" id="">
    <button type="submit">Save</button>
</form> -->

<!-- Images -->
<section id="card-images">
    <h5 class="mt-3 mb-2">Images</h5>
    <div class="row">
        @foreach($images as $image)
        <div class="col-lg-4 col-md-6 col-12">
            <div class="card card-apply-job">
                <img class="card-img-top lazy" src="{{$image->thumbnail}}" alt="Card image cap" />

                <div class="card-body">


                    <div class="d-grid">
                        <div class="form-group mb-1">
                            <label for="">Tags Input</label>
                            <input type="text" id="inputTag" class="form-control inputTag" value="Amsterdam,Washington,Sydney,Beijing,Cairo" data-role="tagsinput">
                        </div>
                    </div>
                    <div class="d-grid">
                        <button type="button" class="btn btn-primary">Apply For This Job</button>
                    </div>
                </div>
            </div>
        </div>

        @endforeach
        <div class="mb-3">
            {{ $images->links() }}
        </div>


    </div>
</section>
<!--/ Images -->

@endsection

@section('page-script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/typeahead.bundle.min.js"></script>
<script src="https://bootstrap-tagsinput.github.io/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
<!-- cdnjs -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.lazyload/1.9.1/jquery.lazyload.min.js" integrity="sha512-jNDtFf7qgU0eH/+Z42FG4fw3w7DM/9zbgNPe3wfJlCylVDTT3IgKW5r92Vy9IHa6U50vyMz5gRByIu4YIXFtaQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
    // document ready
    $(document).ready(function() {
        $(".inputTag").tagsinput('items');
    });
</script>
@endsection
