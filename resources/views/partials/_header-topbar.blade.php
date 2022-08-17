<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse"
                data-target="#navb">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navb">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" href="{{ route('index') }}">HOME</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('restaurant.index') }}">CUISINE</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('fashion.index') }}">FASHION</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#comingsoon" data-toggle="modal" data-target="#comingsoon">LIFESTYLE</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#comingsoon" data-toggle="modal" data-target="#comingsoon">SCHOLAR</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#comingsoon" data-toggle="modal" data-target="#comingsoon">BUSINESS</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#comingsoon" data-toggle="modal" data-target="#comingsoon">GIFT PORTAL</a>
                </li>

            </ul>
            <ul class="navbar-nav ml-auto">
                @guest
                <li class="nav-item">
                    <a class="nav-link active" href="/merchant/register">SELL ON JOLLOF</a>
                </li>
                @endguest
                {{--  <li class="nav-item">
                    <a class="nav-link" href="#" data-toggle="modal" data-target="#comingsoon">BLOG</a>
                </li>  --}}
                <li class="nav-item">
                    <a class="nav-link gift-portal" href="{{ route('contact') }}">CONTACT</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
