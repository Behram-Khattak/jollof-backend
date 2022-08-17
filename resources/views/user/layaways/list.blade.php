{{-- @if(request()->routeIs('myaccount'))
    @extends('layouts.master')
@endif --}}

<blade
    section|(%26%2339%3Btitle%26%2339%3B%2C%20config(%26%2339%3Bapp.name%26%2339%3B%2C%20%26%2339%3BLaravel%26%2339%3B)) />

@push('styles')
    <style>
        <blade media|%20screen%20and%20(max-width%3A%20768px)%20%7B>.logo-wrapper .navbar-collapse {
            margin: 0px 15px;
        }
        }

    </style>
@endpush

{{-- @if(request()->routeIs('myaccount'))
@section('content')
@endif --}}
<main>
    <article>
        <div class="my-orders-wrapper">
            @include('partials._flash')
            <div class="container">

                <!-- <br /><br /> -->

                <!-- <div class="">
                    <h4>My Account</h4>
                    @include('user.partials._myAccount')
                </div> -->

                <div class="row">
                    <!-- <br /> -->
                    <div class="col-12 text-center">
                        <h6 class="text-uppercase">My Layaways</h6> {{ Request::is('myaccount')}}
                    </div>

                    <div class="table-responsive m-3">
                        @if($layaways->isEmpty())
                            <p>You have no layaway item.</p>
                        @else
                        <table class="table table-bordered table-hover table-sm">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>Order Code</th>
                                    <th>Product Name</th>
                                    <th>Amount Paid</th>
                                    <th>Balance</th>
                                    <th>Time Left</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($layaways as $layaway)

                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $layaway->order_code ?? Null }}</td>
                                    <td>{{ $layaway->product->name ?? Null }}</td>
                                    <td>{{ $layaway->amount_paid ?? Null }}</td>
                                    <td>{{ $layaway->balance ?? Null }}</td>

                                    <?php
                                        $expire_date = \Carbon\Carbon::parse($layaway->expire_date);
                                        $now = \Carbon\Carbon::now();
                                        $diff = $expire_date->diffInDays($now);
                                    ?>
                                    <td><small class="text-muted">{{\Carbon\Carbon::now()->addDays($diff)->diffForHumans()}}</small></td>
                                    <td>
                                        <a class="btn btn-warning btn-sm btn-block btn-view-orders" target="{{$layaway->order_code}}" target="{{$layaway->order_code}}" onclick="layawaytopup(event)">Top up</a></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        
                        @endif
                    </div>


                    
                    <!-- Modal: My Orders View -->
                    <!-- <div class="modal" id="myModal">
                        <div class="modal-dialog">
                            <div class="modal-content">

                                <div class="p-2">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div> -->
                                <!-- Modal body -->
                                <!-- <div class="modal-body">
                                    <p> Order #4355 was placed on March 18, 2020 and is currently <span
                                            class="text-danger">Failed.</span> </p>
                                    <hr />
                                    <h5>Order details</h5>
                                    <br />
                                    <table class="table table-bordered table-hover table-sm">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Product</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="font-weight-bold">Lingerie shoes x 2</td>
                                                <td>₦40,000.00</td>
                                            </tr>
                                            <tr>
                                                <td class="font-weight-bold">Denim Bags x 3</td>
                                                <td>N80,000</td>
                                            </tr>
                                            <tr>
                                                <td class="font-weight-bold">Total</td>
                                                <td>N14,880.00</td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div> -->
<!-- 
                            </div>
                        </div> -->
                        <!-- <script>
                            function topup(event)
                            {
                                event.preventDefault();
                                console.log(code);
                            }
                        </script> -->
                    </div>

                </div>
                <!-- Order End -->
    </article>
</main>
<script>
    
</script>

{{-- @if(request()->routeIs('myaccount'))
    @endsection
@endif --}}
