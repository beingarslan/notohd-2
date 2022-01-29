@extends('layouts/contentLayoutMaster')

@section('title', 'Images')

@section('vendor-style')
<!-- Vendor css files -->
<link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/wizard/bs-stepper.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/spinner/jquery.bootstrap-touchspin.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
@endsection

@section('page-style')
<!-- Page css files -->
<link rel="stylesheet" href="{{ asset(mix('css/base/pages/app-ecommerce.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-pickadate.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-wizard.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-number-input.css')) }}">
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
        padding: 2px 2px;
        color: #555;
        vertical-align: middle;
        border-radius: 4px;
        max-width: 100%;
        /* line-height: 22px; */
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

<a href="/admin/images/upload" class="btn btn-primary">
    Add New Image
</a>

<div class="bs-stepper checkout-tab-steps">

    <div class="bs-stepper-content">
        <div id="place-order" class="list-view product-checkout">
            <!-- Checkout Place Order Left starts -->
            <div class="checkout-items">
                @foreach($images as $image)
                <div class="card ecommerce-card" id="image{{ ($image->id) }}">
                    <div class="item-img">
                        <a href="#{{url('app/ecommerce/details')}}">
                            <img src="{{$image->thumbnail}}" alt="img-placeholder" />
                        </a>
                    </div>
                    <div class="card-body">
                        <!-- <div class="item-name">
                            <h6 class="mb-0"><a href="{{url('app/ecommerce/details')}}" class="text-body">Apple Watch Series 5</a></h6>
                            <span class="item-company">By <a href="#" class="company-name">Apple</a></span>
                        </div>
                        <span class="text-success mb-1">In Stock</span> -->
                        <div class="item-quantity">
                            <span class="quantity-title">Set Price:</span>
                            <div class="quantity-counter-wrapper">
                                <div class="input-group">
                                    <input type="text" class="quantity-counter" value="{{ ($image->price) }}" />
                                </div>
                            </div>
                        </div>
                        <input type="text" id="inputTag" class="form-control inputTag" value="{{ ($image->tags) }}" data-role="tagsinput">
                        <!-- <span class="delivery-date text-muted">Delivery by, Wed Apr 25</span>
                        <span class="text-success">17% off 4 offers Available</span> -->
                    </div>
                    <div class="item-options text-center">
                        <button type="button" id="{{ ($image->id) }}" class="btn btn-light mt-1 remove-wishlist">
                            <i data-feather="x" class="align-middle me-25"></i>
                            <span class="remove{{ ($image->id) }}">Remove</span>
                        </button>
                        <button type="button" class="btn btn-primary btn-cart move-cart">
                            <i data-feather="heart" class="align-middle me-25"></i>
                            <span class="text-truncate">Add to Wishlist</span>
                        </button>
                    </div>
                </div>
                @endforeach
                <div class="mb-3">
                {{ $images->links() }}
                </div>
            </div>
            <!-- Checkout Place Order Left ends -->

            @if(count($images) > 0)
            <!-- Checkout Place Order Right starts -->
            <div class="checkout-options">
                <div class="card">
                    <div class="card-body">
                        <label class="section-label form-label mb-1">Options</label>
                        <div class="coupons input-group input-group-merge">
                            <input type="text" class="form-control" placeholder="Coupons" aria-label="Coupons" aria-describedby="input-coupons" />
                            <span class="input-group-text text-primary ps-1" id="input-coupons">Apply</span>
                        </div>
                        <hr />
                        <div class="price-details">
                            <h6 class="price-title">Price Details</h6>
                            <ul class="list-unstyled">
                                <li class="price-detail">
                                    <div class="detail-title">Total MRP</div>
                                    <div class="detail-amt">$598</div>
                                </li>
                                <li class="price-detail">
                                    <div class="detail-title">Bag Discount</div>
                                    <div class="detail-amt discount-amt text-success">-25$</div>
                                </li>
                                <li class="price-detail">
                                    <div class="detail-title">Estimated Tax</div>
                                    <div class="detail-amt">$1.3</div>
                                </li>
                                <li class="price-detail">
                                    <div class="detail-title">EMI Eligibility</div>
                                    <a href="#" class="detail-amt text-primary">Details</a>
                                </li>
                                <li class="price-detail">
                                    <div class="detail-title">Delivery Charges</div>
                                    <div class="detail-amt discount-amt text-success">Free</div>
                                </li>
                            </ul>
                            <hr />
                            <ul class="list-unstyled">
                                <li class="price-detail">
                                    <div class="detail-title detail-total">Total</div>
                                    <div class="detail-amt fw-bolder">$574</div>
                                </li>
                            </ul>
                            <button type="button" class="btn btn-primary w-100 btn-next place-order">Place Order</button>
                        </div>
                    </div>
                </div>
                <!-- Checkout Place Order Right ends -->
            </div>
            @endif
        </div>

    </div>
</div>
@endsection

@section('vendor-script')
<!-- Vendor js files -->
<script src="{{ asset(mix('vendors/js/forms/wizard/bs-stepper.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/forms/spinner/jquery.bootstrap-touchspin.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
@endsection

@section('page-script')
<!-- Page js files -->
<script src="{{ asset(mix('js/scripts/pages/app-ecommerce-checkout.js')) }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/typeahead.bundle.min.js"></script>
<script src="https://bootstrap-tagsinput.github.io/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
<script>
    // document ready
    $(document).ready(function() {
        $(".inputTag").tagsinput('items');
    });
</script>
@endsection
