@extends('layouts.master')

@section('title', 'Fashion | All Products | Jollof')


@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="css/select2-bootstrap.min.css" rel="stylesheet" />

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
            max-height: 330px;
        }
        .recommended-wrapper .img-wrap{
            height: 250px;
            text-align: center;
            overflow: hidden;
            padding: 5px;
}
        }

        .recommended-wrapper > div {
            padding: 20px 10px 10px 10px;
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

        .select2-container--bootstrap .select2-selection--single{
            border-radius: 4px;
            padding: .65rem 1rem;
        }
        .select2-container .select2-selection--single {
            height: fit-content;
            border-radius: 0px;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid #ced4da;
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
                                <li class="breadcrumb-item active">All Fashion Stores</li>
                            </ul>
                        </div>
                        <div class="row">

                            <div class="col-lg-12 col-md-12">

                                <h4 class="text-center">Discover fashion stores in your locality</h4>
                                <ul class="nav nav-pills justify-content-center">
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link p-3 active" id="location-tab" data-toggle="tab" href="#location" role="tab" aria-controls="location" aria-selected="true">Search by Location</a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link p-3" id="name-tab" data-toggle="tab" href="#name" role="tab" aria-controls="name" aria-selected="false">Search by Name</a>
                                    </li>
                                </ul>

                                @if ($errors->any())
                                    <div class="alert alert-danger mt-3">
                                        <ul class="mb-0">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <div class="tab-content mt-3">
                                    <div class="tab-pane fade show active" id="location" role="tabpanel" aria-labelledby="location-tab">
                                        <form action="{{ route('fashion.store.search') }}" method="POST">
                                            <label for="">Delivery location</label>
                                            <div class="row">
                                                <div class="col-lg-4 col-md-4">
                                                    <div class="form-input">
                                                        <select name="state" class="form-control select2" id="states" style="margin-top:0px;" required>
                                                            <option value="">Select State</option>
                                                            @foreach (get_states() as $state_id => $state)
                                                            <option value="{{ $state_id }}">{{ $state }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-4">
                                                    <div class="form-input">
                                                        <select name="city" class="form-control select2" id="areas" style="margin-top:0px;" required>
                                                        </select>
                                                        @csrf
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-4">
                                                    <button type="submit" class="btn btn-info btn-join mt-0">SEARCH</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="tab-pane fade" id="name" role="tabpanel" aria-labelledby="name-tab">
                                        <form action="{{ route('fashion.store.search') }}" method="POST">
                                            <label for="">Enter name of store</label>
                                            <div class="row">
                                                <div class="col-lg-8 col-md-8">
                                                    <div class="form-input">
                                                        <select name="store" class="form-control select2 mt-0" id="namesearch" required>
                                                            <option value="0">All</option>
                                                            @foreach ($stores as $store)
                                                            <option value="{{ $store->name }}">{{ $store->name }}</option>
                                                            @endforeach

                                                        </select>
                                                        @csrf
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-4">
                                                    <button type="submit" class="btn btn-info btn-join mt-0">SEARCH</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <div class="row mt-4">
                                    <div class="col-md-12">
                                        <h5 class="text-center">Fashion Stores</h5>
                                    </div>
                                </div>
                                @if($stores->count() > 0)
                                <div class="row mt-3">
                                    @foreach ($stores as $store)
                                        <div class="col-lg-3 col-md-3 col-sm-6 col-6 mb-5">
                                            <div class="single-product">
                                                <a href="{{ route('fashion.store.show', $store) }}">
                                                <div class="recommended-wrapper">
                                                    <div class="img-wrap">
                                                            <img
                                                                src="{{ asset($store->getFirstMediaUrl(\App\Enums\MediaCollectionNames::LOGO)) }}"
                                                                class="img-fluid" alt="">
                                                    </div>
                                                    <div class="text-center">
                                                        <p><a href="{{ route('fashion.store.show', $store) }}" class="text-secondary">{{ Str::limit(ucwords($store->name), 20) }}</a></p>
                                                        <span>{{ count($store->locations) }} {{ count($store->locations) > 1 ? 'locations' : 'location' }}</span>
                                                    </div>
                                                </div>
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="float-right">

                                    {{ $stores->links() }}

                                </div>

                                @else

                                    <div class="col-lg-12 col-md-12">
                                        <p class="my-5 py-5 text-center">
                                            No stores found
                                        </p>
                                    </div>

                                @endif

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </article>
    </main>
    <div id="state-data" style="display: none;">{{ json_encode(locations_json()) }}</div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#fashion-navbar .categories-desktop ul.nav .btn-group').hover(function () {
                $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeIn(500);
            }, function () {
                $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeOut(500);
            });


            $('state-data').hide();

            $("#states").change("#states", function(){
                var state = $(this).val();
                var data = JSON.parse($("#state-data").html());

                var areas = data[state];

                $.each(areas, function(index, value) {
                    $("#areas").append("<option value='"+ index +"'>" + value + "</option>");
                });
            });

            $('#areas').select2({
                placeholder: "Select City/Area",
                theme: "bootstrap"
            });

            $('#namesearch').select2({
                placeholder: "Search Store",
                theme: "bootstrap"
            });
        });
    </script>
@endpush
