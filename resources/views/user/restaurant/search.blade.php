@extends('layouts.master')

@section('title', config('app.name', 'Laravel'))

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="{{ asset('css/select2-bootstrap.min.css') }}" rel="stylesheet" />
    <style>

        .select2-container--bootstrap{
            width: 100% !important;
        }
        .select2-container--bootstrap .select2-selection--single{
            border-radius: 4px;
            padding: .65rem 1rem;
        }
        .select2-container .select2-selection--single {
            height: fit-content;
            border-radius: 0px;
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
        <div class="container">
            <h5 class="mt-60 bold">Search Results</h5>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <ul class="nav nav-pills">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link p-3 active" id="location-tab" data-toggle="tab" href="#location" role="tab" aria-controls="location" aria-selected="true">Search Restaurant Location</a>
                          </li>
                          <li class="nav-item" role="presentation">
                            <a class="nav-link p-3" id="name-tab" data-toggle="tab" href="#name" role="tab" aria-controls="name" aria-selected="false">Search by Restaurant Name</a>
                          </li>
                    </ul>
                    @include('user.restaurant.searchform')
                </div>
            </div>

             <div class="results-wrapper">
                <div class="row">
                    <div class="col-lg-5 col-md-5">
                        <div class="d-flex" id="location">
                            <div>
                                <i class="fa fa-lg fa-location-arrow" style="margin-top: 20px; margin-right: 15px;"></i>
                            </div>
                            <div>
                                <span class="is-uppercase has-ellipsis">SEARCH {{ isset($input['city']) ? 'LOCATION' : 'NAME' }}</span>
                                <div class="change-location"><span class="l-area-name has-ellipsis">{{ isset($input['city']) ? $input['city'] : $input['restaurant'] }}</span></div>
                            </div>
                        </div>

                    </div>
                    <div class="col-lg-5 col-md-5">
                        <form style="display: none">
                            <div class="row">
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Search">
                                        <i class="fa fa-search"></i>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="dropdown filter-dropdown">
                                        <a class="dropdown-toggle" data-toggle="dropdown" href="">
                                            Filter <i class="fa fa-sliders"></i>
                                        </a>
                                        <div class="dropdown-menu">
                                            <p>CUISINES</p>
                                            <div class="row">
                                                <div class="col-lg-6 col-md-6">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" id="african" name="">
                                                        <label class="custom-control-label" for="african">
                                                            <p>African</p>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" id="bakery" name="">
                                                        <label class="custom-control-label" for="bakery">
                                                            <p>Bakery and Cakes</p>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6 col-md-6">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" id="salads" name="">
                                                        <label class="custom-control-label" for="salads">
                                                            <p>Salads</p>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" id="sandwiches" name="">
                                                        <label class="custom-control-label" for="sandwiches">
                                                            <p>Sandwiches</p>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6 col-md-6">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" id="seafood" name="">
                                                        <label class="custom-control-label" for="seafood">
                                                            <p>Seafood</p>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" id="sharwarma" name="">
                                                        <label class="custom-control-label" for="sharwarma">
                                                            <p>Sharwarma</p>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="services-wrapper">
            <div class="container">
                <div>
                    <h4 class="text-left">Vendors</h4>
                    <div class="row">
                        @if (empty($restaurants))
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="text-center py-5">
                                <h5>Oops! There no search result for this area</h5>
                            </div>
                        </div>
                        @else
                            @foreach ($restaurants as $restaurant)
                            @if($restaurant->business)
                            <div class="col-lg-3 col-md-3 col-sm-6">
                                <a href="{{ route('restaurant.show', ['any'=>$restaurant->business->slug]) }}">
                                    <div class="recommended-wrapper text-center">
                                        <img src="{{ ($restaurant->business->getMedia(App\Enums\MediaCollectionNames::LOGO)->isEmpty()) ? 'images/vendor-one.png' : $restaurant->business->getMedia(App\Enums\MediaCollectionNames::LOGO)[0]->getFullUrl() }}" class="img-fluid" alt="">
                                        <div class="mt-20">
                                            <h6>{{ $restaurant->business->name }}</h6>
                                            <h6 class="vendor-food">{{ $restaurant->business->about }} </h6>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            @endif
                            @endforeach

                        @endif


                    </div>
                </div>
                {{--  <div>
                    <h4 class="text-left">More Vendors</h4>
                    <div class="row">
                        <div class="col-lg-3 col-md-3 col-sm-6">
                            <div>
                                <a href="cuisine-store.html">
                                    <img src="images/cuisine-search-one.png" class="img-fluid" alt="">
                                    <div class="mt-20">
                                        <h6>Sanni Grills</h6>
                                        <h6 class="vendor-food">Bakery and Cakes, Breakfast, Breakfast, Salads. 45mins </h6>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-6">
                            <div>
                                <a href="cuisine-store.html">
                                    <img src="images/cuisine-search-two.png" class="img-fluid" alt="">
                                    <div class="mt-20">
                                        <h6>Cafe Licious</h6>
                                        <h6 class="vendor-food">Bakery and Cakes, Breakfast, Breakfast, Salads. 45mins </h6>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-6">
                            <div>
                                <a href="cuisine-store.html">
                                    <img src="images/cuisine-search-three.png" class="img-fluid" alt="">
                                    <div class="mt-20">
                                        <h6>Adega Express</h6>
                                        <h6 class="vendor-food">Bakery and Cakes, Breakfast, Breakfast, Salads. 45mins </h6>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-6">
                            <div>
                                <a href="cuisine-store.html">
                                    <img src="images/cuisine-search-four.png" class="img-fluid" alt="">
                                    <div class="mt-20">
                                        <h6>Bukka Hut</h6>
                                        <h6 class="vendor-food">Bakery and Cakes, Breakfast, Breakfast, Salads. 45mins </h6>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>  --}}
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
