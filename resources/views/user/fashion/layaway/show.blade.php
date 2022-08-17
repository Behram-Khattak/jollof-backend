@extends('layouts.master')

@section('title', 'Jollof - Fashion - '.$product->name)

@push('styles')
    <style>
        .navbar-collapse .mens-clothing {
            margin-top: -37px;
        }

        .navbar-collapse .watches {
            margin-top: -73px;
        }

        .navbar-collapse .accessories {
            margin-top: -109px;
        }

        .navbar-collapse .jewelry {
            margin-top: -145px;
        }

        .navbar-collapse .shoes {
            margin-top: -178px;
        }

        .navbar-collapse .bags {
            margin-top: -220px;
        }

        .navbar-collapse .kids-fashion {
            margin-top: -258px;
        }

        .movie-div {
            padding: 100px 0;
            height:278px;
        }

        .services-wrapper {
            padding-bottom: 90px;
        }

        .services-wrapper h6 {
            font-size: var(--h6--text);
        }

        .services-wrapper span {
            text-transform: uppercase;
            color: #F14040;
        }

        .recommended-wrapper {
            background: #FFFFFF;
            box-shadow: 0px 2px 17px rgba(44, 51, 58, 0.1);
            border: none;
        }

        .recommended-wrapper > div {
            padding: 20px 10px 10px 10px;
        }

        .services-wrapper .recommended-wrapper .input-group > .custom-select:not(:first-child), .input-group > .form-control:not(:first-child) {
            text-align: center;
            margin-top: 4px;
            background: #E0E0E0;
            border-radius: 4px;
            position: relative;
            top: 3px;
        }

        .btn.btn-info.btn-join {
            margin-top: 7px;
            width: 100%;
        }
        .product-wrapper .input-group {
            width: auto;
        }

        .product-wrapper .column{
            height: 100px;
            overflow: hidden;
        }

        .product-wrapper .column img{
            object-fit: contain;
        }

        .services-wrapper .cuisine-div h6 {
            font-size: 23px;
            margin-top: 10px;
        }

        .services-wrapper .recommended-wrapper h6 {
            padding-top: 0;
        }

        .services-wrapper .recommended-wrapper p {
            font-size: 14px;
            margin-bottom: 5px;
        }

        .services-wrapper .recommended-wrapper span {
            font-size: 12px;
            color: #050505;
            padding-bottom: 10px;
        }

        .services-wrapper .single-product:hover img {
            opacity: 0.3;
        }

        .services-wrapper .single-product:hover .productdetails-wrapper {
            opacity: 1;
        }

        .modal {
            top: 0;
            max-height: initial;
            overflow-y: auto;
        }

        .modal-body {
            height: auto;
            overflow-y: auto;
        }

        .gallery-wrapper {
            margin-bottom: 15px;
        }

        .modal-body .product-wrapper .input-group {
            width: 50%;
        }

        .services-wrapper .product-review{
            height: auto;
            margin-bottom: 50px;
        }

        @media screen and (max-width: 768px) {
            .recommended-wrapper img.shopping {
                width: auto;
            }
        }

        @media screen and (max-width: 450px) {
            .recommended-wrapper .d-flex {
                display: block !important;
            }

            .services-wrapper h4.text-left {
                width: 100%;
            }
        }

        @media screen and (min-width: 780px) and (max-width: 1000px) {
            .recommended-wrapper .d-flex {
                display: block !important;
            }
        }

        @media screen and (min-width: 770px) and (max-width: 991px) {
            #fashion-navbar .navbar-nav .dropdown-menu {
                position: absolute;
                min-width: 33.5rem;
            }

            #fashion-navbar .navbar-header .navbar-brand, #fashion-navbar .navbar-header i {
                font-size: 15px;
            }
        }
        
        /* Create space between lower image  */
        #box {
            display: grid;
            width: 200px;
            grid-gap: 7px;
            /* Space between items */
            grid-template-columns: repeat(5,0.01fr);
            /* Decide the number of columns(4) and size(1fr | 1 Fraction | you can use pixels and other values also) */
            /* display: block; */
            margin: auto;
            clear: both;
            border: 1px;
            }

            .item {
            width: 100%;
            /* width is not necessary only added this to understand that width works as 100% to the grid template allocated space **DEFAULT WIDTH WILL BE 100%** */
            height: 50px;
        }
        #map {
            overflow: hidden;
            background-color: transparent;
            height: 100%;
            margin: 10px;
            clear: both;
            border: 1px;
            display: block;
            margin: auto;
        }
        img {
            background-color: transparent;
            display: block;
            margin: auto;
            clear: both;
            border: 1px;
            
        }
    </style>
        <link rel="stylesheet" href="{{ asset('Imageeffect/zoomifyc.min.css') }}">
