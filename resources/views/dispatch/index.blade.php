@extends('layouts.dispatch')

@section('title', 'Dispatch: Orders')

@section('content')
@can('read-order')
<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
    <div class="kt-container  kt-grid__item kt-grid__item--fluid">
        <div class="row">
            <div class="col-lg-12">

                <div class="kt-portlet kt-portlet--mobile">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title">
                                Orders
                            </h3>
                        </div>
                        <div class="kt-portlet__head-toolbar">
                            <a href="{{ route('dispatch.orders.index') }}" role="button" class="btn btn-outline-primary btn-sm">Processing Orders</a>&nbsp;
                            <a href="{{ route('dispatch.orders.pickedup') }}" role="button" class="btn btn-outline-primary btn-sm m1-1">Picked Up Orders</a>
                            <a href="{{ route('dispatch.orders.completed') }}" role="button" class="btn btn-outline-warning btn-sm ml-1">Delivered Orders</a>
                        </div>
                    </div>
                    <div class="kt-portlet__body">
                        <div id="kt_table_1_wrapper" class="kt_dataTables_wrapper">

                            @if($orders->isEmpty())
                            <p>There are no Orders currently</p>
                            @else
                            <div class="dropdown show">
                                <a class="btn btn-secondary dropdown-toggle" href="#" size="20" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Export
                                </a>

                                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                    <a class="dropdown-item" href="{{route('dispatch.export.order', 'csv')}}">CSV</a>
                                    <a class="dropdown-item" href="{{route('dispatch.export.order', 'excel')}}">Excel</a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-md-12">
                                    <div class="billinginformation-wrapper mb-3 p-0">
                                        <div class="billing-information">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Order Code</th>
                                                        <th>Name & Phone</th>
                                                        <th>Address</th>
                                                        <th>Price * Quantity</th>
                                                        <th>Delivery</th>
                                                        @canany('pickup-order','deliver-order')
                                                        <th>Status</th>
                                                        @endcanany
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($orders as $item)
                                                    @if($item->order)
                                                    @if($item->status !== 'pending')
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td><a href="{{ route('dispatch.order.details', ['code'=>$item->order->order_code]) }}">{{ $item->order->order_code }}</a></td>
                                                        <td>{{ ucfirst($item->order->shipping->first_name) }} {{ ucfirst($item->order->shipping->last_name) }} <br> {{ ucfirst($item->order->shipping->phone) }}</td>
                                                        <td>{{ ucfirst($item->order->shipping->address) }}</td>
                                                        <td>NGN{{ $item->unit_price }} * {{ $item->quantity }} <br> <strong>NGN {{ $item->total_price }}</strong></td>
                                                        <td>{!! style_status($item->status) !!}<br><small>Ready in about {{ $item->duration }}mins</small></td>
                                                        @canany('pickup-order','deliver-order')
                                                        <td>{!! dispatchOrderStatus($item->status, $item->id) !!}</td>
                                                        @endcanany
                                                    </tr>
                                                    @endif
                                                    @endif
                                                    @endforeach
                                                </tbody>

                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
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
                                <option value="1">1 Min</option>
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
                                <option value="1">1 Min</option>
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
@endcan
@endsection


@push('scripts')
<script>
    setTimeout(function() {
        window.location.reload(1);
    }, 30000);

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
