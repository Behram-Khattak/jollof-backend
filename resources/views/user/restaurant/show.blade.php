@extends('layouts.master')

@section('title', 'Jollof - '. $business->name .' - menu items')

@push('styles')

    <link rel="stylesheet" href="{{ asset('css/bootstrap-datetimepicker.min.css') }}" />
    {{--  <link rel="stylesheet" href="{{ asset('css/dtpicker.min.css') }}" />  --}}


    <style>
        <blade media|%20screen%20and%20(max-width%3A%20768px)%20%7B>.logo-wrapper .navbar-collapse {
            margin: 0px 15px;
        }

        .services-wrapper span {
            display: inline-block;
        }
        .img-wrapper{
            width: 150px;
            height: 150px;
            overflow: hidden;
        }
        .btn.btn-info.btn-facebook,
        .btn.btn-info.btn-google {
            padding: 10px 40px;
            padding-top: 7px;
            border-radius: 0;
            font-size: 18px;
            border: 0;
        }

        .btn.btn-info.btn-google {
            background: #b22823;
        }

        .btn.btn-info.btn-facebook {
            background: #3460ad;
        }

        .grills-wrapper h4,
        .grills-wrapper p,
        .grills-wrapper h6 {
            color: #FFF;
            margin-bottom: 0;
        }

        .grills-wrapper span.close {
            background: #F14040;
            border-radius: 12px;
            letter-spacing: .04em;
            color: #fff;
            font-size: 10px;
            text-align: center;
            padding: 2px 7px;
            display: inline-block;
            margin-top: 22px;
        }

        .grills-wrapper h6 {
            font-size: var(--h6--text);
            margin-top: -7px;
        }

        .services-wrapper {
            padding-top: 40px;
            padding-bottom: 120px;
        }

        .services-wrapper span {
            text-transform: uppercase;
            color: #F14040;
        }

        .recommended-wrapper>div {
            padding: 0;
        }

        .checkout-wrapper p {
            margin-bottom: 0;
        }

        .checkout-wrapper .regular p {
            margin-bottom: 20px;
        }

        .btn-join-outline{
            background-color: #FFFFFF !important;
            color: #eb6323 !important;
            cursor:pointer;
        }

        .btn-info.btn-join{
            cursor:pointer;
        }

        .mainmenu-wrapper li button{
            width: auto;
            height: auto;
        }

        .extras-detail-att{
            border-bottom: none;
        }

        .services-wrapper span{
            font-size: 12px;
            color: #2b2b2b;
        }

        /*img{height:100px;}*/
        #overlay{
            position: fixed;
            top:0;
            left:0;
            width:100%;
            height:100%;
            background: rgba(0,0,0,0.8) none 50% / contain no-repeat;
            cursor: pointer;
            transition: 0.3s;

            visibility: hidden;
            opacity: 0;
        }
        #overlay.open {
            visibility: visible;
            opacity: 1;
            z-index: 99;
        }

        #overlay:after { /* X button icon */
            content: "\2715";
            position: absolute;
            color:#fff;
            top: 10px;
            right:20px;
            font-size: 2em;
        }

    </style>
        <link rel="stylesheet" href="{{ asset('Imageeffect/zoomifyc.min.css') }}">

@endpush


