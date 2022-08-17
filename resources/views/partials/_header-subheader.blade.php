<div class="logo-wrapper">
    <nav class="navbar navbar-expand-md">
        <div class="container">
            <a class="navbar-brand" href="{{ route('index') }}">
                <img src="{{ asset('images/logo.png') }}" class="img-fluid logo" alt="logo">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
                <i class="fa fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="collapsibleNavbar">
                <ul class="navbar-nav ml-auto">
                    @auth
                    <li class="nav-item cart-item">
                        <a class="nav-link btn btn-danger text-white" href="{{ route('refer.friend') }}">
                            <strong>Refer a Friend</strong>
                        </a>
                    </li>
                    @endauth
                    <li class="nav-item cart-item">
                        <a class="nav-link cart" href="{{ route('cart.checkout.review') }}">
                            <img src="{{ asset('images/cart.svg') }}" class="img-fluid" alt="logo">
                            <div class="cart-number-wrap">
                                @if(\Cart::getTotalQuantity() > 0)
                                <div class="cart-number">{{ \Cart::getTotalQuantity() }}</div>
                                @endif
                            </div>
                        </a>
                    </li>
                    @guest
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="">
                            My Account
                        </a>
                        <div class="dropdown-menu">
                        <div class="d-flex">
                            <div>
                                <a class="dropdown-item btn btn-info btn-join"
                                    href="/user/register"
                                >
                                    Register
                                </a>
                            </div>
                            <div class="margin-left-5">
                                <a class="dropdown-item btn btn-info btn-join btn-signin"
                                    href="{{ route('login') }}"
                                >
                                    Log In
                                </a>
                            </div>
                        </div>
                        </div>

                    </li>
                    @else
                    <li class="nav-item dropdown">
                        <a class="nav-link" href="/myaccount">
                            My Account
                        </a>
                    </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>
</div>
