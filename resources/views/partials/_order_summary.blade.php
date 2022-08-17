@if($order->status == 'paid')
<div class="alert alert-success" role="alert">
    <h4 class="alert-heading">Paid</h4>
    <hr>
    <p class="mb-0">Thank you for completing your transaction. Your order is on its way. You can track the status of your order with the order code <strong>{{ $order->order_code }}</strong></p>
</div>
@else
<div class="alert alert-warning" role="alert">
    <h4 class="alert-heading">Almost There</h4>
    <hr>
    <p class="mb-0">You can make your payment to complete your transaction and receive your order. You can pay with a card.</p>
</div>
@endif
<!-- if any error -->
@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
<div class="row">
    <div class="col-lg-5 col-md-5">
        <div class="billinginformation-wrapper mb-3 py-3">
            <div class="billing-information">

                <h6 class="text-uppercase">Orders Details</h6>
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
                        <strong>
                            <td><b>Total Cost</b></td>
                        </strong>
                        <strong>
                            <td><b>₦{{ $order->total }}</b></td>
                        </strong>
                    </tr>
                    <tr>
                        <td>Status</td>
                        <td>{{ $order->status }}</td>
                    </tr>
                </table>
                <p>Inclusive of Shipping/Delivery Cost & VAT</p>

            </div>
        </div>

        <div class="billinginformation-wrapper mb-3 py-3">
            <div class="billing-information">

                <h6 class="text-uppercase">Shipping Address</h6>
                <table class="table table-borderless table-hover table-sm">
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
        </div>

        <div>
            @if($order->status !== 'paid')
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <button type="button" class="btn btn-success btn-block btn-lg rounded-0" onclick="payWithPaystack()">Pay Now</button>
                </div>
                <div class="col-lg-6 col-md-6">
                    @if (!Request::segment(5))
                    <button type="button" class="btn btn-info btn-join btn-block btn-lg rounded-0" data-toggle="modal" data-target="#pay4meModal">Pay4Me</button>
                    @endif

                </div>
            </div>
            @endif
        </div>
    </div>
    <div class="col-lg-7 col-md-7">
        <div class="billinginformation-wrapper mb-3 py-3">
            <div class="billing-information">
                <h6 class="text-uppercase">Order Items</h6>
                <table class="table table-borderless table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Product Name</th>
                            <th>Quantity</th>
                            <th>Unit Price</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orderItems as $item)
                        <?php
                        $toppings = explode(',', $item->description);
                        ?>
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->name }}
                                @if($item->model == 'cuisine')
                                <br>
                                @foreach($toppings as $top)
                                <small>{{$top}}</small><br>
                                @endforeach
                                @endif
                            </td>
                            <td>{{ $item->quantity }}</td>
                            <td>₦ {{ $item->unit_price  }}</td>
                            <td>₦ {{ $item->total_price }}</td>
                            <td>{{$item->topping}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
        <div class="text-center p-5">
            {!! twitter_share(url()->full()) !!}
        </div>
    </div>
</div>
<script type="text/javascript">
    window.onload = function() {
        let button = document.getElementById('payrave');
        button.removeAttribute('disabled');
    }
</script>