@section('content')
<div id="overlay"></div>
<main class="container">
    <article>
        <div class="movie-div" style="background:linear-gradient(rgba(44, 51, 58, 0.8), rgba(44, 51, 58, 0.8)), url({{ ($business->getMedia(App\Enums\MediaCollectionNames::BANNER)->isEmpty()) ? 'images/vendor-one.png' : $business->getMedia(App\Enums\MediaCollectionNames::BANNER)[0]->getFullUrl() }}); background-size: cover; background-repeat: no-repeat; height:332px;">
            <div class="grills-wrapper">
                <div class="container">
                    <div class="d-flex">
                        <div class="p-2">
                            <h4>{{ $business->name }}</h4>
                        </div>
                        <div class="p-2">
                            @if($restaurant)
                                @if(restaurantOpen($restaurant->hours))
                                <span class="open">OPEN</span>
                                @else
                                <span class="close">CLOSED</span>
                                @endif
                            @endif

                        </div>
                    </div>
                    <h6>{{ $business->locations[0]->area }}, {{ $business->locations[0]->city }}, {{ $business->locations[0]->state }}</h6>
                    {{--  <div class="store-stars">
                        <i class="fa fa-star" style="color: #6FCF97;"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <span class="font-weight-bold text-white">5.0</span>
                    </div>  --}}
                    @if($restaurant)
                    <p>Estimated Delivery Time: {{ $restaurant->delivery_time }} Mins</p>
                    <p>MinimumOrder: N {{ $restaurant->min_order }}</p>
                    @endif

                </div>
            </div>
        </div>
        <div class="services-wrapper">
            <div class="container">
                @include("partials._flash")
                <div class="row">
                    <div class="col-lg-3 col-md-3">
                        <div class="cuisine-store-details">
                            <div class="store-name">
                                <h6>Categories</h6>
                                <div>
                                    @if($groups->isEmpty())
                                        <p>There are no categories added yet</p>
                                    @else
                                        @foreach($menus as $menu)
                                            @if(!$menu->menus->isEmpty())
                                                <p><a href="#{{ $menu->name }}">{{ $menu->name }}</a></p>
                                            @endif
                                        @endforeach
                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-5">
                        <div style="background: #fff;" id="food-lists">
                            <ul class="nav nav-tabs">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#menu">Menu</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#customer-reviews">Review ({{ $reviews->count() }})</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#bookatable">Book a Table</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#restaurant-info">Restaurant Info</a>
                                </li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div class="tab-pane container active" id="menu">
                                    {{--  <div>
                                        <div class="form-group food-search">
                                            <input type="text" class="form-control" placeholder="Search food item">
                                            <i class="fa fa-search"></i>
                                        </div>
                                    </div>  --}}
                                    <div class="mainmenu-wrapper">

                                        @foreach($menus as $menu)
                                            @if(!$menu->menus->isEmpty())
                                            <div div id="{{ $menu->name }}">
                                                <h6 class="food-name">{{ $menu->name }}</h6>

                                                <ul>
                                                    @forelse($menu->menus as $item)

                                                        <li class="1" data-menu="{{ $item->menu }}"
                                                            data-price="{{ $item->price }}">
                                                            <div class="row">
                                                                <div class="col-lg-8 col-md-12">
                                                                    <div class="d-flex">
                                                                        <div class="img-wrapper" id="imgBox">
                                                                            <a style="cursor: pointer;">
                                                                            <img src="{{ $item->getFirstMediaUrl('menu') }}" class="img-fluid" alt="" width="200px" height="200px">
                                                                            </a>
                                                                        </div>
                                                                        <div class="event-details">
                                                                            <h6 class="mb-0">{{ $item->menu }}</h6>
                                                                            <p class="text-muted"><small>{{ $item->description }}</small></p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-4 col-md-12">
                                                                    <div class="d-flex margin-top-20 pull-right">
                                                                        <p class="price ml-2">
                                                                            @if($item->type == "PROMO")
                                                                                ₦{!! calculateMenuPrice($item->price, $item->sales_price, $item->sales_start, $item->sales_end) !!}</p>
                                                                            @else
                                                                            {{ number_format($item->price, 2) }}
                                                                            @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-lg-12 col-md-12 text-right">
                                                                    <form method="POST" action="{{ route('cart.post') }}" enctype="multipart/form-data" id="toppingform">
                                                                        <input type="hidden" name="productID" value="{{ $item->id }}" required>
                                                                        <input type="hidden" name="microsite" value="cuisine" required>
                                                                        <input type="hidden" name="businessID" value="{{ $business->id }}" required>
                                                                        <input type="hidden" name="addmainmenu" value="1" required>
                                                                        <input type="hidden" name="menuid" value="">
                                                                        @csrf
                                                                        {{-- @if ($item->extra) --}}
                                                                        @if(restaurantOpen($restaurant->hours))
                                                                            @if($item->in_stock == 1)
                                                                                <a class="addToppings btn btn-info btn-join btn-join"
                                                                                    data-id="{{ $item->id }}"
                                                                                    data-microsite="cuisine" data-menuid="">Add Order</a>
                                                                            @else
                                                                            @if ($item->preorder)
                                                                            <span class="text-danger font-weight-bold">item available only on pre-order &nbsp;</span>
                                                                                    <a class="addToppings btn btn-info btn-join btn-join"
                                                                                    data-id="{{ $item->id }}"
                                                                                    data-microsite="cuisine" data-menuid="">Pre-Order Menu</a>
                                                                                @endif
                                                                            @endif
                                                                        @else
                                                                            @if ($item->preorder)
                                                                                <a class="addToppings btn btn-info btn-join btn-join"
                                                                                data-id="{{ $item->id }}"
                                                                                data-microsite="cuisine" data-menuid="">Pre-Order Menu</a>
                                                                            @else
                                                                                <a class="btn btn-info btn-join disabled" javascript="void();">Order Closed</a>
                                                                            @endif

                                                                        @endif

                                                                        {{-- <button class="btn btn-info btn-join"
                                                                                type="submit">Add to Order</button> --}}
                                                                    </form>
                                                                </div>
                                                            </div>
                                                            <hr>
                                                        </li>

                                                    @empty

                                                        <li class="1">
                                                            <div class="row">
                                                                <div class="col-lg-12 col-md-12">
                                                                    <div class="d-flex">
                                                                        <p class="text-center py-3">No menu in this
                                                                            category</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <hr>
                                                        </li>

                                                    @endforelse

                                                </ul>
                                            </div>
                                            @endif
                                        @endforeach


                                    </div>
                                </div>
                                <div class="tab-pane container fade" id="customer-reviews">
                                    @include('user.partials._review', ['model_id'=> $restaurant->id, 'model_type'=> 'App\Models\Restaurant'])
                                </div>
                                <div class="tab-pane container fade" id="bookatable">
                                    <div>
                                        <h6>Book This Restaurant</h6>
                                        <p class="mt--5">Discover a wide range of dining experience. Book now by filling
                                            out the form</p>
                                    </div>
                                    <div class="mt-30">
                                        <form method="post" action="{{ route('restaurant.booking') }}">
                                            <div class="row">
                                                <div class="col-lg-6 col-md-12">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" name="first_name" placeholder="First Name" required>
                                                        <input type="hidden" name="restaurant_id" value="{{ ($restaurant) ? $restaurant->id :  '' }}" required>
                                                        @csrf
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-12">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" name="last_name" placeholder="Last Name" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6 col-md-12">
                                                    <div class="form-group">
                                                        <input type="email" class="form-control" name="email" placeholder="Email" required>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-12">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" name="phone" placeholder="Phone" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12 col-md-12">
                                                    <div class="form-group">
                                                        <select class="form-control" name="guest" required>
                                                            <option value="">Guests</option>
                                                            <option value="2">2 Guests</option>
                                                            <option value="3">3 Guests</option>
                                                            <option value="4">4 Guests</option>
                                                            <option value="5">5 Guests</option>
                                                            <option value="6">6 Guests</option>
                                                            <option value="7">7 Guests</option>
                                                            <option value="8">8 Guests</option>
                                                            <option value="9">9 Guests</option>
                                                            <option value="10">10+ Guests</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6 col-md-12">
                                                    <div class="form-group">
                                                        <input type="date" class="form-control" name="date" placeholder="Booking date" required>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-12">
                                                    <div class="form-group">
                                                        <select class="form-control" name="time" required>
                                                            <option value="12:00 pm">12:00PM</option>
                                                            <option value="1:00 pm">1:00PM</option>
                                                            <option value="2:00 pm">2:00PM</option>
                                                            <option value="3:00 pm">3:00PM</option>
                                                            <option value="4:00 pm">4:00PM</option>
                                                            <option value="5:00 pm">5:00PM</option>
                                                            <option value="6:00 pm">6:00PM</option>
                                                            <option value="7:00 pm">7:00PM</option>
                                                            <option value="8:00 pm">8:00PM</option>
                                                            <option value="9:00 pm">9:00PM</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-md-12 px-0">
                                                <div class="form-group">
                                                    <textarea class="form-control" name="instructions" rows="6"
                                                    placeholder="Your instructions" required></textarea>
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-info btn-join mt-30">Submit</button>
                                        </form>
                                    </div>
                                </div>
                                <div class="tab-pane container fade" id="restaurant-info">
                                    <h6>About {{ $business->name }}</h6>
                                    <p>{{ $business->description }}</p>

                                    <div class="contact-wrapper">
                                        <div class="row">
                                            <div class="col-md-5">
                                                <div class="store-name">
                                                    <h6>Contact Details</h6>
                                                    <p class="bold">{{ $business->locations[0]->address }}</p>
                                                    <p class="bold">{{ $business->locations[0]->city }} {{ $business->locations[0]->area }}, <br>{{ $business->locations[0]->state }}</p>
                                                    <h6>{{ $business->locations[0]->telephone }}</h6>
                                                </div>
                                            </div>
                                            <div class="col-md-7">
                                                <div class="store-name opening-hours pd-10">
                                                    @if($restaurant)

                                                        <h6>Opening Hours</h6>
                                                        @if(empty($hours))


                                                        @else
                                                        <table class='table bg-white table-borderless table-condensed'>
                                                            @foreach($hours as $day => $hour)
                                                            <?php
                                                                $open = explode(':', $hour[0])[0];
                                                                $close = explode(':', $hour[1])[0];
                                                            ?>

                                                                <tr>
                                                                    <td><strong>{{ $day }}</strong></td>
                                                                    @if(isset($isopen[$day]) && $isopen[$day] == 1)
                                                                        <td>
                                                                            @if($open > 12)
                                                                                <span>{{ $open - 12 }}:00 PM</span>
                                                                            @else
                                                                                <span>{{ $open }}:00 AM</span>
                                                                            @endif
                                                                            -
                                                                            @if($close > 12)
                                                                                <span>{{ $close -12 }}:00 PM</span>
                                                                            @else
                                                                                <span>{{ $close }}:00 AM</span>
                                                                            @endif
                                                                    @else
                                                                        <td class="text-center text-danger font-weight-bold">CLOSED</td>
                                                                    @endif
                                                                </tr>

                                                            @endforeach
                                                            </table>
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4">
                        <div class="checkout-wrapper">
                            @include('user.partials._cuisineCart')
                        </div>
                    </div>
                </div>

                <!-- other food supplements modal -->
                <div class="modal fade" id="extrasModal">
                    <div class="modal-dialog">
                        <div class="modal-content">

                            <div class="modal-header">
                                <h5 class="modal-title my-0">Main Dish</h5>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>

                            <form method="POST" action="{{ route('cart.post') }}" enctype="multipart/form-data" id="toppingform">
                            <div class="modal-body">

                                <div id="menu-toppings">

                                </div>
                                <input type="hidden" name="productID" id="productID" required>
                                <input type="hidden" name="microsite" value="cuisine" required>
                                <input type="hidden" name="businessID" value="{{ $business->id }}" required>
                                <input type="hidden" name="menuid" value="" id="menuID">
                                @csrf
                            </div>

                            <div class="modal-footer border-top-0">
                                <button type="submit" class="btn btn-info btn-join" id="postCarted">Add to Order</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="toast text-white" role="alert" aria-live="assertive" aria-atomic="true" data-delay="3000"
                    style="position: fixed; top: 1rem; right: 1rem;">
                    <div class="toast-body">

                    </div>
                </div>
    </article>
