@extends('merchant.layouts.master')

@section('title', 'Merchant: Orders')

@section('content')

<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
    <div class="kt-container  kt-grid__item kt-grid__item--fluid">
        @include('partials._order_delivery_details')
    </div>
</div>

