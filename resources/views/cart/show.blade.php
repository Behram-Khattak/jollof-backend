<div class="regular">
    @foreach ($cartItems as $key => $items)

        @foreach ($items as $item)
        <div class="row mt-2" style="border-bottom: 1px dashed #CCCCCC;">
            @if($loop->first)
            <div class="col-lg-12 col-md-12 col-12">
                <small class="text-success font-weight-bold">{{ $item->attributes->merchant }}</small>
            </div>
            @endif
            <div class="col-lg-12 col-md-12 col-12">
                <div>
                    @if ($item->attributes->microsite == 'cuisine')
                        <div class="row bold mb-0">
                            <div class="col-lg-6 col-md-6 col-6">
                                <small class="font-weight-bold text-muted">MAIN DISHES</small><br/>
                                {{ $item->name }} <small class="text-muted">x {{ $item->quantity }}</small><br>
                            </div>
                            <div class="col-lg-6 col-md-6 col-6">
                                <p class="bold mb-0 text-right"></p>
                            </div>
                        </div>
                        @if ($item->attributes->toppings)
                            <div class="row">
                                <div class="col-sm-6">
                                    <small class="font-weight-bold text-muted">EXTRAS</small>
                                </div>
                                <div class="col-sm-6">
                                    <p class="bold mb-0 text-right">₦{{ $item->attributes->topping_price }}</p>
                                </div>
                            </div>
                            <ul class="text-muted mb-3">
                                @foreach (explode(',', $item->attributes->toppings) as $toppingItem)
                                    <li><small>{{ $toppingItem }}</small></li>
                                @endforeach
                            </ul>
                        @endif
                        <div class="row bold mb-0">
                            <div class="col-lg-6 col-md-6 col-6">
                                <small class="font-weight-bold text-muted">Item Total Cost</small>
                            </div>
                            <div class="col-lg-6 col-md-6 col-6">
                                <p class="font-weight-bold text-success text-right">₦{{ $item->price * $item->quantity }}</p>
                            </div>
                        </div>
                    @else
                        <div class="row bold mb-0">
                            <div class="col-lg-6 col-md-6 col-6">
                                {{ $item->name }} <small class="text-muted">x {{ $item->quantity }}</small>
                            </div>
                            <div class="col-lg-6 col-md-6 col-6">
                                <p class="bold mb-0 text-right">₦{{ $item->attributes->main_price }}</p>
                            </div>
                        </div>

                    @endif

                </div>
            </div>

        </div>
        @endforeach
        <hr />
    @endforeach

</div>

<div class="row">
    <div class="col-md-12 showcoupon">
        @if(!$conditions->isEmpty())

        @isset($coupon)
            <div class="couponlist">
                <ul class="list-unstyled couponItem">
                    <li class="text-right"><button class="removeCoupon btn btn-link" data-id="{{ $coupon->id }}"><i class="fa fa-times text-danger"></i></button></li>
                    <li class="font-weight-light">The condition is here<br><small class="text-muted">'+ product.conditions.value +'</small></li>
                    <li class="linebr pt-3"><hr></li>
                </ul>
            </div>
            @endif

            @foreach ($cartItems as $key => $items)
                @foreach ($items as $coupon)
                    @if(empty($coupon->conditions))
                        @foreach($coupon->conditions as $cnd)
                        <div class="couponlist">
                            <ul class="list-unstyled couponItem">
                                <li class="text-right"><button class="removeCoupon btn btn-link" data-id="{{ $coupon->id }}" data-coupon="{{ $cnd->getName() }}"><i class="fa fa-times text-danger"></i></button></li>
                                <li class="font-weight-light">{{ $cnd->getName() }}<br><small class="text-muted">{{ $cnd->getValue() }} off {{ $coupon->attributes->microsite }} item<small>(s)</small></small></li>
                                <li class="linebr pt-3"><hr></li>
                            </ul>
                        </div>
                        @endforeach
                    @endif
                @endforeach
            @endforeach
        @endisset

    </div>
</div>

<div class="row">
    <div class="col-lg-6 col-md-6 col-6">
        <div>
            <p class="bold">Subtotal</p>
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-6">
        <div class="pull-right">
            <p class="bold">₦{{ $cartSubTotal }}</p>
        </div>
    </div>
</div>

<div id="shippingBox">
@if($shippingCost)
<div class="row">
    <div class="col-lg-8 col-md-8 col-8">

            <p class="bold">{{ $shippingCost->getName() }}</p>
            <p class="bold text-muted">
                {{ $shippingCost->getAttributes()['city'] }}, <br/>{{ $shippingCost->getAttributes()['state'] }}
            </p>

    </div>
    <div class="col-lg-4 col-md-4 col-4">
        <div class="text-right">
            <p class="bold mb-0">₦{{ $shippingCost->getValue() }}</p>

        </div>
    </div>
</div>
@endif
</div>

<div id="vatBox">

    <div class="row">
        <div class="col-lg-8 col-md-8 col-8">

                <p class="bold">{{ $vat->getName() }}</p>

        </div>
        <div class="col-lg-4 col-md-4 col-4">
            <div class="text-right">
                <p class="bold mb-0">₦{{ $vat->getValue() }}</p>

            </div>
        </div>
    </div>

</div>

<div class="total-amount">
    <div class="row">
        <div class="col-lg-6 col-md-6 col-6">
            <div>
                <h6 class="bold">Total</h6>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-6">

                <h6 class="bold text-right" id="cartTotal">₦ {{ $cartTotal }}</h6>

        </div>
    </div>
</div>
