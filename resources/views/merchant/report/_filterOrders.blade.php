@if ($orders->count() == 0)
<div class="col-lg-12">
    <div class="kt-portlet kt-portlet--mobile">
        <div class="kt-portlet__body mb-0">

            <p class="text-center py-5 my-5">There are no reports</p>

        </div>
    </div>
</div>
@else
<div class="col-lg-12">
    <div class="kt-portlet kt-portlet--mobile">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title">
                    Report of {{ $input['report'] }} for {{ $thisBusiness }} from {{ $input['start_date'] }} to {{ $input['end_date'] }}
                </h3> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <div class="dropdown show">
                    <a class="btn btn-secondary dropdown-toggle" href="#" size="20" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Export
                    </a>

                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <a class="dropdown-item" href="{{route('merchant.export.report',['csv',$input['start_date'],$input['end_date'],$input['business'],$input['payment']])}}">CSV</a>
                        <a class="dropdown-item" href="{{route('merchant.export.report',['excel',$input['start_date'],$input['end_date'],$input['business'],$input['payment']])}}">Excel</a>
                    </div>
                </div>
            </div>
        </div>
        {{--<div class=" kt-portlet__body mb-0">

            <table class="kt-datatable" id="roles-table">
                <thead>
                    <tr>
                        <th>Order Code</th>
                        <th>Date Ordered</th>
                        <th>Payment Status</th>
                        <th>Amount Paid</th>
                        <th>Delivery Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orders->unique('order_id') as $order)
                    <?php
                    $toppings = explode(",", $order->description);
                    ?>
                    <tr>
                        <td><a href="{{ route('merchant.restaurant.order.details', [request()->route('business'), 'code'=>$order->order->order_code]) }}" target="_blank">{{ $order->order->order_code }}</a></td>
        <td>{{ $order->created_at }}</td>
        <td>
            @if(is_null($order->paid_on))
            <span class="text-danger">Not paid</span>
            @else
            <span class="text-success">Paid</span>
            @endif
        </td>
        <td>
            @if(!is_null($order->paid_on))
            ₦{{number_format($order->order->total,2)}}
            @else
            ----
            @endif
        </td>
        <td>{{ $order->status }}</td>
        </tr>
        @empty
        <tr>
            <td>
                No result for this filter
            </td>
        </tr>
        @endforelse
        </tbody>
        </table>

    </div>--}}

    <div class="kt-portlet__body mb-0" style="width:100">

        <table class="kt-datatable" id="roles-table">
            <thead>
                <tr>
                    <th>Order Code</th>
                    <th>Name & Phone</th>
                    <th>Date Ordered</th>
                    <th>Product Name</th>
                    <th>Details</th>
                    <th>Price * Qty</th>
                    <th>Total Amount</th>
                    <th>Payment Status</th>
                    <th>Delivery Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($orders as $order)

                <?php
                $toppings = explode(",", $order->description);
                ?>
                <tr>
                    <td> <a href="{{ route('admin.order.details', [request()->route('business'), 'code'=>$order->order->order_code]) }}" target="_blank">{{ $order->order->order_code }}</a></td>
                    <td>{{ ucfirst($order->order->shipping->first_name) }} {{ ucfirst($order->order->shipping->last_name) }} <br> {{ ucfirst($order->order->shipping->phone) }}</td>
                    <td>{{date('d-M-Y H:i:s', strtotime($order->created_at)) }}</td>
                    <td>{{$order->name}}</td>
                    <td>
                        @if($order->model == 'cuisine')
                        <br>
                        @foreach($toppings as $top)
                        <small>{{$top}}</small><br>
                        @endforeach
                        @elseif($order->model == 'fashion')
                        {{$order->size}}
                        @else
                        -----
                        @endif
                    </td>
                    <td>{{$order->unit_price}} * {{$order->quantity}}</td>
                    <td>{{$order->unit_price * $order->quantity}}</td>
                    <td>
                        @if(is_null($order->paid_on))
                        <span class="text-danger">Not paid</span>
                        @else
                        <span class="text-success">Paid</span>
                        @endif
                    </td>
                    <td>{{ ucfirst($order->status) }}</td>
                </tr>
                @empty
                <tr>
                    <td>
                        No result for this filter
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

    </div>
</div>
</div>
@endif
