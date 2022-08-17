@extends('layouts.master')

@section('title', 'Fashion | All Products | Jollof')


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

        .services-wrapper {
            padding: 65px 0 80px 0;
        }

        #fashion-navbar .navbar-collapse {
            position: relative;
            z-index: 2;
        }

        .btn.btn-info.btn-join {
            margin-top: 7px;
            width: 100%;
        }

        .services-wrapper .pull-right a {
            color: #000;
            margin-top: 40px;
        }

        .recommended-wrapper {
            background: #FFFFFF;
            box-shadow: 0px 2px 17px rgba(44, 51, 58, 0.1);
            border: none;
        }

        .recommended-wrapper > div {
            padding: 20px 10px 10px 10px;
        }

        .prdimg {
            padding: 0px !important;
            height: 255px;
            object-fit: contain;
            overflow: hidden;
        }

        .services-wrapper .selection-wrapper .selection-value {
            width: auto;
        }

        .services-wrapper .cuisine-div h6 {
            font-size: 23px;
            margin-top: 10px;
        }

        .services-wrapper .recommended-wrapper h6 {
            padding-top: 0;
        }

        .checkout-wrapper {
            background: #FFF;
        }

        .services-wrapper .custom-control-label p {
            margin-bottom: 10px;
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

        .services-wrapper span {
            font-size: 1rem;
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

        .product-wrapper .input-group {
            width: 50%;
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
    </style>
@endpush

@section('content')

    <main style="background: #f7f7f7;">
        <article>
            <div class="services-wrapper">
                <div class="container">
                    <div class="mobile-wrapper">
                        <div class="mb-30" id="fashion-search-wrapper">
                            <div>
                                @include('user.fashion.partials.fashion-search')
                            </div>
                        </div>
                    </div>
                    <div class="mb-30 hidden-sm" id="fashion-search-wrapper">
                        @include('user.fashion.partials.fashion-category-menu')

                    </div>
                    <div>
                        <div>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('fashion.index') }}">Home</a>
                                </li>
                                <li class="breadcrumb-item active">All products</li>
                            </ul>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 col-md-4 mt-20">
                                <div class="checkout-wrapper">
                                    {{--  <div>
                                        <h6>All Products</h6>
                                        @foreach ($categories as $cat)
                                            <div>
                                                <a href="dresses.html">
                                                    <i class="fa fa-angle-right mr-2"></i>
                                                    {{ $cat->name }}
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                    <br>  --}}
                                    <h6>Filter Results</h6>
                                    <form action="{{route('fashion.search.filter')}}" method="post">
                                        @csrf
                                        <!-- <label class="mt-10">Color</label>
                                        <div>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="black" name="">
                                                <label class="custom-control-label" for="black">
                                                    <p>Black</p>
                                                </label>
                                            </div>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="white" name="">
                                                <label class="custom-control-label" for="white">
                                                    <p>White</p>
                                                </label>
                                            </div>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="multi" name="">
                                                <label class="custom-control-label" for="multi">
                                                    <p>Multi-Colors</p>
                                                </label>
                                            </div>
                                        </div> -->

                                        <label class="mt-10">Discount</label>
                                        <input type="hidden" name="category" value="{{$cat}}">
                                        <input type="hidden" name="term" value="{{$term}}">
                                        <div>
                                            <div class="custom-control custom-checkbox">
                                                <input type="radio" value="50" class="custom-control-input" id="fifty" name="discount">
                                                <label class="custom-control-label" for="fifty">
                                                    <p>50% off or more</p>
                                                </label>
                                            </div>
                                            <div class="custom-control custom-checkbox">
                                                <input type="radio" value="30" class="custom-control-input" id="thirty" name="discount">
                                                <label class="custom-control-label" for="thirty">
                                                    <p>30% off or more</p>
                                                </label>
                                            </div>
                                            <div class="custom-control custom-checkbox">
                                                <input type="radio" value="20" class="custom-control-input" id="twenty" name="discount">
                                                <label class="custom-control-label" for="twenty">
                                                    <p>20% off or more</p>
                                                </label>
                                            </div>
                                        </div>

                                        <!-- <label class="mt-10">Size</label>
                                        <div>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="small" name="">
                                                <label class="custom-control-label" for="small">
                                                    <p>Small</p>
                                                </label>
                                            </div>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="medium" name="">
                                                <label class="custom-control-label" for="medium">
                                                    <p>Medium</p>
                                                </label>
                                            </div>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="large" name="">
                                                <label class="custom-control-label" for="large">
                                                    <p>Large</p>
                                                </label>
                                            </div>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="extralarge"
                                                       name="">
                                                <label class="custom-control-label" for="extralarge">
                                                    <p>Xtra Large</p>
                                                </label>
                                            </div>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="extraxtralarge"
                                                       name="">
                                                <label class="custom-control-label" for="extraxtralarge">
                                                    <p>Extra xtra-large</p>
                                                </label>
                                            </div>
                                        </div> -->
                                        
                                        <!-- <label class="mt-10">Brands</label>
                                        <div>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="dress" name="">
                                                <label class="custom-control-label" for="dress">
                                                    <p>Dress Senze Store</p>
                                                </label>
                                            </div>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="batiq" name="">
                                                <label class="custom-control-label" for="batiq">
                                                    <p>Batiq Africa</p>
                                                </label>
                                            </div>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="kulture"
                                                       name="">
                                                <label class="custom-control-label" for="kulture">
                                                    <p>Kulture Clothing</p>
                                                </label>
                                            </div>
                                        </div> -->
                                        <label class="mt-10">Price range (0 to 1,000,000)</label><br>
                                            <input type="range" name="range" step="1000" min="0" max="200000" value="" onchange="rangePrimary.value=value"><br>
                                            <input type="text" name="price" class="form-control" id="rangePrimary" readonly/>

                                            <button type="submit" class="btn btn-outline-info btn-start mt-4">Filter</button>
                                    </form>
                                </div>
                            </div>
                            <div class="col-lg-9 col-md-8">
                                <div class="text-center mb-4">
                                    <h5>All Products</h5>
                                    @if(request()->routeIs('fashion.search'))
                                    <p>{{$products->total()}} @else {{count($products)}} @endif products found for "{{$term}}"</p>
                                </div>
                                <div class="row">
                                    @foreach ($products as $product)
                                        <div class="col-lg-4 col-md-4 col-sm-6 col-6 mb-5">
                                            <div class="single-product">
                                                <div class="recommended-wrapper">
                                                    <div class="prdimg">
                                                        <a href="{{ route('fashion.product.show', $product) }}">
                                                            <img
                                                                src="{{ asset($product->getFirstMediaUrl(\App\Enums\MediaCollectionNames::FEATURED_IMAGE)) }}"
                                                                class="img-fluid" alt="">
                                                        </a>
                                                    </div>
                                                    <div class="text-center">
                                                        <p><a href="{{ route('fashion.product.show', $product) }}" class="text-secondary">{{ Str::limit(ucwords($product->name), 20) }}</a></p>
                                                        <span>&#8358;{{ number_format($product->price, 2) }}</span>
                                                    </div>
                                                    <div class="productdetails-wrapper">
                                                        <div class="d-flex">
                                                            {{--  <button class="btn btn-info btn-join shopping-btn"
                                                                    title="Add to cart"><i
                                                                    class="fa fa-shopping-bag"></i></button>
                                                            <button class="btn btn-info btn-join quickview-btn"
                                                                    title="Quick View" data-toggle="modal"
                                                                    data-target="#myModal"><i class="fa fa-eye"></i>
                                                            </button>  --}}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    @endforeach
                                </div>

                                <div class="float-right">
                                    @if(request()->routeIs('fashion.search'))
                                    {{ $products->links()}}
                                    @endif

                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </article>
    </main>

@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            $('#fashion-navbar .categories-desktop ul.nav .btn-group').hover(function () {
                $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeIn(500);
            }, function () {
                $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeOut(500);
            });
        });
    </script>
@endpush
