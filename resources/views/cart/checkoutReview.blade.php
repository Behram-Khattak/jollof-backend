@extends('layouts.master')

@push('styles')
<style>
    .services-wrapper table {
        background: #FFF;
    }

    .product-wrapper .input-group{
        width:100%;
    }
</style>
@endpush

@section('title', 'menu items')

@section('content')

<main style="background: #f7f7f7;">
    <article>
        <div class="container">
            @include('partials._flash')
            <div class="services-wrapper">
                <h3>Shopping Cart</h3>
                <div class="row">

                    <div class="col-lg-8 col-md-8">
                        @if($cartItems->isEmpty())

                            <div class="billinginformation-wrapper">

                                <div class="row">
                                    <div class="col-md-12">
                                        <h5 class="text-muted text-center pt-5">No Item in cart</h5>
                                        <h1 class="text-muted text-center pb-5"><i class="fa fa-shopping-cart"></i></h1>
                                    </div>
                                </div>
                            </div>

                        @else
                            <div class="billinginformation-wrapper">

                                <div class="row">
                                    <div class="col-lg-1 col-md-1 col-sm-1 col-1">
                                        <p>&nbsp;</p>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="custom-checkbox">
                                            <label class="" for="select-all">
                                                <p>Product</p>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-2 col-sm-2 col-2">
                                        <div class="custom-checkbox">
                                            <label class="" for="select-all">
                                                <p><strong>Price</strong></p>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-3 col-3">
                                        <p><strong>Qty</strong></p>
                                    </div>
                                    <div class="col-lg-2 col-md-2 col-sm-2 col-2">
                                        <div class="text-right">
                                            <p><strong>Total (₦)</strong></p>
                                        </div>
                                    </div>

                                </div>

                            </div>

                            <form method="POST" action="{{ route('cart.update') }}">
                            <div class="billinginformation-wrapper product-wrapper">
                                @foreach ($cartItems as $item)
                                <div class="row cartItem">
                                    <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
                                        <a class="removeCart font-weight-bold text-danger" data-id="{{ $item->id }}"><i class="fa fa-trash text-danger"></i></a>
                                    </div>
                                    <div class="col-lg-6 col-sm-6">
                                        <div class="custom-checkbox">
                                            <label class="" for="select-all">
                                                <div class="row">
                                                    <div class="col-lg-3 col-xd-3 text-xs-center">
                                                        <img src="{{ $item->attributes->imgurl }}" class="img-fluid rounded shadow-sm">
                                                    </div>
                                                    <div class="col-lg-9 col-md-9 text-xs-center">
                                                        <div>
                                                            <h6>
                                                                <div class="row">
                                                                    <div class="col-md-7">
                                                                        <p>{{ $item->name }}</p>
                                                                        <!-- <p class="text-muted">{{ $item->attributes->description }}</p> -->
                                                                        <p class="text-muted">{{ $item->attributes->toppings }}</p>
                                                                    </div>
                                                                    <div class="col-md-5 text-md-right text-xs-center">N{{ number_format($item->attributes->main_price, 2) }}</div>
                                                                </div>
                                                            </h6>
                                                        </div>
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-lg-5 col-sm-5">
                                        <div class="row">
                                            <div class="col-xs-6 col-md-6">
                                                <div class="input-group input-group-sm">
                                                    <div class="input-group-prepend">
                                                        <button type="button" class="btn btn-light px-2 p-0 minus-btn" data-price="{{ $item->price }}"><i class="fa fa-minus"></i></button>
                                                    </div>
                                                    <input type="text" name="quantity[]" class="form-control form-control-sm rounded-0 mt-0 py-4 qty_input bg-light border-0" value="{{ $item->quantity }}" readonly />
                                                    <div class="input-group-append">
                                                        <button type="button" class="btn btn-light px-2 py-0 plus-btn" data-price="{{ $item->price }}" data-maxqty="{{ $item->attributes->inventory ? $item->attributes->inventory : 0 }}"><i class="fa fa-plus"></i></button>
                                                    </div>
                                                    <input type="hidden" name="id[]" value="{{ $item->id }}" />
                                                </div>
                                            </div>
                                            <div class="col-xs-6 col-md-6 text-md-right text-xs-center">
                                                <input type="text" name="price[]" class="price-tag form-control" value="{{ $item->price * $item->quantity }}" readonly/>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                @endforeach
                                @csrf
                                <div class="text-right mt-4">
                                    <button type="submit" class="btn btn-info btn-join">Update Cart</button>
                                </div>
                            </div>
                            </form>
                        @endif
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <div class="checkout-wrapper">
                            <h5 class="mb-40">Cart Total</h5>



                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-6">
                                        <div>
                                            <p class="bold">Subtotal</p>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-6">
                                        <div class="pull-right">
                                            <p class="bold">₦ {{ $cartSubTotal }}</p>
                                        </div>
                                    </div>
                                </div>

                                {{--  <div>
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-6">
                                            <div>
                                                <p class="bold">Delivery Fee</p>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-6">
                                            <div class="pull-right">
                                                <p class="bold">₦1500.00</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>  --}}

                                <div class="total-amount">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-6">
                                            <div>
                                                <h6 class="bold">Total</h6>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-6">
                                            <div class="pull-right">
                                                <h6 class="bold">₦ {{ $cartTotal }}</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <a href="{{ route('cart.shipping.review') }}" class="btn btn-info btn-join" id="proceed">Proceed</a>
                                </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </article>
</main>



@endsection


@push('scripts')

<script>
    $(function () {
        $('body').on('click', '.removeCart', function () {
            var button = $(this);
            var product_id = $(this).data('id');
            var url = "/restaurant/remove/cart/" + product_id;
            $.get(url, function (data, status) {

                $('.toast-body').html(data.message);

                $('.toast').removeClass('bg-danger');
                $('.toast').removeClass('bg-success');
                $('.toast').addClass('bg-danger');
                $('.toast').toast('show');

                button.parents('.cartItem').remove();

                if($('.after-order').find('.cartItem').length == 0){
                    $('.no-order').show();
                }
            });

        });

        $('body').on('click', '.plus-btn', function(){
            var price = Number($(this).data('price'));
            var inputField = $(this).parents('.cartItem').find('.qty_input');
            var maxqty = Number($(this).data('maxqty'));
            var increment = Number(inputField.val()) + 1;

            if(maxqty > 0){
                if(maxqty > Number(inputField.val())){
                    inputField.val(increment);
                    $(this).parents('.cartItem').find('.price-tag').val(price * increment);
                }
            }
            else{
                inputField.val(increment);
                $(this).parents('.cartItem').find('.price-tag').val(price * increment);
            }

        });

        $('body').on('click', '.minus-btn', function(){
            var price = $(this).data('price');
            var inputField = $(this).parents('.cartItem').find('.qty_input');
            var decrement = Number(inputField.val()) - 1;
            var qty = inputField.val(decrement);
            if (inputField.val() == 0) {
                inputField.val(1);
                decrement = 1;
            }
            $(this).parents('.cartItem').find('.price-tag').val(price * decrement);
        });

    });

</script>


@endpush

