@extends('admin.layouts.master')

@section('title', "Jollof Billing")

@section('content')



<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
    <div class="kt-container  kt-grid__item kt-grid__item--fluid">
        <div class="row">
            <div class="col-lg-10">
                <h1 class="mb-5">Billing for {{ $business->name }}</h1>
            </div>
            <div class="col-lg-2">
                <a class="btn btn-primary" href="{{ route('admin.billing') }}"><i class="fa fa-chevron-left"></i> Billing List</a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="kt-portlet kt-portlet--mobile">
                    <div class="kt-portlet__body">
                        <form class="kt-form" action="{{ route('admin.billing.details', ['business'=>$business->slug]) }}" method="POST">
                            @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif

                            @csrf

                            <div class="row">
                                <div class="col-md-9">
                                    <label>Duration of Sale</label>
                                    <input class="form-control daterange" type="text" value="" name="duration">
                                    <span class="form-text text-muted">Select date range for report</span>
                                </div>
                                <div class="col-md-3 pt-1">
                                    <button type="submit" class="btn btn-primary mt-4">Filter Billing</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3">
                <div class="kt-portlet kt-portlet--height-fluid">
                    <div class="kt-portlet__head kt-portlet__head--noborder">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title">Orders</h3>
                        </div>
                    </div>
                    <div class="kt-portlet__body kt-portlet__body--fluid">
                        <div class="kt-widget-19">
                            <div class="kt-widget-19__title">
                                <div class="kt-widget-19__label">
                                    <small><strong>&#8358;</strong></small>{{ number_format($orders->sum('total_price'), 2) }}<br />
                                    <small>{{ $orders->count() }} items ordered</small>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="kt-portlet kt-portlet--height-fluid">
                    <div class="kt-portlet__head kt-portlet__head--noborder">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title">Sales</h3>
                        </div>
                    </div>
                    <div class="kt-portlet__body kt-portlet__body--fluid">
                        <div class="kt-widget-19">
                            <div class="kt-widget-19__title">
                                <div class="kt-widget-19__label">
                                    <small><strong>&#8358;</strong></small>{{ number_format($sales->sum('total_price'), 2) }}<br />
                                    <small>{{ $sales->count() }} items sold</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="kt-portlet kt-portlet--height-fluid">
                    <div class="kt-portlet__head kt-portlet__head--noborder">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title">Merchant Commision</h3>
                        </div>
                    </div>
                    <div class="kt-portlet__body kt-portlet__body--fluid">
                        <div class="kt-widget-19">
                            <div class="kt-widget-19__title">
                                <div class="kt-widget-19__label">
                                    <small><strong>&#8358;</strong></small>{{ number_format($sales->sum('total_price') * ($business->payout->percentage/100), 2) }}<br />
                                    <small>{{ $business->payout->percentage }}% of sales</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="kt-portlet kt-portlet--height-fluid">
                    <div class="kt-portlet__head kt-portlet__head--noborder">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title">Jollof Commision</h3>
                        </div>
                    </div>
                    <div class="kt-portlet__body kt-portlet__body--fluid">
                        <div class="kt-widget-19">
                            <div class="kt-widget-19__title">
                                <div class="kt-widget-19__label">
                                    <small><strong>&#8358;</strong></small>{{ number_format($sales->sum('total_price') * ((100 - $business->payout->percentage)/100), 2) }}<br />
                                    <small>{{ 100 - $business->payout->percentage }}% of sales</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if ($request)
        <div class="row">
            <div class="col-lg-12">
                <div class="kt-portlet kt-portlet--mobile">
                    <div class="kt-portlet__body">
                        <ul class="list-inline mb-0">
                            <li class="list-inline-item"><strong>Last Payout Date:</strong> {{ $request->payout_date }}</li>
                            <li class="list-inline-item"><strong>Last Payout Amount:</strong> {{ $request->amount }}</li>
                            <li class="list-inline-item"><strong>Next Payout Date:</strong> {{ $payout->next_payout }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <div class="row">
            <div class="col-lg-12">
                <div class="kt-portlet kt-portlet--mobile">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title">
                                Billings
                            </h3>
                        </div>
                        <div class="kt-portlet__head-toolbar">
                            <a href="{{ route('admin.billing.history', ['business'=>$business->slug]) }}" class="btn btn-secondary mr-2">Payout History</a>
                            @if(!empty($orders[0]))
                            <div class="dropdown show">
                                <a class="btn btn-secondary dropdown-toggle" href="#" size="20" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Export
                                </a>

                                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                    <a class="dropdown-item" href="{{route('admin.billing.export.csv', $data)}}">CSV</a>
                                    <a class="dropdown-item" href="{{route('admin.billing.export.excel', $data)}}">Excel</a>
                                </div>
                            </div>
                            @endif
                            @can('initiate-payout')
                            @if(strtotime(date('Y-m-d')) > strtotime($business->payout->next_payout))
                            <button class="btn btn-primary" data-toggle="modal" data-target="#payout">Initiate Payout</button>
                            @endif
                            @endcan
                        </div>
                    </div>
                    <div class="kt-portlet__body">

                        <div id="kt_datatable">
                            <table class="kt-datatable" id="roles-table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Order Code</th>
                                        <th>Product Name</th>
                                        <th>Details</th>
                                        <th>Quantity</th>
                                        <th>Unit Price</th>
                                        <th>Total Price</th>
                                        <th>Coupon Percentage</th>
                                        <th>Date</th>
                                        <th>Payment Status</th>
                                        {{-- <th>Amount Paid</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $order)

                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{$order->order->order_code}}</td>
                                        <td>{{ $order->name }}</td>
                                        <td>{{ $order->description }}</td>
                                        <td>{{ $order->quantity }}</td>
                                        <td>{{ $order->unit_price }}</td>
                                        <td>{{ $order->total_price }}</td>
                                        <td>
                                            @if(!is_null($order->order->coupon_value))
                                            {{$order->order->coupon_value}}%
                                            @else
                                            0
                                            @endif
                                        </td>
                                        <td>{{ $order->created_at }}</td>
                                        <td>
                                            @if(is_null($order->paid_on))
                                            <span class="text-danger">Not paid</span>
                                            @else
                                            <span class="text-success">Paid</span>
                                            @endif
                                        </td>
                                        {{-- <td>
                                            @if(!is_null($order->paid_on))
                                            ₦{{number_format($order->order->total,2)}}
                                            @else
                                            ----
                                            @endif
                                        </td> --}}
                                    </tr>

                                    @endforeach
                                </tbody>

                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="payout" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Initiate Business Payout</h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form method="POST" action="{{ route('admin.billing.payout', ['business'=>$business]) }}">
                @csrf
                <div class="modal-body">
                    <label>Payout Amount</label>
                    <input type="text" name="amount" value="{{ $sales->sum('total_price') * ($business->payout->percentage/100) }}" class="form-control" readonly>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    @can('initiate-payout')
                    <button type="submit" class="btn btn-primary">Initiate Payout</button>
                    @endcan
                </div>
            </form>

        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    jQuery(document).ready(function() {
        $('.daterange').daterangepicker();

        $('#kt_select2_1').select2({
            placeholder: "Select sales duration"
        });

    });
</script>

@endpush
