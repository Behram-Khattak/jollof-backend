@extends('admin.layouts.master')

@section('title', 'Admin: Orders')

@section('content')

<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
    <div class="kt-container  kt-grid__item kt-grid__item--fluid">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                @include('partials._order_delivery_details')

            </div>
        </div>
    </div>
</div>

@endsection
