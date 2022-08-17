@extends('merchant.layouts.master')

@section('title', 'Merchant: Orders')

@section('content')

<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
    <div class="kt-container  kt-grid__item kt-grid__item--fluid">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="kt-subheader   kt-grid__item" id="kt_subheader">
                    <div class="kt-container  kt-container--fluid ">
                        <div class="kt-subheader__main">
                            <h3 class="kt-subheader__title">Order Details</h3>
                            <span class="kt-subheader__separator kt-hidden"></span>

                        </div>
                        <div class="kt-subheader__toolbar">
                            <h5><a href="{{ route('merchant.restaurant.orders', request()->route('business')) }}"><i class="fas fa-arrow-left"></i> Back to Orders</a></h5>
                            <span class="kt-subheader__separator kt-hidden"></span>

                        </div>
                    </div>
                </div>
                @include('partials._order_delivery_details')

            </div>
        </div>
    </div>
</div>


@endsection
