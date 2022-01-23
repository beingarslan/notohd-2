@extends('layouts/contentLayoutMaster')


@section('vendor-style')
<link rel="stylesheet" href="{{asset(mix('vendors/css/charts/apexcharts.css'))}}">
@endsection
@section('page-style')
<link rel="stylesheet" href="{{asset(mix('css/base/pages/app-chat-list.css'))}}">
@endsection

@section('content')
<!-- Card Advance -->

<div class="row match-height">
  <!-- Congratulations Card -->
  <div class="col-12 col-md-12 col-lg-12">
    <div class="card card-congratulations">
      <div class="card-body text-center">
        <img
          src="{{asset('images/elements/decore-left.png')}}"
          class="congratulations-img-left"
          alt="card-img-left"
        />
        <img
          src="{{asset('images/elements/decore-right.png')}}"
          class="congratulations-img-right"
          alt="card-img-right"
        />
        <div class="avatar avatar-xl bg-primary shadow">
          <div class="avatar-content">
            <i data-feather="award" class="font-large-1"></i>
          </div>
        </div>
        <div class="text-center">
          <h1 class="mb-1 text-white">Welcome {{Auth::user()->name}},</h1>
          <!-- <p class="card-text m-auto w-75">
            You have done <strong>57.6%</strong> more sales today. Check your new badge in your profile.
          </p> -->
        </div>
      </div>
    </div>
  </div>
  <!--/ Congratulations Card -->


</div>


<!--/ Card Advance -->
@endsection

@section('vendor-script')
<script src="{{asset(mix('vendors/js/charts/apexcharts.min.js'))}}"></script>
@endsection
@section('page-script')
  <script src="{{ asset(mix('js/scripts/cards/card-advance.js')) }}"></script>
@endsection
