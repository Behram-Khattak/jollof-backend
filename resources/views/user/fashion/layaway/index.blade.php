@extends('layouts.master')

@section('title', 'Fashion | Jollof')

@push('styles')
    <style>
        body {
            background: #f7f7f7;
        }

        .navbar, .nav-link {
            padding: 0.5rem 1rem;
        }

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

        .btn.btn-info.btn-join {
            margin-top: 7px;
            width: 100%;
        }

        .services-wrapper {
            padding-top: 50px;
        }

        .services-wrapper h4 {
            color: #2b2b2b;
        }

        .services-wrapper .pull-right a {
            color: #eb6323;
            margin-top: 47px;
            font-weight: 400;
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
            opacity: 0.9;
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
            width: 55%;
        }

        .modal-dialog {
            max-width: 700px;
        }

        .btn.btn-info.btn-join.quickview-btn {
            color: #eb6323;
        }

        .movie-div {
            padding: 100px 0;
            height:350px;
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

        @media screen and (max-width: 550px) {
            .navbar-nav.cart-nav-mobile .dropdown-menu {
                left: auto;
                top: 40px;
            }
        }
    </style>
@endpush

@section('content')
    <main>
        <article>
            <div class="services-wrapper">
                <div class="container">
                    @include('partials._flash')

                    <!-- for mobile -->
                    <div class="mobile-wrapper">
                        <div class="mb-30" id="fashion-search-wrapper">
                            
                        </div>
                        <div>
                            {{ show_banner('fashion', 'slider') }}
                        </div>
                    </div>

                    <!-- for desktop -->
                    @include('user.fashion.partials.fashion-category-menu')

                </div>
                <div class="container">
                    <div class="mt-40">
                        <div>
                            <div class="d-flex" style="justify-content: space-between;">
                                <div>
                                    <h4 class="text-left">Layaway Products</h4>
                                </div>

                                <!-- <div class="pull-right">
                                    <a href="{{ route('fashion.all_products') }}">See more layaways</a>
                                </div> -->
                            </div>

                            <div class="row">
                                @foreach ($layaways as $product)
                                <div class="col-lg-3 col-md-3 col-sm-6 col-6">
                                    <div class="single-product mb-5">
                                        <div class="recommended-wrapper">
                                            <div class="prdimg">
                                                <a href="{{ route('fashion.layaway.product.show', $product->slug) }}">
                                                    <img src="{{ asset($product->getFirstMediaUrl(\App\Enums\MediaCollectionNames::FEATURED_IMAGE)) }}" class="img-fluid" alt="">
                                                </a>
                                            </div>
                                            <div class="text-center">
                                                <p>{{ Str::limit(ucwords($product->name), 20) }}</p>
                                                <span>&#8358;{{ number_format($product->price, 2) }}</span>
                                            </div>
                                            <div class="productdetails-wrapper">
                                                {{--  <div class="d-flex">
                                                    <button class="btn btn-info btn-join shopping-btn"
                                                            title="Add to cart"><i class="fa fa-shopping-bag"></i>
                                                    </button>
                                                    <button class="btn btn-info btn-join quickview-btn"
                                                            title="Quick View" data-toggle="modal"
                                                            data-target="#myModal"><i class="fa fa-eye"></i></button>
                                                </div>  --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                <div style="margin:auto; padding:auto;">
                                    {{$layaways->links()}}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            {{ show_banner('fashion', 'ad_slot_1') }}
                        </div>
                        <div class="col-lg-6 col-md-6">
                            {{ show_banner('fashion', 'ad_slot_2') }}
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
            // $('.gallery').slick({
            //     dots: false,
            //     arrows: false,
            //     infinite: true,
            //     speed: 500,
            //     autoplay: true,
            //     autoplaySpeed: 2000,
            //     fade: false,
            //     cssEase: 'ease',
            //     pauseOnHover: false
            // });

            $('#fashion-navbar .categories-desktop ul.nav .btn-group').hover(function () {
                $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeIn(500);
            }, function () {
                $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeOut(500);
            });
        });
    </script>
@endpush
