@extends('layouts.master')

@section('title', 'FAQ - Jollof')

@push('styles')
    <style>
        <blade media|%20screen%20and%20(max-width%3A%20768px)%20%7B>.logo-wrapper .navbar-collapse {
            margin: 0px 15px;
        }
        }

    </style>
@endpush

@section('content')

<main>
    <article>
        <div class="my-orders-wrapper">
            <div class="container mb-5">
                <h4 class="text-center mt-4">FREQUENTLY ASKED QUESTIONS (FAQ)</h4>
                <hr />
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <ul>
                            <li>
                                <p class="font-weight-bold">Are all products on Jollof.com original and Genuine?</p>
                                <p>Jollof.com is committed to ensuring that all products offered are original and genuine.
                                    Any
                                    outlet found contradicting this standard will be immediately delisted from Jollof.com.
                                </p>
                            </li>
                            <li>
                                <p class="font-weight-bold">Are prices on Jollof.com negotiable?</p>
                                <p>Prices on Jollof.com are non-negotiable.</p>
                            </li>
                            <li>
                                <p class="font-weight-bold">Why do prices for the same product vary on Jollof.com?</p>
                                <p>Different vendors offer same products at different prices. You are free to purchase any
                                    products
                                    after considering their offer and rating.</p>
                            </li>
                            <li>
                                <p class="font-weight-bold">Are there hidden charges if I place an order on Jollof.com such
                                    as tax?</p>
                                <p>There are no hidden charges. All costs, inclusive of tax and shipping fees, are visible
                                    at final
                                    checkout.</p>
                            </li>
                            <li>
                                <p class="font-weight-bold">What are delivery costs?</p>
                                <p>Delivery costs are the costs incurred by Jollof.com to bring your ordered items to the
                                    indicated
                                    delivery addresses.</p>
                            </li>
                            <li>
                                <p class="font-weight-bold">Can I pay on delivery for my orders?</p>
                                <p>Pay on delivery is currently unavailable. Jollof.com only accepts online payment for
                                    orders.</p>
                            </li>
                            <li>
                                <p class="font-weight-bold">What is my card number, expiry date and CVV/security code?</p>
                                <p>Jollof.com requires your 16-digit Card Number, card expiry date and Card Verification
                                    Code (CVV)
                                    for payments of orders. Please note that Jollof.com does NOT save your card information
                                    and you
                                    would be required to enter it anytime you make purchases on Jollof.com.</p>
                            </li>
                            <li>
                                <p class="font-weight-bold">Why was my credit/debit card declined?</p>
                                <p>Please verify from your bank that your card is activated for online payments.</p>
                            </li>
                            <li>
                                <p class="font-weight-bold">Does Jollof.com take any measures to prevent card fraud?</p>
                                <p>We take frauds very seriously and have put in place the required security measures to
                                    detect all
                                    forms of frauds. All payments are monitored for suspicious activities and some
                                    transactions are
                                    manually verified especially when it appears the transactions was not authorized by the
                                    card
                                    owner.</p>
                            </li>
                            <li>
                                <p class="font-weight-bold">How do I use Coupons/Vouchers?</p>
                                <p>At the checkout stage, simply enter the coupon or voucher code in the provided box and
                                    click
                                    apply.</p>
                            </li>
                            <li>
                                <p class="font-weight-bold">Do you have Mobile Apps?</p>
                                <p>Jollof.com mobile app is currently being developed for both Android and iOS devices. This
                                    would
                                    be made available on Play store and Appstore once completed.</p>
                            </li>
                            <li>
                                <p class="font-weight-bold">How do I know my Order have been received?</p>
                                <p>Once you click on "Submit Order", you will see a Thank You message and receive a
                                    confirmation
                                    email. You can be rest assured that your order has been sent electronically to the
                                    vendor.</p>
                            </li>
                            <li>
                                <p class="font-weight-bold">How do I know if my order has been confirmed?</p>
                                <p>You’ll receive a confirmation email once your order has been confirmed.</p>
                            </li>
                            <li>
                                <p class="font-weight-bold">How do I cancel or rectify My Order?</p>
                                <p>Orders can be cancelled up to the time it has been confirmed. Send us an email:
                                    info@jollof.com
                                    or contact us via our Social Media channels, including WhatsApp, or call our support
                                    line and we
                                    will migrate your request for you.</p>
                            </li>
                            <li>
                                <p class="font-weight-bold">How do I change my delivery address?</p>
                                <p>Contact us via our support platforms and we will process your request.</p>
                            </li>
                            <li>
                                <p class="font-weight-bold">My order is delayed. What should I do?</p>
                                <p>We do all we can to get your orders to you at the earliest. The delay is most likely as a
                                    result
                                    of higher-than-usual volume of demand. Also, you would be provided notifications on the
                                    status
                                    of your orders when it is running behind time or ahead of schedule. Our order management
                                    process
                                    ensures that all customers are adequately informed on the progress of their orders.</p>
                            </li>
                            <li>
                                <p class="font-weight-bold">How long does it take to receive my product?</p>
                                <p>The average delivery timelines are displayed on the product page but it also depends on
                                    your
                                    city.</p>
                            </li>
                            <li>
                                <p class="font-weight-bold">I have placed an order for “Pick-up” but I meant to place it for
                                    “Home Delivery”, what do I do?</p>
                                <p>Contact Jollof.com via our support platforms and quote your “Order Number” so we can
                                    process
                                    your request.</p>
                            </li>
                            <li>
                                <p class="font-weight-bold">I have a complaint against the delivery agent who came to
                                    deliver my order. What should I do?</p>
                                <p>We sincerely apologize for any inconvenience caused. Please send us an email at
                                    info@jollof.comor contact us through our support platforms so that we can sort things
                                    out.</p>
                            </li>
                            <li>
                                <p class="font-weight-bold">The item was bad, can I get a refund?</p>
                                <p>Contact Jollof.com via our support platforms, quoting your Order Number, for an immediate
                                    resolution. Unfortunately, we cannot give you a refund, but the vendor may reimburse
                                    you.</p>
                            </li>
                            <li>
                                <p class="font-weight-bold">Still have Questions?</p>
                                <p>If you are having trouble navigating the website or have any other questions, please send
                                    email
                                    at info@jollof.com or contact us via our social media channels.</p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </article>
    <!-- Settings End -->
</main>

@endsection
