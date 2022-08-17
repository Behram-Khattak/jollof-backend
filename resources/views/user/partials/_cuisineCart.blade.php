
    <h5>Your Order</h5>
    <hr>

    <div class="no-order">
    @if ($cartCollection->isEmpty())
        <p class="jollof-points">You can also use Jollof Points at checkout to get a discount on ordered items</p>
        <p class="no-items">There are no items in your cart. Start adding your dishes.</p>
        <i class="fa fa-shopping-cart"></i>
    @endif
    </div>

    <div class="after-order">
    @if (!$cartCollection->isEmpty())
        @foreach ($cartCollection as $item)
            @if($item->attributes->microsite == 'cuisine')
            <div class="cartItem">
                <ul class="list-unstyled">
                    <li>
                        <span class="pull-left">
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                                    <button type="button" class="btn btn-light px-2 p-0 reduceCart" data-id="{{ $item->id }}"><i class="fa fa-minus"></i></button>
                                </div>
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-light px-2 py-0 addCart" data-id="{{ $item->id }}"><i class="fa fa-plus"></i></button>
                                </div>
                            </div>
                        </span>
                        <span class="pull-right">
                            <button class="removeCart btn btn-sm btn-link" data-id="{{ $item->id }}"><i class="fa fa-times text-danger"></i></button>
                        </span>
                        <div class="clearfix"></div>
                    </li>
                    <li class="font-weight-light">
                        <div class="row">
                            <div class="col-md-7">{{ $item->name }}</div>
                            <div class="col-md-5 text-right">N{{ $item->attributes->main_price }}</div>
                        </div>

                    @if ($item->attributes->toppings)
                    <ul class="mb-3">
                        @foreach (explode(',', $item->attributes->toppings) as $toppingItem)
                            <li>{{ $toppingItem }}</li>
                        @endforeach
                    </ul>
                    <div class="text-center"><a href="#" class="btn btn-link btn-sm addToppings" data-id="{{ $item->attributes->menu_id }}"
                        data-microsite="cuisine" data-menuid="{{ $item->id }}">Edit</a></div>
                    @endif

                    </li>
                    <li class="font-weight-bold">NGN {{ $item->price * $item->quantity }} <span class="font-weight-bold pull-right text-dark">QTY {{ $item->quantity }}</span></li>
                    <li class="linebr pt-3"><hr></li>
                </ul>
            </div>
            @endif
        @endforeach
    @endif
    </div>
    <a type="button" href="{{ route('cart.checkout.review') }}" id="btnSubmitCart" class="btn btn-block btn-info btn-join">confirm order</a>

