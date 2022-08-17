@extends('admin.layouts.master')

@section('title', 'Admin: Orders')

@section('content')

<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
    <div class="kt-container  kt-grid__item kt-grid__item--fluid">
        <div class="row justify-content-center">
            <div class="col-lg-12">

                <div class="kt-portlet kt-portlet--mobile">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title">
                                Orders
                            </h3>
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
                                        <div class="dropdown show">
                                            <a class="btn btn-secondary dropdown-toggle" href="#" size="20" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Export
                                            </a>

                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                <a class="dropdown-item" href="export/order/csv">CSV</a>
                                                <a class="dropdown-item" href="export/order/excel">Excel</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="kt-datatable">
                            <table class="table" role="grid">
                                <thead>
                                    <tr>
                                        <th>S/N</th>
                                        <th>Order Code</th>
                                        <th>Order Time</th>
                                        <th>Name & Phone</th>
                                        <th>Payment Status</th>
                                        <th>Delivery</th>
                                        @can('process-order')
                                        <th>Status</th>
                                        @endcan
                                        @canany('pickup-order','deliver-order')
                                        <th>Action</th>
                                        @endcanany
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $item)
                                    @if($item->order)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td><a href="{{ route('admin.order.details', ['code'=>$item->order->order_code]) }}">{{ $item->order->order_code }}</a>
                                            <p>
                                                @if ($item->preorder)
                                                <span class="badge border border-primary bg-white text-primary">{{ 'Pre-Order' }}</span><br />
                                                @else
                                                <span class="badge border border-danger bg-white text-danger">{{'Ordered Now' }}</span><br>
                                                {{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}
                                                @endif
                                            </p>
                                        </td>

                                        <td>
                                            @if ($item->preorder)
                                            <span class="badge bg-white border border-primary">{{ date('d-M-Y, h:i a', strtotime($item->delivery_on)) }}</span>
                                            <span class="badge bg-white border border-danger">{{ date('d-M-Y, h:i a', strtotime($item->created_at)) }}</span>
                                            @else
                                            <span class="badge bg-white border border-danger">{{ date('d-M-Y, h:i a', strtotime($item->created_at)) }}</span>
                                            @endif
                                        </td>
                                        <td>{{ ucfirst($item->order->shipping->first_name) }} {{ ucfirst($item->order->shipping->last_name) }} <br> {{ ucfirst($item->order->shipping->phone) }}</td>
                                        <td>
                                            @if(!is_null($item->paid_on))
                                            <span class="text-success">Paid</span>
                                            @else
                                            <span class="text-danger">Unpaid</span>
                                            @endif
                                        </td>
                                        <td>{!! style_status($item->status) !!}<br><small>Ready in about {{ $item->duration }}mins</small></td>
                                        @can('process-order')
                                        <td>{!! merchantOrderStatus($item->status, $item->id) !!}</td>
                                        @endcan
                                        @canany('pickup-order','deliver-order')
                                        <td>{!! dispatchOrderStatus($item->status, $item->id) !!}</td>
                                        @endcanany
                                    </tr>

                                    @endif
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
            <form action="{{ route('admin.order.update') }}" method="POST" class="delete-form">
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
    <button class="btn btn-danger">Yes, Update Order Status</button>
    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
</div>
</form>
</div>
</div>
</div> --}}

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

@endsection


@push('scripts')
<script>
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
