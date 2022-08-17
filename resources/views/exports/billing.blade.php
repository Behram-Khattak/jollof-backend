<div class="kt-portlet__body">
    <div id="kt_datatable">
        <table class="kt-datatable" id="roles-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Prduct Name</th>
                    <th>Description</th>
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
                    <td>{{ $order->name }}</td>
                    <td>{{ $order->description }}</td>
                    <td>{{ $order->quantity }}</td>
                    <td>{{ $order->unit_price }}</td>
                    <td>{{ $order->total_price }}</td>
                    <td>
                        @if(!is_null($order->order->coupon_value))
                        {{$order->order->coupon_value}}
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
                        {{$order->order->total}}
                    @else
                    0
                    @endif
                    </td> --}}
                </tr>

                @endforeach
            </tbody>

        </table>
    </div>

</div>
