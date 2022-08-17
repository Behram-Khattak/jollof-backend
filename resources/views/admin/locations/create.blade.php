@extends('admin.layouts.master')

@section('title', config('app.name', 'Laravel'))

@section('content')

<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
    <div class="kt-container  kt-grid__item kt-grid__item--fluid">
        <div class="row">
            <div class="col-lg-6">

                <div class="kt-portlet kt-portlet--mobile">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title">
                                Create Coupon
                            </h3>
                        </div>
                    </div>
                    <div class="kt-portlet__body">

                        <form action="/admin/coupon" method="POST">
                            @include('admin.coupon.form')

                            <div class="form-group">

                                <button type="submit" class="btn btn-primary btn-lg">Create Coupon</button>

                            </div>
                        </form>
                    </div>
                </div>

            </div>

        </div>

    </div>

</div>

@endsection

@push('scripts')

<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<script>
    jQuery(document).ready(function () {
        $('.daterange').daterangepicker();

        $("body").on("click", ".all", function (e) {
            if($(this).prop("checked") == true){
                $(".location").prop("checked", true);
            }
            else{
                $(".location").prop("checked", false);
            }
        });

        $("body").on("click", ".location", function (e) {
            if($(this).prop("checked") == false){
                $(".all").prop("checked", false);
            }
        });
    });
</script>

@endpush
