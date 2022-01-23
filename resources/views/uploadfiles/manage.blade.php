@extends('layouts/contentLayoutMaster')

@section('title', 'Basic Card')

@section('content')

<a href="/admin/images/upload" class="btn btn-primary">Add images</a>


<!-- Images -->
<section id="card-images">
  <h5 class="mt-3 mb-2">Images</h5>
  <div class="row">
    @for($i=1; $i<=6; $i++)
    <div class="col-md-3 col-xl-3">
      <div class="card mb-3">
        <img class="card-img-top" src="{{asset('images/slider/06.jpg')}}" alt="Card image cap" />
        <!-- <div class="card-body">
          <h4 class="card-title">Card title</h4>
          <p class="card-text">
            This is a wider card with supporting text below as a natural lead-in to additional content. This content is
            a little bit longer.
          </p>
          <p class="card-text">
            <small class="text-muted">Last updated 3 mins ago</small>
          </p>
        </div> -->
      </div>
    </div>
    @endfor

  </div>
</section>
<!--/ Images -->

@endsection
