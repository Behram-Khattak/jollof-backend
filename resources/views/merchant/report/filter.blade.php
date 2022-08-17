@extends('merchant.layouts.master')

@section('title', 'Jollof merchant: Report')

@section('content')

<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
    <div class="kt-container  kt-grid__item kt-grid__item--fluid">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="kt-portlet kt-portlet--mobile">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title">
                                Generate Report
                            </h3>
                        </div>
                    </div>
                    <div class="kt-portlet__body mb-0">

                        @include('merchant.report._filterForm')
                    </div>
                </div>
            </div>

            @include('merchant.report._filterOrders')
        </div>
    </div>
</div>

@endsection

@push('scripts')

<script>
    jQuery(document).ready(function () {
        $('.daterange').daterangepicker();

    });
</script>

@endpush
