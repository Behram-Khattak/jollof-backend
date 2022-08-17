@extends('merchant.layouts.master')

@section('title', config('app.name', 'Laravel'))

@section('content')

    <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">

        <div class="kt-subheader   kt-grid__item" id="kt_subheader">
            <div class="kt-container  kt-container--fluid ">
                <div class="kt-subheader__main">
                    <h3 class="kt-subheader__title">Dashboard</h3>
                    <span class="kt-subheader__separator kt-hidden"></span>
                    <div class="kt-subheader__breadcrumbs">
                        <a href="#" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
                        <span class="kt-subheader__breadcrumbs-separator"></span>
                        <a href="" class="kt-subheader__breadcrumbs-link">
                            Dashboards </a>
                    </div>
                </div>
                <div class="kt-subheader__toolbar">
                    <div class="kt-subheader__wrapper">
                        <a href="{{ route('merchant.business.create') }}"
                           class="btn btn-label btn-label-brand btn-bold"
                        >
                            <i class="flaticon2-add-1"></i>
                            Create New Business
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            @foreach($businesses as $business)
                <div class="col-lg-6 col-xl-4 order-lg-1 order-xl-1">

                    <!--begin::Portlet-->
                    <div class="kt-portlet kt-portlet--height-fluid">
                        <div class="kt-portlet__head kt-portlet__head--noborder">
                            <div class="kt-portlet__head-label">
                                <h3 class="kt-portlet__head-title">{{ $business->type->name }}</h3>
                            </div>
                        </div>
                        <div class="kt-portlet__body">
                            <div class="kt-widget-13">
                                <div class="kt-widget-13__body">
                                    <a class="kt-widget-13__title" href="{{ route('merchant.business.show', $business) }}">
                                        {{ $business->name }}
                                    </a>
                                    <div class="kt-widget-13__desc">
                                        {{ Str::limit($business->description, 50) }}
                                    </div>
                                </div>
                                <div class="kt-widget-13__foot">
                                    <div class="kt-widget-13__label">
                                        <i class="fa fa-map-marker-alt kt-label-font-color-2"></i>
                                        <span class="kt-label-font-color-2">{{ Str::limit($business->locations->first()->address, 50) }}</span>
                                    </div>
                                    <div class="kt-widget-13__toolbar">
                                        <a href="{{ route('merchant.business.show', $business) }}" class="btn btn-default btn-sm btn-bold btn-upper">
                                            Visit Profile
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--end::Portlet-->
                </div>
            @endforeach
        </div>
    </div>

@endsection
