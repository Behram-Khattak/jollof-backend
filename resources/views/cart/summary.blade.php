@extends('layouts.master')

@push('styles')
<style>
    .services-wrapper table {
        background: #FFF;
    }
</style>
@endpush

@section('title', 'menu items')

@section('content')
<!-- Paystack Script -->
<script src="https://js.paystack.co/v1/inline.js"></script>

<main style="background: #f7f7f7;" class="container">
    @if (Session::has('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Congratulation!</strong> {{ Session::get('success') }}.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif
    <article>
        <div class="container">
            <div class="services-wrapper">
                <h3>Order Summary</h3>
                <div>
                    <button class="btn btn-success btn-sm float-right mb-3" type="submit">EXPLORE JOLLOF</button>
                </div><br><br><br>
                @include('partials._order_summary')

            </div>
        </div>
    </article>
</main>

<div class="modal fade" id="pay4meModal" tabindex="-1" aria-labelledby="pay4meModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Request Pay4Me</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('pay.for.me') }}" id="pay4meForm" method="POST">
                <div class="modal-body">
                    @csrf
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Senders Name</label>
                        <input type="text" name="sender" class="form-control" value="{{ $shipping->first_name }} {{ $shipping->last_name }}" placeholder="Firstname Lastname" readonly>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Sender Email</label>
                        <input type="text" name="sender_email" class="form-control" value="{{ $shipping->email }}" placeholder="name@domainname.com" readonly>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Recipient Name</label>
                        <input type="text" name="recipient" class="form-control" placeholder="Full Name" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Send Via</label>
                        <select class="form-control" name="medium" id="medium" onchange="changeRes()" required>
                            <option value="">Select</option>
                            <option value="email">Email</option>
                            <option value="whatsapp">WhatsApp</option>
                        </select>
                    </div>
                    <div class="form-group" id="recipient_email" hidden>
                        <label for="exampleFormControlInput1">Recipient Email Address</label>
                        <input type="email" name="recipient_email" id="recipient_email" class="form-control" placeholder="myname@mydomain.com">
                    </div>
                    <!-- <div class="form-group" id="recipient_number" hidden>
                        <label for="exampleFormControlInput1">Recipient Whatsapp Number</label>
                        <input type="tel" name="recipient_number" class="form-control" placeholder="+2345788927839">
                    </div> -->
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Message</label>
                        <textarea class="form-control" name="message" id="exampleFormControlTextarea1" rows="3" placeholder="message" required></textarea>
                        <input type="hidden" name="url" value="{{ url()->full() }}/payforme">
                    </div>

                    <center>
                        <strong>
                            <p>Note: If you use pay for me, you cart would be cleared.</p>
                        </strong>
                    </center>
                </div>
                <div class="modal-footer">
                    <button onclick={submitPay4MeForm(event)} class="btn btn-success">Send Pay4Me Request</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    // submit pay4mefrom
    function submitPay4MeForm(e) {
        e.preventDefault();
        // form validation
        if (document.getElementById('pay4meForm').checkValidity()) {
            document.getElementById('pay4meForm').submit();
        }

    }
</script>

<div class="modal fade" id="checkOrder" tabindex="-1" aria-labelledby="checkOrderModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Order Status</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Order {{ $order->order_code }} has been paid for.</p>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <a href="{{ route('cart.order.complete', ['code' => $order->order_code]) }}" class="btn btn-primary">Continue</a>
            </div>
        </div>
    </div>
</div>

@endsection


@push('scripts')

{{-- <script src="https://api.ravepay.co/flwv3-pug/getpaidx/api/flwpbf-inline.js"></script>  --}}
<!-- <script src="https://checkout.flutterwave.com/v3.js"></script> -->
<script src="https://js.paystack.co/v2/inline.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


<!-- <script>
    function payF() {
        console.log('mad ooo')
    }

    // $(function() {

    //     $('body').on('click', '#payrave', function() {
    //         //check if order has been paid for
    //         var product_id = $(this).data('id');
    //         var url = "/cart/check/order/{{ $order->order_code }}";
    //         $.get(url, function(data) {
    //             if (data.status) {
    //                 $('#checkOrder').modal('show');
    //             } else {
    //                 console.log('here')
    //                 let handler = PaystackPop.setup({
    //                     key: {{config('app.paystack.key')}}, // Replace with your public key
    //                     email: {{$shipping->email}},
    //                     amount: {{$order->total}}* 100,
    //                     ref: '' + Math.floor((Math.random() * 1000000000) + 1), // generates a pseudo-unique reference. Please replace with a reference you generated. Or remove the line entirely so our API will generate one for you
    //                     // label: "Optional string that replaces customer email"
    //                     onClose: function() {
    //                         alert('Window closed.');
    //                     },

    //                     callback: function(response) {

    //                         let message = 'Payment complete! Reference: ' + response.reference;

    //                         alert(message);

    //                     }
    //                 });
    //                 handler.openIframe();
    const API_publicKey = "{{ env('FLUTTERWAVE_API_KEY') }}";
    FlutterwaveCheckout({
        public_key: API_publicKey,
        tx_ref: "{{ $tx_ref }}",
        amount: "{{$order->total}}",
        currency: "NGN",
        country: "NG",
        payment_options: "card",
        redirect_url: "{{ env('APP_URL') }}/cart/order/processing/{{ $order->order_code }}/",
        meta: {
            consumer_id: 23,
            consumer_mac: "92a3-912ba-1192a",
        },
        customer: {
            email: "{{ $shipping->email }}",
            phone_number: "{{ $shipping->phone }}",
            name: "{{ $shipping->first_name }} {{ $shipping->last_name }}",
        },
        callback: function(data) {
            console.log(data);
        },
        onclose: function() {
            // close modal
        },
        customizations: {
            title: "Jollof",
            description: "Payment for items in cart",
            logo: "https://testing.jollof.com/images/logo.png",
        },


    //                 /*PBFPubKey: API_publicKey,
    //                 customer_email: "{{ $shipping->email }}",
    //                 amount: {{ $order->total }},
    //                 customer_phone: {{ $shipping->phone }},
    //                 currency: "NGN",
    //                 txref: "{{ $tx_ref }}",
    //                 hosted_payment: 1,
    //                 redirect_url: "http://jollof.test/cart/order/completed/{{ $order->order_code }}/",
    //                 meta: [{
    //                     metaname: "flightID",
    //                     metavalue: "AP1234"
    //                 }],
    //                 onclose: function() {},
    //                 callback: function(response) {
    //                     var txref = response.tx.id; // collect txRef returned and pass to a server page to complete status check.
    //                     console.log("This is the response returned after a charge", response);
    //                     exit;
    //                     if (
    //                         response.tx.chargeResponseCode == "00" ||
    //                         response.tx.chargeResponseCode == "0"
    //                     ) {
    //                         // redirect to a success page
    //                     } else {
    //                         // redirect to a failure page.
    //                         console.log();
    //                     }

    //                     //x.close(); // use this to close the modal immediately after payment.
    //                 }*/
    //                 // });
    //             }
    //         });
    //     });


    // });
</script> -->

<script>
    function changeRes() {
        var mode = $('#medium').val();
        if (mode == 'email') {
            $('#recipient_email').removeAttr('hidden');
            $('#recipient_number').attr('hidden', 'hidden');
        } else if (mode == 'whatsapp') {
            $('#recipient_number').removeAttr('hidden');
            $('#recipient_email').attr('hidden', 'hidden');
        } else {
            $('#recipient_email').attr('hidden', 'hidden');
            $('#recipient_number').attr('hidden', 'hidden');
        }
    }

    function payWithPaystack() {
        const paystack = new PaystackPop();

        paystack.newTransaction({
            key: "{{config('app.paystack.key')}}",
            email: "{{$shipping->email}}",
            amount: "{{$order->total}}" * 100,
            ref: '{{$tx_ref}}',
            onSuccess: (transaction) => {
                // console.log(transaction)
                // Payment complete! Reference: transaction.reference
                reference = transaction.reference;
                transaction_id = transaction.trans;
                status = transaction.status;
                message = transaction.message;
                var url = '{{env("APP_URL")}}/paystack/verify/' + reference + '/' + transaction_id + '/' +status + '/' + message+ "/{{$order->order_code}}"
                // console.log(url)

                // // add a get request to the api using javascript fetch method
                // var raw = JSON.stringify({
                //     "tran": transaction
                // });

                // var requestOptions = {
                //     method: 'GET',
                //     headers: myHeaders,
                // };

                // fetch(url, requestOptions)
                //     .then(response => response.json())
                //     .then(result => console.log(response))
                //     .catch(error => console.log('error', error));
                // https://developer.mozilla.org/en-US/docs/Web/API/Fetch_API/Using_Fetch

                window.location.replace(url);
                // console.log(url)
                // $.get(url, function(data) {
                //     alert("Data: " + data);
                // });
            },
            onCancel: () => {
                alert('why you cancel am, u too mumu');
            }
        });
        // var handler = PaystackPop.setup({
        //     key: {{config('app.paystack.key')}}, // Replace with your public key
        //     email:{{$shipping->email}},
        //     amount: {{$shipping->total}} * 100, // the amount value is multiplied by 100 to convert to the lowest currency unit
        //     currency: 'NGN', // Use GHS for Ghana Cedis or USD for US Dollars
        //     ref: '' + Math.floor((Math.random() * 1000000000) + 1), // Replace with a reference you generate
        //     callback: function(response) {
        //     //this happens after the payment is completed successfully
        //     var reference = response.reference;
        //     alert('Payment complete! Reference: ' + reference);
        //     // Make an AJAX call to your server with the reference to verify the transaction
        //     },
        //     onClose: function() {
        //         alert('Transaction was not completed, window closed.');
        //     },

        // });

        // handler.openIframe();
    }
</script>

@endpush
