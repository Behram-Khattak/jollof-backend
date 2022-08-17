@extends('layouts.master')

@section('title', config('app.name', 'Cuisine - Search list'))

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="{{ asset('css/select2-bootstrap.min.css') }}" rel="stylesheet" />
    <style>
        .movies-wrapper2 {
            background: none;
            z-index: 1;
            color: #fff;
        }

        .search-wrapper{
            margin-top:30px;
        }

        .how-info{
            display: none;
        }

        .recommended-wrapper {
            overflow: hidden;
            max-height: 330px;
        }

        .recommended-wrapper .img-wrap{
            height: 200px;
            overflow: hidden;
        }

        .recommended-wrapper .img-wrap img{
            width: 100%;
        }

        .recommended-wrapper .img-wrap a{
            display: block;
        }

        .movies-wrapper2 #custom_carousel .item {
            color: #000;
            background-color: #eee;
            padding: 20px 0;
        }

        .movies-wrapper2 #custom_carousel .controls {
            overflow-x: auto;
            overflow-y: hidden;
            padding: 0;
            margin: 0;
            white-space: nowrap;
            text-align: center;
            position: relative;
            background: #ddd
        }

        .movies-wrapper2 #custom_carousel .controls li {
            display: table-cell;
            width: 1%;
            max-width: 90px
        }

        .movies-wrapper2 #custom_carousel .controls li.active {
            background-color: #eee;
            border-top: 3px solid orange;
        }

        .movies-wrapper2 #custom_carousel .controls a small {
            overflow: hidden;
            display: block;
            font-size: 10px;
            margin-top: 5px;
            font-weight: bold
        }

        .select2-container--bootstrap .select2-selection--single{
            border-radius: 4px;
            padding: .65rem 1rem;
        }
        .select2-container .select2-selection--single {
            height: fit-content;
            border-radius: 0px;
        }
        .select2-results__options {
            max-height: 300px;
            overflow:scroll;
        }

        @media screen and (max-width: 768px) {
            .logo-wrapper .navbar-collapse {
                margin: 0px 15px;
            }

        }
    </style>
@endpush

@section('content')

