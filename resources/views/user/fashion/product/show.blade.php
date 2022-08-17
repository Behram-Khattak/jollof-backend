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
        .prdimg {
            padding: 0px !important;
            height: 255px;
            object-fit: contain;
            overflow: hidden;
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
                                    
                                    <div class="row">
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
                                        </div>
                                        <!-- <div class="col-lg-4">
                                            <div class="like-wrapper">
                                                <p><i class="fa fa-heart"></i> 999</p>
                                            </div>
                                        </div>  -->
                                    </div>
                                    <div class="mt-40">
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6 col-sm-6">
                                                <form method="POST" action="{{ route('fashion.cart.post') }}">
                                                    <input type="hidden" name="productID" value="{{ $product->id }}"/>
                                                    <input type="hidden" name="microsite" value="fashion"/>
                                                    <input type="hidden" name="quantity" value="1"/>
                                                    <input type="hidden" id="size" name="size" value=""/>
                                                    @csrf
                                                    @if($product->quantity > 0)
                                                        <button type="submit" class="btn btn-info btn-join" id="proceed">Add To Cart</button>
                                                    @else
                                                        <button type="button" class="btn btn-info btn-join disabled" id="proceed">Out of Stock</button>
                                                    @endif
                                                </form>
                                            </div>
                                            {{--                                            <div class="col-lg-6 col-md-6 col-sm-6">--}}
                                            {{--                                                <div>--}}
                                            {{--                                                    <a href="fashion-shopping-cart.html" class="btn btn-info btn-join btn-guest" id="proceed" style="background: #fff; color: #eb6323;">Add to Cart</a>--}}
                                            {{--                                                </div>--}}
                                            {{--                                            </div>--}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container">
                    <div class="product-review">
                        <ul class="nav nav-tabs">
                            <li class="active">
                                <a data-toggle="tab" href="#overview">
                                    <h6>Overview</h6>
                                </a>
                            </li>
                            <li>
                                <a data-toggle="tab" href="#customer-reviews">
                                    <h6>Customer Reviews ({{ $reviews->total() }})</h6>
                                </a>
                            </li>

                            <!-- <li class="text-right">
                                <a href="">Report Item</a>
                            </li> -->
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div class="tab-pane active" id="overview">
                                <table class="table table-bordered">
                                    <tr>
                                        <th>SKU</th>
                                        <td>{{ $product->sku }}</td>
                                    </tr>
                                    <tr>
                                        <th>Color</th>
                                        <td> @foreach($color_name as $color)
                                                {{$color}} ||
                                        @endforeach
                                            </td>
                                    </tr>
                                    {{--                                    @isset($product->size_id)--}}
                                    {{--                                        <tr>--}}
                                    {{--                                            <th>Size</th>--}}
                                    {{--                                            <td>{{ $product->size }}</td>--}}
                                    {{--                                        </tr>--}}
                                    {{--                                    @endisset--}}

                                    <tr>
                                        <th>Weight</th>
                                        <td>{{ $product->weight }}(kg)</td>
                                    </tr>

                                    <tr>
                                        <th>Material</th>
                                        <td>{{ $product->material->name }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="tab-pane container pt-3" id="customer-reviews">
                                @include('user.partials._review', ['model_id'=> $product->id, 'model_type'=> 'App\Models\FashionProduct'])
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-40">
                    <div class="container">
                        <div>
                            <h4 class="text-left">Similar Products</h4>
                        </div>
                        <div class="row">
                            @forelse($similarProducts as $product)
                                <div class="col-lg-3 col-md-3 col-sm-6 col-6">
                                    <div class="single-product">
                                        <div class="recommended-wrapper">
                                            <div class="prdimg">
                                                <a href="{{ route('fashion.product.show', $product) }}">
                                                    <img
                                                        src="{{ asset($product->getFirstMediaUrl(\App\Enums\MediaCollectionNames::FEATURED_IMAGE,\App\Enums\MediaCollectionNames::BIG_CROP)) }}"
                                                        class="img-fluid" alt="Product featured image"
                                                        onerror="this.onerror=null;this.src='{{ asset($product->getFirstMediaUrl(\App\Enums\MediaCollectionNames::FEATURED_IMAGE)) }}';"
                                                        >
                                                </a>
                                            </div>
                                            <div class="text-center">
                                                <p>{{ Str::limit(ucwords($product->name), 25) }}</p>
                                                <span>
                                                    &#8358;{!! calculateMenuPrice($product->price, $product->sales_price, $product->sales_start, $product->sales_end) !!}
                                                </span>
                                            </div>
                                            {{--                                            <div class="productdetails-wrapper">--}}
                                            {{--                                                <div class="d-flex">--}}
                                            {{--                                                    <button class="btn btn-info btn-join shopping-btn"--}}
                                            {{--                                                            title="Add to cart">--}}
                                            {{--                                                        <i class="fa fa-shopping-bag"></i></button>--}}
                                            {{--                                                    <button class="btn btn-info btn-join quickview-btn"--}}
                                            {{--                                                            title="Quick View"--}}
                                            {{--                                                            data-toggle="modal" data-target="#myModal"><i--}}
                                            {{--                                                            class="fa fa-eye"></i></button>--}}
                                            {{--                                                </div>--}}
                                            {{--                                            </div>--}}
                                        </div>
                                    </div>
                                </div>

                            @empty
                                <div class="container">

                                    <p>There are no products similar to this product</p>
                                </div>

                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </article>
    </main>
@endsection

@push('scripts')

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
        });

        function updatesize(event)
        {
            document.getElementById('size').value = event.target.value;
            console.log(event.target.value);
        }
        // $(document).ready(function () {
        //     $('#product_size').click(function () {
        //         console.log('#product_size').val;
        //     })
        // })
    </script>
    <script src="{{ asset('Imageeffect/zoomifyc.min.js') }}"></script>
    <script>
        zoomifyc.init($('#imgBox img'));
    </script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>  -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
@endpush