@endpush

@section('content')
    <main style="background: #f7f7f7;">
        <article>
            <div class="services-wrapper" style="padding-bottom: 20px;">
                @include('partials._flash')
                <div class="container">
                    <!-- for mobile -->
                    <div class="mobile-wrapper">
                        <div class="mb-30" id="fashion-search-wrapper">
                            <div>
                                @include('user.fashion.partials.fashion-search')
                            </div>
                        </div>
                        <div>
                            <div class="movie-div" style="background:linear-gradient(rgba(44, 51, 58, 0.8), rgba(44, 51, 58, 0.8)), url({{ ($business->getMedia(App\Enums\MediaCollectionNames::BANNER)->isEmpty()) ? 'images/vendor-one.png' : $business->getMedia(App\Enums\MediaCollectionNames::BANNER)[0]->getFullUrl() }}); background-size: contain; background-repeat: no-repeat;">
                                <div class="store-wrapper">
                                    <div class="container">
                                        <p>Store</p>
                                        <h2>{{ $business->name  }}</h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-30 hidden-sm" id="fashion-search-wrapper">
                        @include('user.fashion.partials.fashion-category-menu')
                    </div>
                    </div>
                </div>
            </div>
            <div class="services-wrapper">
                <div class="product-wrapper">
                    <div class="container">

                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                                <div class="gallery-wrapper">
                                    <div class="mySlides">
                                        <div id="imgBox" style="background:white;">
                                            <div id="map"  style="background:white;">
                                                <img class=" image-responsive"
                                                    src="{{ asset($product->getFirstMediaUrl(\App\Enums\MediaCollectionNames::FEATURED_IMAGE,\App\Enums\MediaCollectionNames::BIG_CROP)) }}"
                                                    alt="Product featured image"
                                                    height="400"
                                                    onerror="this.onerror=null;this.src='{{ asset($product->getFirstMediaUrl(\App\Enums\MediaCollectionNames::FEATURED_IMAGE)) }}';"
                                                >
                                            </div>
                                        </div>
                                    </div>
                                    <!-- foreach for Replacing images onclick -->
                                    @foreach ($product->getMedia(\App\Enums\MediaCollectionNames::PRODUCT_IMAGES) as $image)
                                        <div class="mySlides">
                                            <div id="imgBox">
                                                <div id="map">
                                                    <img src="{{ asset($image->getUrl(\App\Enums\MediaCollectionNames::BIG_CROP)) }}" class="image-responsive"
                                                    height="400"
                                                    onerror="this.onerror=null; this.src='{{ asset($image->getUrl()) }}'; this.height='355';"
                                                    >
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                    <div class="row" id="box">
                                        <!-- The first Image of smaller images -->
                                        <div class="item">
                                            <img class="demo cursor"
                                                src="{{ asset($product->getFirstMediaUrl(\App\Enums\MediaCollectionNames::FEATURED_IMAGE,\App\Enums\MediaCollectionNames::SMALL_CROP))}}"
                                                alt="Product featured image"
                                                onerror="this.onerror=null;this.src='{{ asset($product->getFirstMediaUrl(\App\Enums\MediaCollectionNames::FEATURED_IMAGE)) }}';"
                                                onclick="currentSlide(1)"
                                                height=100%
                                            >
                                        </div>
                                        <!-- Remaining images of smaller images -->
                                        @foreach ($product->getMedia(\App\Enums\MediaCollectionNames::PRODUCT_IMAGES) as $image)
                                            <div class="item">
                                                <img class="demo cursor"
                                                    src="{{ asset($image->getUrl(\App\Enums\MediaCollectionNames::SMALL_CROP)) }}"
                                                    onerror="this.onerror=null;this.src='{{ asset($image->getUrl()) }}';"
                                                    alt="Product images"
                                                    onclick="currentSlide({{ $loop->iteration + 1 }})"
                                                    height=100%
                                                >
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div>
                                    <h4>{{ ucwords($product->name) }}</h4>

                                    <p class="product-details">
                                        {{ $product->description }}
                                    </p>

                                    <h6>
                                        &#8358;{!! calculateMenuPrice($product->price, $product->sales_price, $product->sales_start, $product->sales_end) !!}
                                    </h6>

                                    <p>
                                        In Stock:
                                        ({{ $product->quantity }} {{ Str::of('unit')->plural($product->quantity) }}
                                        available)
                                    </p>
                                    <div>
                                        <p class="bold">Color:</p>
                                        <div class="d-flex">
                                            <div class="p-2">
                                                <div>
                                                @for($i = 0; $i <= count($product->color_id) - 1; $i++)                                                   
                                                    <input type="color" id="favcolor" readonly disabled
                                                           value="{{ $product->color_id[$i]}}">
                                                @endfor                                                    
                                                </div>
                                            </div>
                                        </div>
                                        <p class="bold">Size Available</p>
                                        <div class="d-flex">
                                            <div class="p-2">
                                                <div>
                                                    <div class="row">
                                                        @for($i = 0; $i <= count($sizes) - 1; $i++)
                                                        <div class="col-md-3">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" value="{{$sizes[$i]}}" onclick="updatesize(event)" name="size" id="product_size" required>
                                                                <label class="form-check-label" for="flexCheckDefault">
                                                                    {{$sizes[$i]}}
                                                                </label>
                                                            </div>
                                                        </div>
                                                        @endfor
                                                    </div>
                                                    {{-- <input type="text" class="bold" size="13" id="favcolor" readonly disabled
                                                           value="{{ $sizes}}"> --}}
                                                </div>
                                            </div>
                                        </div>    
                                                                        
                                    </div>
                                    
                                    <!-- <div class="row">
                                        <div class="col-lg-4">
                                            <div>
                                                <p class="bold">Qty:</p>
                                                <div class="qib-container" style="float: left;">
                                                    <button type="button" class="minus minus-btn qib-button"
                                                            data-type="minus" data-field="quant[1]">-
                                                    </button>
                                                    <div class="quantity">
                                                        <input type="number" id="quantity_5e32c1598a905"
                                                               class="input-text qty text" step="1" min="1" max="{{ $product->quantity }}"
                                                               name="quantity" value="1" title="Qty" size="4"
                                                               inputmode="numeric">
                                                    </div>
                                                    <button type="button" class="plus plus-btn qib-button" data-type="plus"
                                                            data-field="quant[1]">+
                                                    </button>
                                                </div>
                                            </div>
                                        </div> -->
                                        <!-- <div class="col-lg-4">
                                            <div class="like-wrapper">
                                                <p><i class="fa fa-heart"></i> 999</p>
                                            </div>
                                        </div>  -->
                                    <!-- </div> -->
                                    <div class="mt-40">
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6 col-sm-6">
                                                @csrf
                                                @if($product->quantity > 0)
                                                <button type="button" class="btn btn-info btn-join" data-toggle="modal" data-amount="{{$settings->down_percentage/100 * $product->sales_price}}" data-target="#paymentmodal" onclick="paymentmodal({{($product->sales_price == 0) ? ($settings->down_percentage/100) * $product->price : ($settings->down_percentage/100) * $product->sales_price}})">
                                                    Pay {{$settings->down_percentage}}% now ({{($product->sales_price == 0) ? number_format(($settings->down_percentage/100) * $product->price,2) : number_format(($settings->down_percentage/100) * $product->sales_price,2)}})
                                                </button>
                                                @else
                                                    <button type="button" class="btn btn-info btn-join disabled" id="proceed">Out of Stock</button>
                                                @endif                                                                                        
                                            </div>
                                            </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                

                
            </div>
        </article>
    </main>

    <!-- Modal -->