<main>
    <article>
        <br>
        <div class="movies-wrapper2 container">
            {{ show_banner('cuisine', 'slider') }}
            {{-- <div class="container">
                <div>
                    <h2>Jollof Cuisine</h2>
                    <p>Every food you need delivered to your doorstep</p>
                </div>
            </div> --}}
        </div>
        <div class="container">
            <div class="search-wrapper">
                <h4 class="text-center">Discover new restaurants in your locality</h4>
                <ul class="nav nav-pills justify-content-center">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link p-3 active" id="location-tab" data-toggle="tab" href="#location" role="tab" aria-controls="location" aria-selected="true">Search Restaurant Location</a>
                      </li>
                      <li class="nav-item" role="presentation">
                        <a class="nav-link p-3" id="name-tab" data-toggle="tab" href="#name" role="tab" aria-controls="name" aria-selected="false">Search by Restaurant Name</a>
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
                        <form action="{{ route('restaurant.search') }}" method="POST">
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
                                    <button type="submit" class="btn btn-info btn-join">SEARCH</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="name" role="tabpanel" aria-labelledby="name-tab">
                        <form action="{{ route('restaurant.search') }}" method="POST">
                            <label for="">Enter name of restaurant</label>
                            <div class="row">
                                <div class="col-lg-8 col-md-8">
                                    <div class="form-input">

                                        <select name="restaurant" class="form-control select2" id="restaurants" style="margin-top:0px;" required>
                                            <option value="0">All</option>
                                            @foreach ($allRestaurants as $res)
                                            <option value="{{ $res->name }}">{{ $res->name }}</option>
                                            @endforeach
                                        </select>
                                        @csrf
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4">
                                    <button type="submit" class="btn btn-info btn-join">SEARCH</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="services-wrapper">
            <div class="container">
                <div class="how-info">
                    <h3 class="text-center">How it works</h3>
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-4">
                            <div class="cuisine-div">
                                <img src="images/cuisine-one.png" class="img-fluid" alt="">
                                <h6>Search and Set Location</h6>
                                <p>Search for food and enter the location you want the food delivered to</p>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4">
                            <div class="cuisine-div">
                                <img src="images/cuisine-two.png" class="img-fluid" alt="">
                                <h6>Choose your Dish</h6>
                                <p style="padding-bottom: 20px;">Select from our menu for your prefered offer</p>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4">
                            <div class="cuisine-div">
                                <img src="images/cuisine-three.png" class="img-fluid" alt="">
                                <h6>Meet Us at your Door</h6>
                                <p style="padding-bottom: 20px;">Your oder will get to you in short time</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-40">
                    <div>
                        <div class="text-center">
                            <h3>Choose from the most popular restaurants</h3>
                            <p class="mt--15">Choose from some of the popular restaurants around</p>
                        </div>
                        <div class="row mt-30">

                            @forelse ($restaurants as $f)

                                <div class="col-lg-3 col-md-3 col-sm-6 mb-5">
                                        <a href="{{ route('restaurant.show', ['any'=>$f->slug]) }}">
                                            <div class="recommended-wrapper text-center">
                                                <div class="img-wrap">
                                                    <img src="{{ ($f->getMedia(App\Enums\MediaCollectionNames::LOGO)->isEmpty()) ? 'images/vendor-one.png' : $f->getMedia(App\Enums\MediaCollectionNames::LOGO)[0]->getFullUrl() }}" class="img-fluid" alt="">
                                                </div>
                                                <div class="text-left">
                                                    <div class="bg-white">
                                                        <h6>{{ $f->name }}</h6>
                                                        <p>{{ $f->description}}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                </div>

                            @empty
                                <div class="col p-4 m-2">
                                    <p class="text-center">There are no recommended restaurants</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                    {{--  <div class="mt-40">
                        <div class="text-center">
                            <h3>Featured Vendors</h3>

                        </div>
                        <div class="row vendor">
                        @forelse ($featured as $f)
                        <div class="col-lg-4 col-md-4 co12-sm-6">
                            <a href="{{ route('restaurant.show', ['any'=>$f->business->slug]) }}">
                                <div class="recommended-wrapper text-center">
                                    <img src="{{ ($f->business->getMedia(App\Enums\MediaCollectionNames::LOGO)->isEmpty()) ? 'images/vendor-one.png' : $f->business->getMedia(App\Enums\MediaCollectionNames::LOGO)[0]->getFullUrl() }}" class="img-fluid" alt="">
                                    <div class="text-left">
                                        <h6>{{ $f->business->name }}</h6>
                                        <p>{{ $f->business->description}}</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        @empty
                            <div class="col p-4 m-2">
                                <p class="text-center">There are no featured restaurants</p>
                            </div>
                        @endforelse
                        </div>
                    </div>  --}}
                    <div class="row mt-30">
                        <div class="col-lg-6 col-md-6">
                            {{ show_banner('cuisine', 'ad_slot_1') }}
                        </div>
                        <div class="col-lg-6 col-md-6">
                            {{ show_banner('cuisine', 'ad_slot_2') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="newsletter">
            <div class="container">
                <h4>Subscribe to our newsletter</h4>
                <hr>
                <form>
                    <div class="row">
                        <div class="col-lg-4 col-md-4">
                            <div class="form-input">
                                <input type="text" class="form-control" name="search" placeholder="Your name">
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4">
                            <div class="form-input">
                                <input type="email" class="form-control" name="search" placeholder="yourname@gmail.com">
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4">
                            <a href="cuisine-search.html" class="btn btn-info btn-join">Subscribe</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </article>
</main>
<div id="state-data" style="display: none;">{{ json_encode(locations_json()) }}</div>
@endsection


@push('scripts')

{{--  <script>
    jQuery(document).ready(function () {
        //$('.select2').select2();
        $('state-data').hide();

        $("#states").change("#states", function(){
            var state = $(this).val();
            var data = JSON.parse($("#state-data").html());

            var areas = data[state];

            $.each(areas, function(index, value) {
                $("#areas").append("<option value='"+ index +"'>" + value + "</option>");
            });
        });


    });
</script>  --}}


<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    jQuery(document).ready(function () {

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

        $('#restaurants').select2({
            placeholder: "Search Restaurant Name",
            theme: "bootstrap",
            width: 'element',
            minimumResultsForSearch: Infinity
        });

    });
</script>

@endpush
