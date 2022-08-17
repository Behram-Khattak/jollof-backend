<div class="row">
    <div class="col-lg-6">

        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title">
                        Order Details
                    </h3>
                </div>
            </div>
            <div class="kt-portlet__body mb-0">
                <table class="table table-borderless table-hover table-sm">
                    <tr>
                        <td>Order Code</td>
                        <td>{{ $order->order_code }}</td>
                    </tr>
                    <tr>
                        <td>Date</td>
                        <td>{{ $order->created_at->toDayDateTimeString() }}</td>
                    </tr>
                    <tr>
                        <?php
                        $totalCost = 0;
                        foreach ($orderItems as $item) {
                            $totalCost += $item->total_price;
                        }
                        ?>
                        <td>Total Cost:</td>
                        <td>{{$totalCost}}</td>
                    </tr>
                    @unlessrole('merchant')
                    <tr>
                        <td>Coupon Percentage</td>
                        <td>
                            @if(!is_null($order->coupon_value))
                            {{$order->coupon_value}}%
                            @else
                            0
                            @endif
                        </td>
                    </tr>
                    @endunlessrole
                    <tr>
                        <td>Payment Status</td>
                        <td>{{ $order->status }}</td>
                    </tr>
                    <!-- only role of merchant should not be included-->
                    @unlessrole('merchant')
                    <tr>
                        <td>Amount Paid</td>
                        <td>{{ $order->total }} (Inclusive of Shipping/Delivery Cost and VAT)</td>
                    </tr>
                    @endunlessrole

                    <tr>
                        <td>Delivery Status</td>
                        <td>{{ ucwords($orderItems[0]->status ?? 'null')  }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-6">

        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title">
                        Shipping Details
                    </h3>
                </div>
            </div>
            <div class="kt-portlet__body">
                <table class="table table-borderless table-hover table-sm">
                    <tr>
                        <td>Name</td>
                        <td>{{ ucfirst($shipping->first_name) }} {{ ucfirst($shipping->last_name) }}</td>
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
        </div>
    </div>
</div>

{{-- <div class="row">

    <div class="col-lg-12">

        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title">
                        Transaction Details
                    </h3>
                </div>
            </div>
            <div class="kt-portlet__body">
                <table class="table table-bordered table-hover table-sm">
                    <thead class="thead-light">
                        <tr>
                            <th>Transaction Reference</th>
                            <th>Amount</th>
                            <th>Card Type</th>
                            <th>Last 4 Digit</th>
                            <th>Completed At</th>
                            <th>Verified At</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $order->transaction->reference }}</td>
<td>{{ $order->transaction->amount }}</td>
<td>{{ $order->transaction->card }}</td>
<td>{{ $order->transaction->last4 }}</td>
<td>{{ $order->transaction->completed_at }}</td>
<td>{{ $order->transaction->verified_at }}</td>
</tr>
</tbody>
</table>

</div>
</div>
</div>
</div> --}}

<div class="row">
    <div class="col-lg-12">

        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title">
                        Order Items Details
                    </h3>
                </div>
            </div>
            <div class="kt-portlet__body p-0">


                <table class="table table-bordered table-hover mb-0">
                    <thead class="thead-dark">
                        <tr>
                            <th>Item Name</th>
                            <th>Order Type</th>
                            <th>Size</th>
                            <th>Merchant</th>
                            <th>Unit Price * Quantity</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orderItems as $item)
                        <?php
                        $toppings = explode(",", $item->description);
                        ?>
                        <tr>
                            <td>{{ $item->name }}
                                @if($item->model == 'cuisine')
                                <br>
                                @foreach($toppings as $top)
                                <small>{{$top}}</small><br>
                                @endforeach
                                @endif
                            </td>
                            <td>
                                @if ($item->preorder)
                                <span class="badge border border-primary bg-white text-primary">{{ 'Pre-Order' }}</span>
                                <span class="badge bg-white border border-primary">{{ date('d-M-Y, h:i a', strtotime($item->delivery_on)) }}</span>
                                @else
                                <span class="badge border border-danger bg-white text-danger">{{'Ordered Now' }}</span>
                                @endif

                            </td>
                            <td>{{$item->size ?? ''}}</td>
                            <td>{{ $item->business->name }}</td>
                            <td>₦ {{ $item->unit_price  }} * {{ $item->quantity }}</td>
                            <td>₦ {{ number_format($item->total_price,2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-lg-12">

        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title">
                        Order Logs
                    </h3>
                </div>
            </div>
            <div class="kt-portlet__body p-0">


                <table class="table table-bordered table-hover mb-0">
                    <thead class="thead-dark">
                        <tr>
                            <th>Order Item</th>
                            <th>Order time</th>
                            <th>Processed time</th>
                            <th>Pickedup time</th>
                            <th>Delivered time</th>
                        </tr>
                    </thead>
                    @foreach ($orderItems as $item)
                    <tbody>
                        <td>{{$item->name}}</td>
                        <td>{!! getTimeZone($order->created_at) !!}</td>
                        <td>{!! getTimeZone($item->process_timestamp) !!}</td>
                        <td>{!! getTimeZone($item->pickup_timestamp) !!}</td>
                        <td>{!! getTimeZone($item->delivery_timestamp) !!}</td>
                    </tbody>
                    @endforeach
                </table>

            </div>
        </div>
    </div>
</div>
