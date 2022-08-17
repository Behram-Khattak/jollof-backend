@extends('layouts.master')

@section('title', 'Welcome to Jollof')

@push('styles')

    <style>
        #cookie-law {
            display: flex;
            align-items: center;
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background-color: #ffffff;
            z-index: 999;
        }

        .carousel-control-prev-icon,
        .carousel-control-next-icon  {
            background-color: black;
            border-radius: 50%;
        }



    </style>
    <!-- Rating stars -->
    <style type="text/css">
        /* 
            Use :not with impossible condition so inputs are only hidden 
            if pseudo selectors are supported. Otherwise the user would see
            no inputs and no highlighted stars.
        */
        .rating input[type="radio"]:not(:nth-of-type(0)) {
            /* hide visually */    
            border: 0;
            clip: rect(0 0 0 0);
            height: 1px;
            margin: -1px;
            overflow: hidden;
            padding: 0;
            position: absolute;
            width: 1px;
        }
        .rating [type="radio"]:not(:nth-of-type(0)) + label {
            display: none;
            font-size: 1.2em;
        }
        
        label[for]:hover {
            cursor: pointer;
            /* font-size: 1.2em */
        }
        
        .rating .stars label:before {
            content: "★";
        }
        
        .stars label {
            color: lightgray;
        }
        
        .stars label:hover {
            text-shadow: 0 0 1px #000;
            font-size: 1.2em;
        }
        
        .rating [type="radio"]:nth-of-type(1):checked ~ .stars label:nth-of-type(-n+1),
        .rating [type="radio"]:nth-of-type(2):checked ~ .stars label:nth-of-type(-n+2),
        .rating [type="radio"]:nth-of-type(3):checked ~ .stars label:nth-of-type(-n+3),
        .rating [type="radio"]:nth-of-type(4):checked ~ .stars label:nth-of-type(-n+4),
        .rating [type="radio"]:nth-of-type(5):checked ~ .stars label:nth-of-type(-n+5) {
            color: orange;
            font-size: 1.2em;

        }
        
        .rating [type="radio"]:nth-of-type(1):focus ~ .stars label:nth-of-type(1),
        .rating [type="radio"]:nth-of-type(2):focus ~ .stars label:nth-of-type(2),
        .rating [type="radio"]:nth-of-type(3):focus ~ .stars label:nth-of-type(3),
        .rating [type="radio"]:nth-of-type(4):focus ~ .stars label:nth-of-type(4),
        .rating [type="radio"]:nth-of-type(5):focus ~ .stars label:nth-of-type(5) {
            color: darkorange;
            width: 10px;
            /* font-size: 2.2em; */
        }
    </style>
@endpush

@section('content')

<main>
    @include('partials._flash')
    <article>
        <br>
        <div class="container">
            {{ show_banner('jollof', 'slider') }}
        </div>
        @if(session('message'))
            <alert-component variant="{{ session('message.type') }}"
                body="{{ session('message.body') }}" :dismissible="true">
            </alert-component>
        @endif
        <div class="services-wrapper">
            <div class="container">
                <div class="row">
                    @if ($images)
                        @foreach ($images as $image)
                            @php
                                $publicUrl = $image->getFirstMediaUrl('homeblock');
                            @endphp
                            @if($image->status && $image->name == 'Cuisine' || $image->name == 'Fashion')
                                <div class="col-lg-4 col-md-4 col-sm-6">
                                    <a href="{{ url($image->site) }}">
                                        <div class="cuisine" style="background: linear-gradient(rgba(44, 51, 58, 0.5), rgba(44, 51, 58, 0)), url({{ $publicUrl }});">
                                            <h4>{{ $image->name }}</h4>
                                            <span>{{$image->slogan ?? "..." }}</span>
                                            <p>Explore</p>
                                        </div>
                                    </a>
                                </div>
                            @else
                                <div class="col-lg-4 col-md-4 col-sm-6">
                                    <a href="#comingsoon"  data-toggle="modal" data-target="#comingsoon">
                                        <div class="cuisine" style="background: linear-gradient(rgba(44, 51, 58, 0.5), rgba(44, 51, 58, 0)), url({{ $publicUrl }});">
                                            <h4>{{ $image->name }}</h4>
                                            <span>{{$image->slogan ?? "..." }}</span>
                                            <p>Explore</p>
                                        </div>
                                    </a>
                                </div>
                            @endif
                            @php
                                unset($sites[$image->site])
                            @endphp
                        @endforeach
                    @endif

                    @if (count($sites) > 0)
                        @foreach ($sites as $key => $site)
                        <div class="col-lg-4 col-md-4 col-sm-6">
                            <a href="#comingsoon"  data-toggle="modal" data-target="#comingsoon">
                                <div class="cuisine lifestyle">
                                    <h4>{{ $site }}</h4>
                                    <span>Explore the beauty of culture </span>
                                    <p>Explore</p>
                                </div>
                            </a>
                        </div>
                        @endforeach
                    @endif
                </div>

                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        {{ show_banner('jollof', 'ad_slot_1') }}
                    </div>
                    <div class="col-lg-6 col-md-6">
                        {{ show_banner('jollof', 'ad_slot_2') }}
                    </div>
                </div>
                {{--  Include partners  --}}
                
            </div>
        </div>

        @include('partials._newsletter')
    </article>
