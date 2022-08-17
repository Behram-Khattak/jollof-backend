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

                <div class="row">
                    <div class="col-md-8">
                        <h4>My Account</h4>
                        <p>Hello {{ auth()->user()->first_name }} (not {{ auth()->user()->first_name }}? <a href="{{ route('logout') }}">Log out</a>)</p>
                        <hr />
                    </div>
                    <div class="col-md-4 text-right">
                        <a class="btn btn-info btn-join" href="{{ route('myaccount') }}"><i class="fa fa-chevron-left"></i> Back to Orders</a>
                    </div>
                </div>

                <div class="row">
                    <!-- <br /> -->

                    <div class="col-6">
                        <h6 class="text-uppercase">Orders Details</h6>
                        <table class="table table-bordered table-hover table-sm">
                            <tr>
                                <td>Order Code</td>
                                <td>{{ $order->order_code }}</td>
                            </tr>
                            <tr>
                                <td>Date</td>
                                <td>{{ $order->created_at->toDayDateTimeString() }}</td>
                            </tr>
                            <tr>
                                <td>Total Cost</td>
                                <td>{{ $order->total }}</td>
                            </tr>
                            <tr>
                                <td>Status</td>
                                <td>{{ $order->status }}</td>
                            </tr>
                        </table>
                        <div class="my-2">
                            @if($order->status != 'paid')
                            <a href="#" class="btn btn-sm btn-primary del-order" data-toggle="modal" data-target="#delorder">Cancel Order</a>
                            <a href="{{ route('cart.order.summary', ['code' => $order->order_code]) }}" class="btn btn-sm btn-info btn-join">Go to make payment</a>
                            
                            @endif
                        </div>
                    </div>

                    <div class="col-6">
                        <h6 class="text-uppercase">Shipping Address</h6>
                        <table class="table table-bordered table-hover table-sm">
                            <tr>
                                <td>Name</td>
                                <td>{{ $shipping->first_name }} {{ $shipping->last_name }}</td>
                            </tr>
                            <tr>
                                <td>Address</td>
                                <td>{{ $shipping->address }}</td>
                            </tr>
                            <tr>
                                <td>City, State</td>
                                <td>{{ $shipping->city }}, {{ $shipping->state }}</td>
                            </tr>
                            <tr>
                                <td>Phone</td>
                                <td>{{ $shipping->phone }}</td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td>{{ $shipping->email }}</td>
                            </tr>
                        </table>
                    </div>

                    <div class="col-12">
                        <h6 class="text-uppercase">Order Items</h6>
                        <div class="table-responsive m-3">

                            <table class="table table-bordered table-hover table-sm">
                                <thead class="thead-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Quantity</th>
                                        <th>Unit Price</th>
                                        <th>Total</th>
                                        <th>Delivery</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orderItems as $item)

                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            {{ $item->name }}<br/>
                                            @if($item->preorder)
                                            <span class="badge badge-pill badge-primary">Pre-Ordered</span>
                                            <span class="badge bg-white border border-primary">{{ date('d-M-Y, h:i a', strtotime($item->delivery_on)) }}</span>
                                            @endif
                                        </td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>₦ {{ $item->unit_price  }}</td>
                                        <td>₦ {{ $item->total_price }}</td>
                                        <td>{{ $item->status }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
    </article>
</main>


<!-- Modal -->
<div class="modal fade" id="delorder" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Order</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <form action="{{ route('order.destroy', ['id' => $order->id]) }}" method="POST">
                @csrf
                @method("DELETE")
            <div class="modal-body">
                Are you sure you want to cancel order?
                <input type="hidden" name="id" value="{{ $order->id }}" />
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-confirm btn-info">Yes, Cancel Order</button>
            </div>
            </form>
        </div>
    </div>
</div>



@endsection
