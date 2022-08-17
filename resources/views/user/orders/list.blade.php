@extends('layouts.master')

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

@section('content')
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
                        <h6 class="text-uppercase">My Orders</h6>
                    </div>

                    <div class="table-responsive m-3">
                        @if($orders->isEmpty())
                            <p>There are no orders yet</p>
                        @else
                        <table class="table table-bordered table-hover table-sm">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>Order</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Total</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $order)

                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $order->order_code }}</td>
                                    <td><small class="text-muted">{{ $order->created_at->toDayDateTimeString() }}</small></td>
                                    <td>{{ $order->status }}</td>
                                    <td>₦ {{ $order->total }} for {{ count($order->items) }} items</td>
                                    <td>
                                    @if(request()->routeIs('myaccount.*'))
                                        <a class="btn btn-warning btn-sm btn-block btn-view-orders" target="{{$order->order_code}}" onclick="populateDetailsData(event)">View</a></td>
                                    @else                            
                                        <a class="btn btn-warning btn-sm btn-block btn-view-orders" href="{{route('order.details',$order->order_code)}}">View</a></td>
                                    @endif
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                            @if(request()->routeIs('myaccount.*'))
                                <a class="btn btn-warning btn-sm btn-block btn-view-orders" href="{{route('orders')}}">View all orders</a></td>
                            @else
                                {{$orders->links() }}
                            @endif
                        @endif
                    </div>

                    <!-- Modal: My Orders View -->
                    <div class="modal" id="myModal">
                        <div class="modal-dialog">
                            <div class="modal-content">

                                <div class="p-2">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <!-- Modal body -->
                                <div class="modal-body">
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
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
                <!-- Order End -->
    </article>
</main>
<script>
    
</script>


@endsection