</main>

<!-- Review modal -->

@auth
@if(!empty($orderItem) && strtotime(Carbon\Carbon::now()) > strtotime($orderItem->delivery_timestamp))

    <div class="modal fade" id="review" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Welcome back, Kindly review your most recent order</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card mb-3" style="max-width: 540px;">
                        <div class="row no-gutters">
                            <div class="col-md-4">
                                <img src="{{$orderItem->img ?? ''}}" class="card-img" alt="{{$orderItem->name}}">
                            </div>
                            <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title">{{$orderItem->name}}</h5>
                                <p class="card-text">Order Code: {{$orderItem->order->order_code}}</p>
                                <p class="card-text">Sub total: ₦{{number_format($orderItem->order->subtotal,2)}}</p>
                                <p class="card-text">Total: ₦{{number_format($orderItem->order->total,2)}}</p>
                                <p class="card-text"><small class="text-muted">Delivered: {{\Carbon\Carbon::parse($orderItem->delivery_timestamp)->diffForHumans()}}</small></p>
                            </div>
                            </div>
                        </div>
                    </div>
                    <form method="post" action="{{ route('restaurant.review') }}">
                        @csrf
                        <input type="hidden" name="model_id" value="{{ $orderItem->model_id ?? $orderItem->business_id}}" />
                        <input type="hidden" name="model_type" value="{{ $orderItem->model }}" />                    
                        <input type="hidden" name="order_id" value="{{ $orderItem->order->id }}" />                    
                        <input type="hidden" name="business_id" value="{{$orderItem->business_id}}" />                    
                            <label>5 Star rating</label>
                            <div class="rating">
                                <input id="demo-1" type="radio" name="star" value="1"> 
                                <label for="demo-1">1 star</label>
                                <input id="demo-2" type="radio" name="star" value="2">
                                <label for="demo-2">2 stars</label>
                                <input id="demo-3" type="radio" name="star" value="3">
                                <label for="demo-3">3 stars</label>
                                <input id="demo-4" type="radio" name="star" value="4">
                                <label for="demo-4">4 stars</label>
                                <input id="demo-5" type="radio" name="star" value="5">
                                <label for="demo-5">5 stars</label>
                                
                                <div class="stars">
                                    <label for="demo-1" aria-label="1 star" title="1 star"></label>
                                    <label for="demo-2" aria-label="2 stars" title="2 stars"></label>
                                    <label for="demo-3" aria-label="3 stars" title="3 stars"></label>
                                    <label for="demo-4" aria-label="4 stars" title="4 stars"></label>
                                    <label for="demo-5" aria-label="5 stars" title="5 stars"></label>   
                                </div>
                                
                            </div>
                            <div class="col-lg-12 col-md-12 px-0">
                            <label>Write a review</label>
                            <div class="form-group">
                                <textarea class="form-control" name="review" rows="4"
                                placeholder="Enter your Review" required></textarea>
                            </div>
                        </div>
                            <script>
                                (function(){
                                    var rating = document.querySelector('.rating');
                                    var handle = document.getElementById('toggle-rating');
                                    handle.onchange = function(event) {
                                        rating.classList.toggle('rating', handle.checked);
                                    };
                                }());
                            </script>                        
                        <button type="submit" class="btn btn-info btn-join mt-30">Submit</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endif
