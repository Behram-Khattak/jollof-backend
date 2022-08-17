@extends('layouts.master')

@section('title', 'My Account | Jollof')

@push('styles')
<style>
    body {
        background: #f7f7f7;
    }

    .navbar,
    .nav-link {
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

    .recommended-wrapper>div {
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
        height: 350px;
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

    .content {
        margin-top: 20px;
        width: auto;
        /* height: 400px; */
        height: fit-content;
        overflow: scroll;
        scrollbar-width: none;
        scrollbar-color: red;
        background-color: #f1f1f1;
        border: 1px black;
        /* border-radius:9px; */
    }
</style>
@endpush

@section('content')
<!-- <div class="mobile-wrapper">
    <div class="mb-30" id="fashion-search-wrapper">
        <div>
            @include('user.fashion.partials.fashion-search')
        </div>
    </div>
    <div>
    </div>
</div> -->
<div class="services-wrapper">
    <div class="container">

        <!-- for mobile -->
        <div class="mobile-wrapper">
            <div class="mb-3" id="fashion-search-wrapper">
                <div>
                    <div class="row">
                        <form action="{{ route('fashion.search') }}" method="POST" class="form-inline w-100">
                            <div class="col-lg-9 col-md-9 input-group-col">
                                <!-- <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <select name="category" style="border: none;" class="form-control text-grey" >
                                                            <option selected value="0">All Categories</option>
                                                            @foreach ($categories as $category)

                                                            <option value="{{ $category->id }}">{{ $category->name }}</option>

                                                            @endforeach

                                                        </select>
                                                    </div>
                                                    <input type="text" name="fashion" class="form-control py-0"
                                                    placeholder="Search Product">
                                                </div> -->
                                <nav class="navbar navbar-default" role="navigation" id="fashion-navbar">
                                    <div class="navbar-header">
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6">
                                                <div>
                                                    <h5><a class="navbar-brand" href="#top"><br>MY ACCOUNT</a><br>
                                                        <p>Hi, {{auth()->user()->first_name}}</p>
                                                    </h5>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6">
                                                <div class="text-right">
                                                    <button type="button" class="navbar-toggler x collapsed" data-toggle="collapse" data-target="#navbar-collapse-y">
                                                        <i class="fa fa-bars"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="collapse navbar-collapse" id="navbar-collapse-y">
                                        <ul class="nav navbar-nav navbar-right">
                                            <div class="btn-group dropright mt-3">
                                                <a class="dropdown-toggle" data-toggle="dropdown" target="order" aria-haspopup="true" href="#" onclick="populateData(event)" aria-expanded="false">
                                                    My Orders
                                                </a>
                                            </div>
                                            <div class="btn-group dropright mt-3">
                                                <a class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" href="#" aria-expanded="false" target="vendors" onclick="populateData(event)">
                                                    Recent Vendors
                                                </a>
                                            </div>
                                            <div class="btn-group dropright mt-3">
                                                <a class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" href="#" aria-expanded="false" target="layaway" onclick="populateData(event)">
                                                    My Layaways
                                                </a>
                                            </div>
                                            <div class="btn-group dropright mt-3">
                                                <a class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" href="#" aria-expanded="false" target="reviews" onclick="populateData(event)">
                                                    My Reviews
                                                </a>
                                            </div>
                                            <div class="btn-group dropright mt-3">
                                                <a class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" href="#" aria-expanded="false" target="settings" onclick="populateData(event)">
                                                    Account Setting
                                                </a>
                                            </div>
                                            @if(auth()->user()->roles->pluck('name')[0] != 'user')
                                            <div class="btn-group dropright mt-3">
                                                <a href="{{(auth()->user()->roles->pluck('name')[0] == 'super-admin' ? 'admin' : auth()->user()->roles->pluck('name')[0])}}" aria-expanded="false">
                                                    Dashboard
                                                </a>
                                            </div>
                                            @endif

                                            <div class="btn-group dropright mt-3">
                                                <a class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" href="#" aria-expanded="false" target="referals" onclick="populateData(event)">
                                                    Referral
                                                </a>
                                            </div>
                                            <div class="btn-group dropright mt-3">
                                                <a class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" href="#" aria-expanded="false" target="password" onclick="populateData(event)">
                                                    Change Password
                                                </a>
                                            </div>
                                            <div class="btn-group dropright mt-3">
                                                <a class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" href="#" onclick="logout()" aria-expanded="false">
                                                    Logout
                                                </a>
                                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                                    @csrf
                                                </form>
                                            </div>
                                    </div>
                                    </ul>
                            </div>

                            </nav>
                            @csrf
                    </div>
                    <div class="col-lg-3 col-md-3 searchbtn">
                        <input type="text" class="form-control" placeholder="Points" aria-label="Points" aria-describedby="basic-addon1" value="Total Points: {{auth()->user()->points}}" disabled>
                    </div>
                    </form>
                </div>
            </div>
            <div>
                <div class="content" id="content-mobile">

                </div>
            </div>
        </div>
    </div>
</div>

<!-- for desktop -->
<!-- @include('user.fashion.partials.fashion-category-menu') -->

</div>
<div class="container hidden-sm" style="padding-left: 0; padding-right: 0; margin-top: 20px">
    <div class="row">
        <div class="col-lg-3">
            <nav class="navbar navbar-default" role="navigation" id="fashion-navbar">
                <div class="navbar-header">
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <div>
                                <h5><a class="navbar-brand" href="#top"><br>MY ACCOUNT</a><br>
                                    <p>Hi, {{auth()->user()->first_name}}</p>
                                </h5>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="text-right">
                                <button type="button" class="navbar-toggler x collapsed" data-toggle="collapse" data-target="#navbar-collapse-x">
                                    <i class="fa fa-bars"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="collapse navbar-collapse categories-desktop show" id="navbar-collapse-x">
                    <ul class="nav navbar-nav navbar-right">
                        <div class="btn-group dropright mt-3">
                            <a class="dropdown-toggle" data-toggle="dropdown" target="order" aria-haspopup="true" href="#" onclick="populateData(event)" aria-expanded="false">
                                My Orders
                            </a>
                        </div>
                        <div class="btn-group dropright mt-3">
                            <a class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" href="#" aria-expanded="false" target="vendors" onclick="populateData(event)">
                                Recent Vendors
                            </a>
                        </div>
                        <div class="btn-group dropright mt-3">
                            <a class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" href="#" aria-expanded="false" target="layaway" onclick="populateData(event)">
                                My Layaways
                            </a>
                        </div>
                        <div class="btn-group dropright mt-3">
                            <a class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" href="#" aria-expanded="false" target="reviews" onclick="populateData(event)">
                                My Reviews
                            </a>
                        </div>
                        <div class="btn-group dropright mt-3">
                            <a class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" href="#" aria-expanded="false" target="settings" onclick="populateData(event)">
                                Account Setting
                            </a>
                        </div>
                        <?php
                            if(auth()->user()->roles->pluck('name')[0] == 'merchant'){
                                $link = '/merchant';
                            } elseif(auth()->user()->roles->pluck('name')[0] == 'dispatch'){
                                $link = '/dispatch/orders';
                            }
                            else {
                                $link = '/admin';
                            }
                        ?>
                        @if(auth()->user()->roles->pluck('name')[0] != 'user')
                        <div class="btn-group dropright mt-3">
                            <a href="{{$link}}" aria-expanded="false">
                                Dashboard
                            </a>
                        </div>
                        @endif

                        <div class="btn-group dropright mt-3">
                            <a class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" href="#" aria-expanded="false" target="referals" onclick="populateData(event)">
                                Referral
                            </a>
                        </div>
                        <div class="btn-group dropright mt-3">
                            <a class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" href="#" aria-expanded="false" target="password" onclick="populateData(event)">
                                Change Password
                            </a>
                        </div>
                        <div class="btn-group dropright mt-3">
                            <a class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" href="#" onclick="logout()" aria-expanded="false">
                                Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                </div>
                </ul>
        </div>
        </nav>
        <div class="col-lg-9">
            <div class="col-lg-9 col-md-9 input-group-col">
                <div class="input-group">
                    <!-- Display user points -->
                    <input type="text" class="form-control" placeholder="Points" aria-label="Points" aria-describedby="basic-addon1" value="Total Points: {{auth()->user()->points}}" disabled>
                    </input>
                </div>
                <div class="content" id="content">
                    <div class="row">
                        <div class="col">
                            <div class="card" style="width: 18rem;">
                                <div class="card-body">
                                    <h5 class="card-title">Total Orders</h5>
                                    <h1 class="card-text">{{$orders}}</h1>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card" style="width: 18rem;">
                                <div class="card-body">
                                    <h5 class="card-title">Total Reviews</h5>
                                    <h1 class="card-text">{{$reviews}}</h1>
                                </div>
                            </div>
                        </div>

                    </div>
                    <br>
                    <div class="row">
                        <div class="col">
                            <div class="card" style="width: 18rem;">
                                <div class="card-body">
                                    <h5 class="card-title">Total Layaways</h5>
                                    <h1 class="card-text">{{$layaways}}</h1>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card" style="width: 18rem;">
                                <div class="card-body">
                                    <h5 class="card-title">Total Vendors</h5>
                                    <h1 class="card-text">{{$vendors}}</h1>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
</div>
</div>
</div>

<!-- Top up modal -->

<div class="modal fade" id="layawaytopupmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
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
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <label for="amount">Amount</label>
                            <input type="number" id="amount" name="amount" class="form-control" readonly>
                            <input type="hidden" name="order_code" value={{$layaway->order_code ?? Null}}>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Continue</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    function populateData(event) {
        if (screen.width < 1000) {
            var targetDiv = document.getElementById('content-mobile');
        } else {
            var targetDiv = document.getElementById('content');
        }
        var htmlContent = '';
        switch (event.target.target) {
            case 'order': {
                var url = "/myaccount/" + event.target.target;
                $.get(url, function(data, status) {
                    htmlContent = data;
                    targetDiv.innerHTML = htmlContent;
                });
                break;
            }
            case 'reviews': {
                var url = "/myaccount/" + event.target.target;
                $.get(url, function(data, status) {
                    htmlContent = data;
                    targetDiv.innerHTML = htmlContent;
                });
                break;
            }
            case 'vendors': {
                var url = "/myaccount/" + event.target.target;
                $.get(url, function(data, status) {
                    htmlContent = data;
                    targetDiv.innerHTML = htmlContent;
                });
                break;
            }
            case 'settings': {
                var url = "myaccount/settings/profile";
                // console.log(url);
                $.get(url, function(data, status, err) {
                    console.log(data)
                    htmlContent = data;
                    targetDiv.innerHTML = htmlContent;
                });
                // htmlContent = "content for setting";
                break;
            }
            case 'layaway': {
                var url = "/myaccount/" + event.target.target;
                $.get(url, function(data, status, err) {
                    htmlContent = data;
                    targetDiv.innerHTML = htmlContent;
                });
                // console.log(url);
                // htmlContent = "content for layaway";
                break;
            }
            case 'password': {
                var url = "/settings/password/view";
                $.get(url, function(data, status, err) {
                    htmlContent = data;
                    targetDiv.innerHTML = htmlContent;
                });
                break;
            }
            case 'referals': {
                // console.log('here');
                var url = "/myaccount/" + event.target.target;
                $.get(url, function(data, status, err) {
                    htmlContent = data;
                    targetDiv.innerHTML = htmlContent;
                });
                // htmlContent = "content for referral";
            }
            default: {
                var url = "/myaccount/" + event.target.target;
                // console.log(url);
                htmlContent = "content for default";
            }
        }
        targetDiv.innerHTML = htmlContent;
    }

    function populateDetailsData(event) {
        if (screen.width < 1000) {
            var targetDiv = document.getElementById('content-mobile');
        } else {
            var targetDiv = document.getElementById('content');
        }
        var htmlContent = '';
        // console.log(event.target.target);
        var url = "/myaccount/order/" + event.target.target;
        $.get(url, function(data, status) {
            // console.log(data);
            htmlContent = data;
            targetDiv.innerHTML = htmlContent;
        });
        // console.log(event.target.href);
        // var targetDiv = document.getElementById('content');
        // var htmlContent = '';
    }

    function layawaytopup(event) {
        if (screen.width < 1000) {
            var targetDiv = document.getElementById('content-mobile');
        } else {
            var targetDiv = document.getElementById('content');
        }
        var htmlContent = '';
        event.preventDefault();
        var order_code = event.target.target;
        var url = "/myaccount/layaway/topup/" + order_code;
        $.get(url, function(data, status) {
            // console.log(data);
            htmlContent = data;
            targetDiv.innerHTML = htmlContent;
            // $('#layawaytopupmodal').modal('show');
            // $('#amount').val(data);
        });
        // console.log(order_code);
    }

    function referafriend() {
        if (screen.width < 1000) {
            var targetDiv = document.getElementById('content-mobile');
        } else {
            var targetDiv = document.getElementById('content');
        }
        var htmlContent = '';
        var url = "myaccount/refer/friend";
        $.get(url, function(data, status) {
            // console.log(data);
            htmlContent = data;
            targetDiv.innerHTML = htmlContent;
        });
        // console.log(event.target.href);
        // var targetDiv = document.getElementById('content');
        // var htmlContent = '';
    }

    function logout() {
        event.preventDefault();
        document.getElementById('logout-form').submit();
    }

    function extendlawaway(weeks, layawayId) {
        var url = "/myaccount/layaway/extend/" + layawayId + '/' + weeks;
        // console.log(url);
        $.get(url, function(data, status) {
            if (data[0] = 'success') {
                $("#content").load(" #content > *");
            }
        });
        // console.log(layawayId);
    }
</script>

@endsection