</main>


@endsection


@push('scripts')

<script type="text/javascript" src="{{ asset('js/bootstrap-datetimepicker.min.js') }}"></script>
{{--  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script type="text/javascript" src="{{ asset('js/dtpicker.min.js') }}"></script>  --}}




    <script>
        $(function () {
            $("#btnSubmitCart").addClass("disabled");
            let totalspend = {{ $spend }};
            let minspend = {{ $restaurant->min_order }};
            if($('.after-order').find('.cartItem').length !== 0){
                if(totalspend >= minspend){
                    $("#btnSubmitCart").removeClass("disabled");
                }
            }


            $('body').on('click', '.plus-btn', function(){
                var price = Number($(this).data('price'));
                var inputField = $(this).parents('.extras-detail-att').find('.qty_input');
                var increment = Number(inputField.val()) + 1;
                var qty = inputField.val(increment);
                $(this).parents('.extras-detail-att').find('.price').html(price * increment);
                $(this).parents('.extras-detail-att').find('.topping').val(price * increment);
            });

            $('body').on('click', '.minus-btn', function(){
                var price = $(this).data('price');
                var inputField = $(this).parents('.extras-detail-att').find('.qty_input');
                var decrement = Number(inputField.val()) - 1;
                var qty = inputField.val(decrement);
                if (inputField.val() == 0) {
                    inputField.val(1);
                    qty = 1;
                    decrement = 1;
                }
                $(this).parents('.extras-detail-att').find('.price').html(price * decrement);
                $(this).parents('.extras-detail-att').find('.topping').val(price * decrement);
            });

            $('body').on('click', '.addCart', function () {

                var product_id = $(this).data('id');
                var url = "/restaurant/add/cart/" + product_id;
                var cartItem = '';
                $.get(url, function (data, status) {
                    let totalQuantity = data.items;

                    $('.toast-body').html(data.message);
                    $('.toast').removeClass('bg-danger');
                    $('.toast').removeClass('bg-success');
                    $('.toast').addClass('bg-success');
                    $('.toast').toast('show');

                    $.get("/cart/show", function (pdata, status) {
                        $('.checkout-wrapper').html(pdata);
                    });

                });

            });

            $('body').on('click', '.reduceCart', function () {
                var cartItem = '';
                var product_id = $(this).data('id');
                var url = "/restaurant/reduce/cart/" + product_id;
                $.get(url, function (data, status) {

                    let totalQuantity = data.items;

                    $('.toast-body').html(data.message);
                    $('.toast').removeClass('bg-danger');
                    $('.toast').removeClass('bg-success');
                    $('.toast').addClass('bg-danger');
                    $('.toast').toast('show');

                    $.get("/cart/show", function (pdata, status) {
                        $('.checkout-wrapper').html(pdata);
                    });
                });

            });

            $('body').on('click', '.removeCart', function () {
                var cart = $(this);
                var cartItem = '';
                var product_id = $(this).data('id');
                var url = "/restaurant/remove/cart/" + product_id;
                $.get(url, function (data, status) {

                    let totalQuantity = data.items;
                    delete data['items'];

                    $('.toast-body').html(data.message);

                    $('.toast').removeClass('bg-danger');
                    $('.toast').removeClass('bg-success');
                    $('.toast').addClass('bg-danger');
                    $('.toast').toast('show');

                    $.get("/cart/show", function (pdata, status) {
                        $('.checkout-wrapper').html(pdata);
                    });

                    /*cart.parents(".cartItem").remove();
                    $('.cart-number-wrap').html('<div class="cart-number">'+totalQuantity+'</div>');

                    if($('.after-order').find('.cartItem').length == 0){
                        $('.no-order').show();
                        $("#btnSubmitCart").addClass("disabled");
                    }*/
                });

            });

            $('body').on('click', '.addToppings', function () {
                $("#menu-toppings").html("<div class='text-center p-5 m-5'>...Loading</div>");
                $('#extrasModal').modal('show');
                var cartItem = '';
                var product_id = $(this).data('id');

                $("#productID").val(product_id);
                $("#menuID").val($(this).data('menuid'));
                var url = "/restaurant/get/toppings/" + product_id;
                $.get(url, function (data, status) {
                    $("#menu-toppings").html(data);
                });
            });


            $('body').on('click', '#postCart', function (event) {
                event.preventDefault();

                // Get form
                var form = $('#toppingform')[0];

                // Create an FormData object
                var formData = new FormData(form);

                //get product id
                var product_id = $(this).data('id');
                var cartItem = '';

                $.ajax({
                    type: "POST",
                    enctype: 'multipart/form-data',
                    url: "/restaurant/post/cart",
                    data: formData,
                    processData: false,
                    contentType: false,
                    cache: false,
                    timeout: 800000,
                    success: function (data) {
                        let totalQuantity = data.items;
                        $('.toast-body').html(data.message);
                        $('.toast').removeClass('bg-danger');
                        $('.toast').removeClass('bg-success');
                        $('.toast').addClass('bg-success');
                        $('.toast').toast('show');

                        $("#menu-toppings").html("");
                        $('#extrasModal').modal('hide');

                        delete data['message'];
                        delete data['items'];
                        $.each(data, function(index, product) {

                            cartItem += '<div class="cartItem">'+
                                '<ul class="list-unstyled">'+
                                    '<li>'+
                                        '<span class="pull-left">'+
                                            '<div class="input-group input-group-sm">'+
                                                '<div class="input-group-prepend">'+
                                                    '<button type="button" class="btn btn-light px-2 p-0 reduceCart" data-id="'+ product.id +'"><i class="fa fa-minus"></i></button>'+
                                                '</div>'+
                                                '<div class="input-group-append">'+
                                                    '<button type="button" class="btn btn-light px-2 py-0 addCart" data-id="'+ product.id +'"><i class="fa fa-plus"></i></button>'+
                                                '</div>'+
                                            '</div>'+
                                        '</span>'+
                                        '<span class="pull-right">'+
                                            '<button class="removeCart btn btn-link" data-id="'+ product.id +'"><i class="fa fa-times text-danger"></i></button></li>'+
                                        '</span>'+
                                        '<div class="clearfix"></div>' +

                                    '<li class="font-weight-light">'+ product.name +'<br><small class="text-muted"> '+ product.attributes.toppings +'</small></li>'+
                                    '<li class="font-weight-bold">NGN '+ product.price * product.quantity +' <span class="font-weight-bold pull-right text-dark">QTY '+ product.quantity +'</span></li>'+
                                    '<li class="linebr pt-3"><hr></li>'+
                                '</ul>'+
                            '</div>';
                        });

                        $('.cart-number-wrap').html('<div class="cart-number">'+totalQuantity+'</div>');
                        $('.after-order').html(cartItem);
                        if($('.after-order').find('.cartItem').length !== 0){
                            $('.no-order').hide();
                            $("#btnSubmitCart").removeClass("disabled");
                        }
                    },
                    error: function (e) {

                        $("#output").text(e.responseText);
                        console.log("ERROR : ", e);
                        $("#btnSubmitCart").addClass("disabled");

                    }
                });
            });


            // Image to Lightbox Overlay
            // $('img').on('click', function() {
            //     $('#overlay')
            //     .css({backgroundImage: `url(${this.src})`})
            //     .addClass('open')
            //     .one('click', function() { $(this).removeClass('open'); });
            // });


            $('body').on('focus', '.mydatetime', function(){

                const today = new Date();
                const tomorrow = new Date(today);
                tomorrow.setDate(tomorrow.getDate() + 1);
                tomorrow.setHours(06);
                tomorrow.setMinutes(00);

                //datetime for pre-order
                $(this).datetimepicker({
                    format: "yyyy-mm-dd hh:ii",
                    autoclose: true,
                    todayBtn: false,
                    todayHighlight: false,
                    startDate:tomorrow
                });
            });

            $('.preorderbox').hide();
            $('body').on('change', 'input[name="preorder"]', function(){
                if($(this).prop("checked")){
                    $('.preorderbox').show();
                }
                else{
                    $('.preorderbox').hide();
                }
            });

            /*$('body').on('click', '.mydatetime', function(){
                alert();
                $(this).datetimepicker({
                    "allowInputToggle": true,
                    "showClose": true,
                    "showClear": true,
                    "showTodayButton": true,
                    "format": "MM/DD/YYYY HH:mm:ss",
                });
            });*/

        });

    </script>
    <script src="{{ asset('Imageeffect/zoomifyc.min.js') }}"></script>

    <script>
        zoomifyc.init($('#imgBox img'));
    </script>
@endpush

