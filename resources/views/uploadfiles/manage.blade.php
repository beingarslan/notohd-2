@extends('layouts/contentLayoutMaster')

@section('title', 'Images')

@section('vendor-style')
<!-- Vendor css files -->
<link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/wizard/bs-stepper.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/spinner/jquery.bootstrap-touchspin.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
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
                <div class="form-check form-check-inline">
                    <input class="form-check-input bulk_item" type="checkbox" id="inlineCheckbox1" value="{{$image->id}}">
                    <!-- <label class="form-check-label" for="inlineCheckbox1">Select for bulk action</label> -->
                </div>
                <div class="card ecommerce-card" id="image{{ ($image->id) }}">
                    <div class="item-img ms-1">
                        <a href="#{{url('app/ecommerce/details')}}">
                            <img src="{{$image->thumbnail}}" alt="img-placeholder" />
                        </a>
                    </div>
                    <div class="card-body">
                        <select class=" form-select select-sm" name="category_id" id="category_id{{$image->id}}">
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                            <option {{$image->category_id == $category->id ? 'selected' : '' }} value="{{$category->id}}">{{$category->title}}</option>
                            @endforeach
                        </select>

                        <!-- <div class="item-name">
                            <h6 class="mb-0"><a href="{{url('app/ecommerce/details')}}" class="text-body">Apple Watch Series 5</a></h6>
                            <span class="item-company">By <a href="#" class="company-name">Apple</a></span>
                        </div>
                        <span class="text-success mb-1">In Stock</span> -->
                        <div class="item-quantity">
                            <span class="quantity-title">Set Price:</span>
                            <div class="quantity-counter-wrapper">
                                <div class="input-group">
                                    <input type="text" class="quantity-counter price" id="price{{ $image->id }}" value="{{ ($image->price) }}" />
                                </div>
                            </div>
                        </div>
                        <input type="text" id="inputTag{{ $image->id }}" class="form-control inputTag" value="{{ ($image->tags) }}" data-role="tagsinput">
                        <!-- <span class="delivery-date text-muted">Delivery by, Wed Apr 25</span>
                        <span class="text-success">17% off 4 offers Available</span> -->
                    </div>
                    <div class="item-options text-center">

                        <button type="button" id="{{ ($image->id) }}" class="btn btn-light mt-1 remove-wishlist">
                            <i data-feather="x" class="align-middle me-25"></i>
                            <span class="remove{{ ($image->id) }}">Remove</span>
                        </button>
                        <button type="button" value="{{ ($image->id) }}" class="btn btn-primary btn-cart update">
                            <!-- <i data-feather="heart" class="align-middle me-25"></i> -->
                            <span class="text-truncate">Update</span>
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
                <!-- Filters -->
                <div class="card">
                    <div class="card-body">

                        <form action="" method="get">
                            <div class="price-details">
                                <h6 class="price-title">Filters</h6>
                                <!-- <div class="row mb-1">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label">Category</label>
                                        <select class="form-select select"></select>
                                    </div>
                                </div>
                            </div> -->
                                <!-- <div class="row mb-1">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-label">Price</label>
                                            <input type="text" class="form-control" id="filter-price" placeholder="Price" />
                                        </div>
                                    </div>
                                </div> -->
                                <div class="row mb-1">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-label">Items per Page</label>
                                            <input type="text" value="" class="form-control" id="filter-page" placeholder="Items per Page" />
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-primary w-100" id="apply-filter" >Apply Filter</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <label class="section-label form-label mb-1">Bulk actions</label>
                        <div class="coupons input-group input-group-merge">
                            <input type="text" class="form-control" placeholder="Price" id="bulk-price" aria-label="Coupons" aria-describedby="input-coupons" />
                            <a class="input-group-text text-primary ps-1" id="Apply-Bulk-action" href="javascript:void(0)">Apply</a>
                        </div>
                        <!-- <hr /> -->
                        <!-- <div class="price-details">
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
                        </div> -->
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
<script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
@endsection

@section('page-script')
<!-- Page js files -->
<script src="{{ asset(mix('js/scripts/forms/form-select2.js')) }}"></script>
<script src="{{ asset(mix('js/scripts/pages/app-ecommerce-checkout.js')) }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/typeahead.bundle.min.js"></script>
<script src="https://bootstrap-tagsinput.github.io/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
<script>
    // document ready
    $(document).ready(function() {
        $(".inputTag").tagsinput('items');
    });
    $(document).ready(function() {
        $('#Apply-Bulk-action').on('click', function() {
            if ($('#bulk-price').val() != '') {
                $(this).attr('disabled', true);
                $(this).text('Applying...');
                var items = [];
                $('.bulk_item').each(function() {
                    if ($(this).is(':checked')) {
                        items.push($(this).val());
                    }
                });
                console.log(items);
                $.ajax({
                    url: "{{ route('admin.images.update.bulk') }}",
                    type: "POST",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "ids": items,
                        "price": $('#bulk-price').val(),
                    },
                    success: function(data) {
                        console.log(data);
                        if (data.status == 'success') {
                            toastr.success(data.message);
                            setTimeout(function() {
                                location.reload();
                            }, 1000);
                        } else {
                            toastr.error(data.message);
                        }
                    }
                });

                $(this).attr('disabled', false);
                $(this).text('Apply');
            } else {
                toastr.error('Please enter price', 'Error', {
                    timeOut: 5000,
                });
            }
        });
    });

    $(document).ready(function() {
        $('#apply-filter').on('click', function() {
            console.log($('#filter-page').val());
            $price = $('#filter-price').val();
            $page = $('#filter-page').val();
            var url = window.location.href+'?price='+$price+'&per_page='+$page+'&page=1';
            window.location.href = url;
        });
    });
</script>
@endsection
