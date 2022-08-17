@extends('merchant.layouts.master')

@section('title', 'Merchant: Orders')

@push('styles')

<style type="text/css">
    .kt-datatable__row>.kt-datatable__cell {
        text-align: left !important;
    }

    .kt-datatable__row>.kt-datatable__cell>span {
        display: inline !important;
    }
</style>
@endpush

@section('content')

<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
    <div class="kt-container  kt-grid__item kt-grid__item--fluid">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="kt-portlet kt-portlet--mobile">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title">
                                Orders <small></small>
                            </h3>
                        </div>
                        <div class="kt-portlet__head-toolbar">
                            <a href="{{ route('merchant.restaurant.orders') }}" role="button" class="btn btn-outline-primary btn-sm">All Orders</a>
                            <a href="{{ route('merchant.restaurant.pending') }}" role="button" class="btn btn-outline-primary btn-sm">Pending Orders</a>
                            <a href="{{ route('merchant.restaurant.preorders') }}" role="button" class="btn btn-outline-warning btn-sm ml-1">Pre-Orders</a>
                            <a href="{{ route('merchant.restaurant.orders.processed') }}" role="button" class="btn btn-outline-success btn-sm ml-1">Processing</a>
                            <a href="{{ route('merchant.restaurant.orders.picked') }}" role="button" class="btn btn-outline-success btn-sm ml-1">Picked Up</a>
                            <a href="{{ route('merchant.restaurant.orders.delivered') }}" role="button" class="btn btn-outline-success btn-sm ml-1">Delivered</a>
                        </div>
                    </div>
                    <div class="kt-portlet__body">
                        @if($orders->isEmpty())
                        <p>There are no Orders currently</p>
                        @else

                        <div class="kt-form kt-fork--label-right kt-margin-t-20 kt-margin-b-10">
                            <div class="row align-items-center">
                                <div class="col-xl-12 order-2 order-xl-1">
                                    <div class="row align-items-center">
                                        <div class="col-md-4 kt-margin-b-20-tablet-and-mobile">
                                            <div class="kt-input-icon kt-input-icon--left">
                                                <input type="text" class="form-control" placeholder="Search..." id="generalSearch">
                                                <span class="kt-input-icon__icon kt-input-icon__icon--left">
                                                    <span><i class="la la-search"></i></span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="kt-datatable">
                            <table class="table" id="" role="grid">
                                <thead>
                                    <tr>
                                        <th>S/N</th>
                                        <th>Order Code</th>
                                        <th>Order Type</th>
                                        <th>Price * Quantity</th>
                                        <th>Delivery Status</th>
                                        <th>Payment</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $item)

                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <a href="{{ route('merchant.restaurant.order.details', [request()->route('business'), 'code'=>$item->order->order_code]) }}">{{ $item->order->order_code }}</a>
                                            <p>
                                                @if ($item->preorder)
                                                <span class="badge border border-primary bg-white text-primary">{{ 'Pre-Order' }}</span><br />
                                                @else
                                                <span class="badge border border-danger bg-white text-danger">{{'Ordered Now' }}</span>
                                                @endif
                                            </p>
                                        </td>
                                        <td>
                                            @if ($item->preorder)
                                            <span class="badge bg-white border border-primary">{{ date('d-M-Y, h:i a', strtotime($item->delivery_on)) }}</span>
                                            @else
                                            {{'-' }}
                                            @endif
                                        </td>
                                        <td>
                                            {{ $item->name }} <br />
                                            NGN{{ $item->unit_price }} * {{ $item->quantity }} <br> <strong>NGN {{ $item->total_price }}</strong>
                                        </td>
                                        <td>
                                            {!! style_status($item->status) !!}<br />
                                            <small>{!! orderstatusmessage($item->status, $item->delivery_timestamp,$item->pickup_timestamp,$item->process_timestamp,$item->duration) !!}</small>
                                        </td>
                                        <td>{!! payment_status($item->order->status) !!}</td>
                                        <td>{!! merchantOrderStatus($item->status, $item->id) !!}</td>
                                        <td>{!! dispatchOrderStatus($item->status, $item->id) !!}</td>
                                    </tr>

                                    @endforeach
                                </tbody>

                            </table>
                            {{$orders->links()}}
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade process-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title h4" id="mySmallModalLabel">Order Update</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="{{ route('dispatch.order.update') }}" method="POST" class="delete-form">
                <div class="modal-body">
                    <div class="delivered">
                        <h4>Have the item been delivered?</h4>
                        <p>Click the update order status button to set the item as delivered?</p>
                    </div>
                    <div class="contentx">
                        <div class="processed">
                            <h2 class="text-center process"></h2>
                            <p>Are you sure you want to continue with this order process?</p>
                            <label for="exampleInputPassword1">How long will this take?</label>
                            <select name="duration" class="form-control">
                                <option value="15">15 Mins</option>
                                <option value="30">30 Mins</option>
                                <option value="45">45 Mins</option>
                                <option value="60">60 Mins</option>
                                <option value="75">75 Mins</option>
                                <option value="90">90 Mins</option>
                                <option value="120">120 Mins</option>
                                <option value="150">150 Mins</option>
                                <option value="180">180 Mins</option>
                            </select>
                        </div>
                        <div class="picked">
                            <h4>Picking up item</h4>
                            <p>Are you about to start delivery of item? Updated status to picked up for delivery.</p>
                            <label for="exampleInputPassword1">How long will this take to deliver?</label>
                            <select name="duration" class="form-control">
                                <option value="15">15 Mins</option>
                                <option value="30">30 Mins</option>
                                <option value="45">45 Mins</option>
                                <option value="60">60 Mins</option>
                                <option value="75">75 Mins</option>
                                <option value="90">90 Mins</option>
                                <option value="120">120 Mins</option>
                                <option value="150">150 Mins</option>
                                <option value="180">180 Mins</option>
                            </select>
                        </div>

                    </div>
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="order" value="">
                    <input type="hidden" name="status" value="">
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger">Yes, Update Order Status</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{--
<div class="modal fade process-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title h4" id="mySmallModalLabel">Order Update</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="{{ route('merchant.restaurant.order.update', request()->route('business')) }}" method="POST" class="delete-form">
<div class="modal-body">

    <p>Are you sure you want to continue with this order process?</p>
    <h2 class="text-center process"></h2>
    <label for="exampleInputPassword1">How long will this take?</label>
    <select name="duration" class="form-control">
        <option value="15">15 Mins</option>
        <option value="30">30 Mins</option>
        <option value="45">45 Mins</option>
        <option value="60">60 Mins</option>
        <option value="75">75 Mins</option>
        <option value="90">90 Mins</option>
        <option value="120">120 Mins</option>
        <option value="150">150 Mins</option>
        <option value="180">180 Mins</option>
    </select>

    @csrf
    @method('PATCH')
    <input type="hidden" name="order" value="">
    <input type="hidden" name="status" value="">
</div>
<div class="modal-footer">
    <button class="btn btn-success btn-block">Yes, Update Order Status</button>
</div>
</form>
</div>
</div>
</div> --}}

@endsection


@push('scripts')
<script>
    setTimeout(function() {
        window.location.reload(1);
    }, 30000);

    $(function() {
        $('body').on('click', '.processing', function() {

            $("input[name='order']").val($(this).data('id'));
            $("input[name='status']").val($(this).data('status'));
        });
    });

    $(function() {
        $(".delivered").hide();
        $('body').on('click', '.processing', function() {

            if ($(this).data('status') == 'delivered') {
                $(".contentx").hide();
                $(".delivered").show();
            }
            if ($(this).data('status') == 'pickedup') {
                $(".contentx").show();
                $(".delivered").hide();
                $(".picked").show();
                $(".processed").hide();

            }
            if ($(this).data('status') == 'processing') {
                $(".contentx").show();
                $(".delivered").hide();
                $(".picked").hide();
                $(".processed").show();
            }

            $("input[name='order']").val($(this).data('id'));
            $("input[name='status']").val($(this).data('status'));
        });
    });
</script>

@endpush
