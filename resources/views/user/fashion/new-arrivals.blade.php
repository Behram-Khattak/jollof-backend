@extends('layouts.master')

@push('styles')
    <style>
        body {
            background: #f7f7f7;
        }

        .navbar, .nav-link {
            padding: 0.5rem 1rem;
        }

        .logo-wrapper.shopping-categories .navbar .navbar-nav .nav-link {
            font-size: 14px;
            padding-left: 0;
            padding-right: 30px;
        }

        .btn.btn-info.btn-join {
            margin-top: 7px;
            width: 100%;
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

        .product-wrapper .input-group {
            width: 55%;
        }

        .modal-dialog {
            max-width: 700px;
        }

        .btn.btn-info.btn-join.quickview-btn {
            color: #eb6323;
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
    </style>
@endpush

@section('content')
    <main>
        <article>
            <div class="services-wrapper">
                <div class="container">
                    <div>
                        <div class="d-flex">
                            <div>
                                <h4 class="text-left">New Arrivals</h4>
                            </div>
                            <div id="fashion-search" style="margin-left: 20px; margin-top: 15px;">
                                <div class="form-group" style="position: relative;">
                                    <input type="text" class="form-control" placeholder="Search">
                                    <i class="fa fa-search search-icon"></i>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-30">
                            @foreach($products as $product)
                                <div class="col-lg-3 col-md-3 col-sm-6 col-6">
                                    <a href="{{ route('fashion.product.show', $product) }}">
                                        <div>
                                            <img src="{{ asset($product->getFirstMediaUrl(\App\Enums\MediaCollectionNames::FEATURED_IMAGE)) }}" class="img-fluid" alt="">
                                            <div>
                                                <p class="mb-0">{{ Str::limit(ucwords($product->name), 28) }}</p>
                                                <p class="bold">&#8358;{{ number_format($product->price, 2) }} </p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
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
