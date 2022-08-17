<div class=" kt-portlet__body mb-0">

    <table class="kt-datatable">
        <thead>
            <tr>
                <th>Order Code</th>
                <th>Name and Phone</th>
                <th>Date Ordered</th>
                <th>Product Name</th>
                <th>Details</th>
                <th>Price and Qty</th>
                <th>Total Amount</th>
                @unlessrole('merchant')
                <th>Coupon Percentage</th>
                @endunlessrole
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
                <td>{{ $order->order->order_code}}</td>
                <td>{{ ucfirst($order->order->shipping->first_name) }} {{ ucfirst($order->order->shipping->last_name) }} {{ ucfirst($order->order->shipping->phone) }}</td>
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
                @unlessrole('super-admin')
                <td>
                    @if(!is_null($order->order->coupon_value))
                    {{$order->order->coupon_value}}
                    @else
                    0
                    @endif
                </td>
                @endunlessrole
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
{{-- <div class="kt-portlet__body mb-0">

     <table class="kt-datatable" id="roles-table">
         <thead>
             <tr>
                 <th>Order Code</th>
                 <th>Name and phone</th>
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
                 <td>{{ $order->order->order_code }}</td>
<td>{{ ucfirst($order->order->shipping->first_name) }} {{ ucfirst($order->order->shipping->last_name) }} {{ ucfirst($order->order->shipping->phone) }}</td>
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
    {{$order->order->total}}
    @else
    0
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
--}}
