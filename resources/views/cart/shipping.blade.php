@extends('layouts.master')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="{{ asset('css/select2-bootstrap.min.css') }}" rel="stylesheet" />
<style>
    .services-wrapper table {
        background: #FFF;
    }

    .select2-container--bootstrap .select2-selection--single {
        border-radius: 4px;
        padding: .65rem 1.4rem;
    }

    .select2-container .select2-selection--single {
        //height: fit-content;
        border-radius: 0px;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid #ced4da;
    }

    .select2-results__options {
        max-height: 300px;
        overflow: scroll;
    }

    .services-wrapper span {
        font-size: 13px;
    }
</style>
@endpush

@section('title', 'menu items')

@section('content')

<main>
    <article>
        <div class="container">

            @include('partials._flash')

            <div class="services-wrapper">
                <h3>Delivery Information</h3>
                <div class="row">
                    <div class="col-lg-8 col-md-8">
                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        <form id='order_form' method="POST" action="{{ route('cart.place.order') }}">
                            <div class="billinginformation-wrapper">
                                <div class="billing-information">

                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label>First Name</label>
                                                <input type="text" class="form-control" name="first_name" value="{{ $user ? $user->first_name : old('first_name') }}" required placeholder="First Name">
                                                <input type="hidden" name="user_id" value="{{ $user ? $user->id : '' }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label>Last Name</label>
                                                <input type="text" class="form-control" name="last_name" value="{{ $user ? $user->last_name : old('last_name') }}" required placeholder="Last Name">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                            <div class="form-group">
                                                <label>Phone Number</label>
                                                <input type="number" class="form-control" name="phone" value="{{ $user ? $user->telephone : old('phone') }}" minlength="11" maxlength="11" required placeholder="Phone Number">
                                                <small class="text-muted"><em>e.g 07051234566</em></small>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                            <div class="form-group">
                                                <label>Email</label>
                                                <input type="email" class="form-control" name="email" value="{{ $user ? $user->email : old('email') }}" required placeholder="Email">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <div class="form-group">
                                                <label>Delivery Address</label>
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="addresstype" value="home" {{ empty($shipping) ? "checked" : ($shipping['type'] == 'home' ? "checked" : "") }}>
                                                        <label class="form-check-label" for="inlineRadio1">Home Address</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="addresstype" value="office" {{ empty($shipping) ? "checked" : ($shipping['type'] == 'office' ? "checked" : "") }}>
                                                        <label class="form-check-label" for="inlineRadio2">Office Address</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="addresstype" value="other">
                                                        <label class="form-check-label" for="inlineRadio3">Other Address</label>
                                                    </div>
                                                </div>
                                                <input type="text" class="form-control" name="address" required placeholder="Address">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                            <div class="form-group">
                                                <label>State</label>
                                                <select name="state" class="form-control select2" id="states" required style="margin-top:0px;">
                                                    <option value="">Select State</option>
                                                    @foreach (get_states() as $state_id => $state)
                                                    <option value="{{ $state_id }}">{{ $state }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                            <div class="form-group">
                                                <label>City</label>
                                                <select name="city" class="form-control select2" id="areas" required style="margin-top:0px;">
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    @csrf
                                    <div class="mt-30">
                                        <h6>Payment Option</h6>
                                        <div>
                                            {{-- <div class="custom-control custom-radio">
                                                <input type="radio" class="custom-control-input" id="customRadio" name="cusRadio">
                                                <label class="custom-control-label" for="customRadio">
                                                <p>Payment on Delivery</p>
                                                </label>
                                            </div>  --}}
                                            <div class="custom-control custom-radio">
                                                <input type="radio" class="custom-control-input" id="customRadioTwo" name="cusRadio" checked>
                                                <label class="custom-control-label" for="customRadioTwo">
                                                    <p>Credit Card</p>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <div class="checkout-wrapper">
                            <h5 class="mb-40">Order Summary</h5>
                            <div>
                                <div id="thecart">



                                </div>


                                @auth
                                <form method="POST" id="couponform" action="{{ route('get.coupon.cuisine') }}" enctype="multipart/form-data" class="mt-5">
                                    <h5 class="mt-5">Coupon</h5>

                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-12 pr-0">
                                            <div class="form-group">
                                                <input type="text" name="coupon" required="required" placeholder="Enter Coupon Code" class="form-control">
                                                <!-- <input type="hidden" name="site" value="cuisine"> -->
                                                @csrf
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12 pl-0">
                                            <div class="form-group">

                                                <button type="submit" id="postCouponxxx" class="btn btn-info btn-join btn-block">Apply Coupon</button>

                                            </div>
                                        </div>
                                    </div>
                                </form>

                                @endauth

                                <div>
                                    <button type="button" class="btn btn-info btn-join" id="proceed">Proceed</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </article>
</main>
<div id="state-data" style="display: none;">{{ json_encode(locations_json()) }}</div>
<div id="shipping-data" style="display: none;">{{ (empty($shipping)) ? json_encode([]) : json_encode($shipping) }}</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/additional-methods.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(function() {



        $('body').on('click', '#proceed', function() {
            $("#order_form").validate({
                errorClass: "text-danger font-weight-light",
                rules: {
                    first_name: {
                        required: !0
                    },
                    'last_name': {
                        required: !0
                    },
                    'phone': {
                        required: !0
                    },
                    'email': {
                        required: !0
                    },
                    'address': {
                        required: !0
                    },
                    'state': {
                        required: !0
                    },
                    'city': {
                        required: !0
                    }
                }
            });

            $('#order_form').submit();
        });

        $('state-data').hide();

        $("#states").change("#states", function() {
            var state = $(this).val();
            var data = JSON.parse($("#state-data").html());
            updateAreas(data, state);
            getshippingcost();

        });

        var addressType = $('input[type=radio][name=addresstype]').val();
        var address = JSON.parse($("#shipping-data").html());

        updateAddress(address[addressType]);

        $('input[type=radio][name=addresstype]').change(function() {
            if (this.value == 'home') {
                updateAddress(address[this.value]);
            } else if (this.value == 'office') {
                updateAddress(address[this.value]);
            } else {
                updateAddress(false);
            }

        });

        function updateAddress(address) {
            var data = JSON.parse($("#state-data").html());

            if (address) {
                updateAreas(data, address.state);
                $('input[name=address]').val(address.address);
                $('select[name=state]').val(address.state);
                $('select[name=city]').val(address.city);
            } else {
                $('input[name=address]').val("");
                $('select[name=state]').val("");
                $('select[name=city]').val("");
            }

        }

        function updateAreas(data, state) {
            var areas = data[state];
            $.each(areas, function(index, value) {
                $("#areas").append("<option value='" + index + "'>" + value + "</option>");
            });
        }



        //apply coupon
        $("body").on("keyup", "input[name=coupon]", function() {
            $(this).val($(this).val().toUpperCase());
        });

        $('body').on('click', '#postCoupon', function(event) {
            event.preventDefault();

            // Get form
            var form = $('#couponform')[0];

            // Create an FormData object
            var formData = new FormData(form);

            $.ajax({
                type: "POST",
                enctype: 'multipart/form-data',
                url: "/cart/get/coupon",
                data: formData,
                processData: false,
                contentType: false,
                cache: false,
                timeout: 800000,
                success: function(data) {

                    if (data.status == 'error') {
                        $('.toast-body').html(data.message);
                        $('.toast').removeClass('bg-danger');
                        $('.toast').removeClass('bg-success');
                        $('.toast').addClass('bg-danger');
                        $('.toast').toast('show');
                    } else {
                        $('.toast-body').html(data.message);
                        $('.toast').removeClass('bg-danger');
                        $('.toast').removeClass('bg-success');
                        $('.toast').addClass('bg-success');
                        $('.toast').toast('show');

                        var coupon;
                        $.each(data.conditions, function(index, condition) {
                            coupon += '<div class="couponlist">' +
                                '<ul class="list-unstyled">' +
                                '<li class="text-right"><button class="removeCoupon btn btn-link" data-id="' + data.id + '" data-name="' + condition.name + '"><i class="fa fa-times text-danger"></i></button></li>' +
                                '<li class="font-weight-light">' + condition.name + '<br><small class="text-muted">' + condition.value + ' off ' + condition.microsite + ' item</small></li>' +
                                '<li class="linebr pt-3"><hr></li>' +
                                '</ul>' +
                                '</div>';

                        });

                        $('.showcoupon').html(coupon);
                    }
                },
                error: function(e) {

                    $("#output").text(e.responseText);
                    console.log("ERROR : ", e);
                    $("#btnSubmit").prop("disabled", false);

                }
            });
        });

        $('body').on('click', '.removeCoupon', function(event) {
            event.preventDefault();
            var couponlist = $(this);

            var product_id = $(this).data('id');
            var coupon = $(this).data('coupon');

            var url = "/cart/remove/coupon/" + product_id + "/" + coupon;
            $.get(url, function(data, status) {

                $('.toast-body').html(data.message);

                $('.toast').removeClass('bg-danger');
                $('.toast').removeClass('bg-success');
                $('.toast').addClass('bg-danger');
                $('.toast').toast('show');

                couponlist.parents(".couponlist").remove();

            });
        });

        $('body').on('change', '#areas', function(event) {
            event.preventDefault();

            getshippingcost();


        });

        var getshippingcost = function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                "type": "post",
                "cache": false,
                "dataType": "json",
                "url": "/cart/get/shippingCost",
                "data": {
                    'state': $('#states').val(),
                    'area': $('#areas').val()
                },
                "success": function(data) {

                    $.get("/restaurant/get/cart", function(data, status) {
                        $("#thecart").html(data);
                    });


                }
            });
        }

        $('#areas').select2({
            placeholder: "Select a city",
            theme: "bootstrap"
        });

        $.get("/restaurant/get/cart", function(data, status) {
            $("#thecart").html(data);
        });
    });
</script>

@endpush
