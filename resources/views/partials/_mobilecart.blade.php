<div class="rounded-circle d-block d-sm-none d-sm-block d-md-none" style="position: fixed; bottom:90px; right:25px; height: 50px; width: 50px; background-color:#fff; box-shadow: 4px 7px 14px 0px rgba(0,0,0,0.46); z-index:100">
    <a class="nav-link cart" href="{{ route('cart.checkout.review') }}">
        <img src="{{ asset('images/cart.svg') }}" class="img-fluid" alt="logo" style="position: relative; top: 10px;">
        {{--  <span class="fa fa-cart"></span>  --}}
        <div class="cart-number-wrap">
            <div class="cart-number">{{ \Cart::getTotalQuantity() }}</div>
        </div>
    </a>
</div>
