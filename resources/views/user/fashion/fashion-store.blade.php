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
            overflow: hidden;
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

        .movie-div{
            border-radius: 10px;
            padding: 100px 0 100px;
            /**height: 380px;**/
            height: 278px;
        }

        .product-wrapper .input-group {
            width: auto;
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

                    <!-- for mobile -->
                    <div class="mobile-wrapper">
                        <div class="mb-30" id="fashion-search-wrapper">
                            <div>
                                @include('user.fashion.partials.fashion-search')
                            </div>
                        </div>
                        <div>
                            {{ show_banner('fashion', 'slider') }}
                        </div>
                    </div>

                    <!-- for desktop -->
                    @include('user.fashion.partials.fashion-category-menu')

                </div>
                <div class="container">
                    <div>
                        <div>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('fashion.index') }}">Home</a>
                                </li>
                                <li class="breadcrumb-item active">{{ $business->name }}</li>
                            </ul>
                        </div>
                        <div class="row">

                            <div class="col-lg-12 col-md-12">
                                <div class="text-center mb-4">
                                    <h5>All Products</h5>
                                    <p>{{ $products->count() }} products found</p>
                                </div>
                                <div class="row">
                                    @foreach ($products as $product)
                                        <div class="col-lg-3 col-md-3 col-sm-6 col-6 mb-5">
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

                                    {{-- $products->links() --}}

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
