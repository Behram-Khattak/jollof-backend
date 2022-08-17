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
            <div class="services-wrapper">
                <h3>Checkout Method</h3>
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <div class="billinginformation-wrapper">
                            <div class="billing-information">
                                <h5>Login to continue</h5>

                                @include('auth.loginForm')

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="checkout-wrapper">
                            <h5 class="mb-40">Proceed as Guest</h5>
                            <div>
                                <a href="{{ route('cart.shipping.review') }}" class="btn btn-info btn-join" id="proceed">Checkout</a>
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

</script>


@endpush