@endauth

@endsection

@push('scripts')
<script>
    var CookieBanner = (function() {
        return {
            'createCookieWhenBannerIsShown': false,
            'createCookieWhenAcceptIsClicked': true,
            'cookieDuration': 14,                   // Number of days before the cookie expires, and the banner reappears
            'cookieName': 'cookieConsent',          // Name of our cookie
            'cookieValue': 'accepted',              // Value of cookie

            '_createDiv': function(html) {
                var bodytag = document.getElementsByTagName('body')[0];
                var div = document.createElement('div');
                div.setAttribute('id','cookie-law');
                div.innerHTML = html;

                // bodytag.appendChild(div); // Adds the Cookie Law Banner just before the closing </body> tag
                // or
                bodytag.insertBefore(div,bodytag.firstChild); // Adds the Cookie Law Banner just after the opening <body> tag

                document.getElementsByTagName('body')[0].className+=' cookiebanner'; //Adds a class tothe <body> tag when the banner is visible

                if (CookieBanner.createCookieWhenBannerIsShown) {
                    CookieBanner.createAcceptCookie();
                }
            },

            '_createCookie': function(name, value, days) {
                var expires;
                if (days) {
                    var date = new Date();
                    date.setTime(date.getTime()+(days*24*60*60*1000));
                    expires = "; expires="+date.toGMTString();
                }
                else {
                    expires = "";
                }
                document.cookie = name+"="+value+expires+"; path=/";
            },

            '_checkCookie': function(name) {
                var nameEQ = name + "=";
                var ca = document.cookie.split(';');
                for(var i=0;i < ca.length;i++) {
                    var c = ca[i];
                    while (c.charAt(0)==' ') c = c.substring(1,c.length);
                    if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
                }
                return null;
            },

            '_eraseCookie': function(name) {
                CookieBanner._createCookie(name,"",-1);
            },

            'createAcceptCookie': function() {
                CookieBanner._createCookie(CookieBanner.cookieName, CookieBanner.cookieValue, CookieBanner.cookieDuration); // Create the cookie
            },

            'closeBanner': function() {
                var element = document.getElementById('cookie-law');
                element.parentNode.removeChild(element);
            },

            'accept': function() {
                CookieBanner.createAcceptCookie();
                CookieBanner.closeBanner();
            },

            'showUnlessAccepted': function(html) {
                //alert(CookieBanner._checkCookie(CookieBanner.cookieName));
                //alert(document.cookie);
                if(CookieBanner._checkCookie(CookieBanner.cookieName) != CookieBanner.cookieValue){
                    CookieBanner._createDiv(html);
                }
            }

        }

    })();

    window.onload = function(){

        var html = '<div class="container py-5 px-3">' +
                '<div class="row">' +
                    '<div class="col-md-10">' +
                        '<p class="text-left">' +
                            'Jollof.com use cookies to offer you the best online experience on our website. By using our website, you are' +
                            'consenting to our use of cookies policy. See our <a href="{{ route('privacy_policy') }}">Cookies and Privacy Notice</a> for details on how we process your' +
                            'data and use cookies.' +
                        '</p>' +
                    '</div>' +
                    '<div class="col-md-2">' +
                        '<button href="javascript:void(0);" onclick="CookieBanner.accept();" class="btn btn-sm btn-outline-primary">Accept</button>' +
                    '</div>' +
                '</div>' +
            '</div>' ;

        CookieBanner.showUnlessAccepted(html);
    }

    // show modal is orderitems is empty
    @if(!empty($orderItem))
        $('#review').modal('show');
    @endif
</script>


@endpush