<div class="modal fade" id="paymentmodal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Pay Layaway</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{route('fashion.layaway.pay')}}" method="post">
            <div class="row">
                <div class="col-md-12">
                    <label for="amount">Amount</label>
                    <input type="number" id="amount" name="amount" class="form-control" readonly>
                </div>
            </div>
            <div class="row">
                <input type="hidden" name="product_id" value="{{$product->id}}">
                <div class="col-md-6">
                    <label for="first_name">First Name</label>
                    <input type="text" class="form-control" name="firstname" placeholder="Enter your first name" value="{{auth()->user()->first_name ?? ''}}" readonly>
                </div>
                <div class="col-md-6">
                    <label for="last_name">Last Name</label>
                    <input type="text" id="last_name" class="form-control" name="lastname" placeholder="Enter your last name" value="{{auth()->user()->last_name ?? ''}}" readonly>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" class="form-control" placeholder="Enter your email" value="{{auth()->user()->email ?? ''}}" readonly>
                </div>
                <div class="col-md-6">
                    <label for="phone">Phone Number</label>
                    <input type="text" id="phone" name="phone" class="form-control" placeholder="Enter your phone number" value="{{auth()->user()->telephone ?? ''}}" readonly>
                </div>
            </div>
            <hr>
            <h5 class="modal-title" id="exampleModalLabel">Shipping details</h5>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="form-group">
                        <label>Delivery Address</label>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="addresstype" value="home" {{ empty($shipping) ? "checked" : (isset($shipping['home']) ? "checked" : "") }}>
                                <label class="form-check-label" for="inlineRadio1">Home Address</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="addresstype" value="office">
                                <label class="form-check-label" for="inlineRadio2">Office Address</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="addresstype" value="other">
                                <label class="form-check-label" for="inlineRadio3">Other Address</label>
                            </div>
                        </div>
                        <input type="text" class="form-control" id="address" name="address" required placeholder="Address">
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
                    {{--  <div class="custom-control custom-radio">
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
            <hr>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-primary">Continue</button>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>
<div id="state-data" style="display: none;">{{ json_encode(locations_json()) }}</div>
<div id="shipping-data" style="display: none;">{{ (empty($shipping)) ? json_encode([]) : json_encode($shipping) }}</div>
@endsection

@push('scripts')

    <!-- add amount to modal -->
    <!-- <script src="{{asset('sweetalert.sweetalert.js')}}"></script> -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function paymentmodal(amount) {
            // console.log(amount);
            $('#amount').val(amount);
        }
        $('#address').click(function() {
            // $('#address').val('');
            Swal.fire({
                title: 'Enter your address',
                input: 'text',
                confirmButtonText: 'Submit',
                showCancelButton: true,            
        }).then((result) => {
            if (result.value) {
                $('#address').val(result.value);
            }
        })
        });

        $('#paymentmodal').on('shown.bs.modal', function () {
            // $('#address').trigger('focus')
        })

        // $(document).ready(function(){
        //     $('#paymentmodal').on('show.bs.modal', function (event) {
        //         var button = $(event.relatedTarget) // Button that triggered the modal
        //         var amount = button.data('amount') // Extract info from data-* attributes
        //         console.log(amount);
        //         // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        //         // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        //         var modal = $(this)
        //         modal.find('.modal-title').text('Pay Layaway')
        //         modal.find('.modal-body input #amount').val(amount)
        //     })
        // })
    </script>
    <!-- State script -->
    <script>
        $('state-data').hide();

        $("#states").change("#states", function(){
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
            }
            else if (this.value == 'office') {
                updateAddress(address[this.value]);
            }
            else{
                updateAddress(false);
            }

        });

        function updateAddress(address){
            var data = JSON.parse($("#state-data").html());

            if(address){
                updateAreas(data, address.state);
                $('input[name=address]').val(address.address);
                $('select[name=state]').val(address.state);
                $('select[name=city]').val(address.city);
            }
            else{
                $('input[name=address]').val("");
                $('select[name=state]').val("");
                $('select[name=city]').val("");
            }

        }

        function updateAreas(data, state){
            var areas = data[state];
            $.each(areas, function(index, value) {
                $("#areas").append("<option value='"+ index +"'>" + value + "</option>");
            });
        }
    </script>
    <script>
        var slideIndex = 1;
        showSlides(slideIndex);

        function plusSlides(n) {
        showSlides(slideIndex += n);
        }

        function currentSlide(n) {
        showSlides(slideIndex = n);
        }

        function showSlides(n) {
            var i;
            var slides = document.getElementsByClassName("mySlides");
            var dots = document.getElementsByClassName("demo");
            var captionText = document.getElementById("caption");
            if (n > slides.length) {slideIndex = 1}
            if (n < 1) {slideIndex = slides.length}
            for (i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";
            }
            for (i = 0; i < dots.length; i++) {
                dots[i].className = dots[i].className.replace(" active", "");
            }
            slides[slideIndex-1].style.display = "block";
                dots[slideIndex-1].className += " active";
                //captionText.innerHTML = dots[slideIndex-1].alt;
        }


        $(document).ready(function () {
            $('#fashion-navbar .categories-desktop ul.nav .btn-group').hover(function () {
                $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeIn(500);
            }, function () {
                $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeOut(500);
            });


            $('body').on('click', '.plus-btn', function(){
                //var price = Number($(this).data('price'));
                var inputField = $(this).parents('.qib-container').find('.qty');
                var maxvalue = inputField.prop('max');
                var enteredVal = Number(inputField.val());
                var increment = (enteredVal < maxvalue) ? Number(inputField.val()) + 1 : Number(inputField.val());
                inputField.val(increment);
                $('input[name=quantity]').val(increment);
            });

            $('body').on('click', '.minus-btn', function(){
                //var price = $(this).data('price');
                var inputField = $(this).parents('.qib-container').find('.qty');
                var decrement = Number(inputField.val()) - 1;
                inputField.val(decrement);
                $('input[name=quantity]').val(decrement);
                if (inputField.val() == 0) {
                    inputField.val(1);
                    $('input[name=quantity]').val(1);
                }
            });
            $('body').find('#address').focus();
        });
    </script>
    <script src="{{ asset('Imageeffect/zoomifyc.min.js') }}"></script>
    <script>
        zoomifyc.init($('#imgBox img'));
    </script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>  -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
@endpush
