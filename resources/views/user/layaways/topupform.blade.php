{{-- @if(request()->route('layaway.topup'))

    @extends('layouts.master')

    @section('title', 'Profile Settings')

    @section('content')

@endif --}}
<main>
    <article>
        <div class="my-orders-wrapper mb-5">
            <div class="container">

                <!-- <br /> -->
                    @include('partials._flash')
                <!-- <br /> -->

                <div class="">
                    <!-- <h4>My Account</h4> -->
                    <!-- @include('user.partials._myAccount') -->
                </div>
                <div class="row">
                    <div class="col-12 text-center">
                        <h6 class="text-uppercase">Layaway top up</h6>
                    </div>
                    <div class="container" id="profile">
                        <label for="">Progress</label>
                        <div class="progress">
                            <?php
                                if($layaway->product->sales_price <= 0){
                                    $price = $layaway->product->price;
                                }else{
                                    $price = $layaway->product->sales_price;
                                }
                                $percentage = round($layaway->amount_paid / $price * 100,2);
                            ?>
                            <div class="progress-bar progress-bar-striped bg-info" role="progressbar" style="width: {{$percentage}}%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">{{$percentage}}%</div>
                        </div>
                        <label for="">Time Left: 
                            <?php

                                $expire_date = \Carbon\Carbon::parse($layaway->expire_date);
                                $now = \Carbon\Carbon::now();
                                $diff = $expire_date->diffInDays($now);
                            ?>
                            +{{\Carbon\Carbon::now()->addDays($diff)->diffForHumans()}} &nbsp; ({{$layaway->expire_date}})
                        </label><br>
                        @if($percentage > 60)
                            @if($layaway->extension_used < $layawaysettings->number_of_extension)
                                <button type="button" class="btn btn-light" onclick="extendlawaway({{$layawaysettings->extension_limit}}, {{$layaway->id}})">Extend by {{$layawaysettings->extension_limit}} Week(s)&nbsp; ({{$layawaysettings->number_of_extension - $layaway->extension_used }} Left) </button>
                            @endif
                        @endif
                        <div class="profile-div">
                            <form action="{{ route('layaway.topup.now') }}" method="POST">

                                <div class="row">
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <label for="">Order Code</label>
                                            <input type="text" class="form-control" name="order_code" value="{{$layaway->order_code}}" readonly required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <label for="">Product Name</label>
                                            <input type="text" class="form-control" value="{{$layaway->product->name}}" name="product_name" readonly required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12 col-md-12">
                                        <div class="form-group">
                                            <label for="">Total Amount:</label>
                                            <input type="text" class="form-control" value="{{number_format($price,2)}}" name="total_amount" required readonly>
                                            @csrf
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="layaway_id" value="{{$layaway->id}}">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <label for="">Amount Paid</label>
                                            <input type="text" class="form-control" value="{{number_format($layaway->amount_paid,2)}}" name="amount_paid" required readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <label for="">Balance</label>
                                            <input type="text" class="form-control readonly" value="{{number_format($layaway->balance,2)}}" name="balance" readonly required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12">
                                        <div class="form-group">
                                            <label for="">TOP UP AMOUNT</label>
                                            <input type="number" step="any" max="{{$layaway->balance}}" class="form-control readonly" name="topup" required>
                                        </div>
                                    </div>
                                </div>



                                <button type="submit" class="btn btn-info btn-start">TOP UP</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </article>
</main>
<div id="state-data" style="display: none;">{{ json_encode(locations_json()) }}</div>
{{-- @if(request()->route('layaway.topup'))
@endsection 
@endif --}}

