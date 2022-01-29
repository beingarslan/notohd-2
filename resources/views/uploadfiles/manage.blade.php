@extends('layouts/contentLayoutMaster')

@section('title', 'Gallery')

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
        <div class="col-md-3 col-xl-3">
            <div class="card mb-3">
                <img class="card-img-top lazy" src="{{$image->thumbnail}}" alt="Card image cap" />
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
<!-- cdnjs -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.lazyload/1.9.1/jquery.lazyload.min.js" integrity="sha512-jNDtFf7qgU0eH/+Z42FG4fw3w7DM/9zbgNPe3wfJlCylVDTT3IgKW5r92Vy9IHa6U50vyMz5gRByIu4YIXFtaQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@endsection
