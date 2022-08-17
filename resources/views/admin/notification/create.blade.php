@extends('admin.layouts.master')

@section('title', config('app.name', 'Laravel'))

@section('content')

<div class="kt-subheader   kt-grid__item" id="kt_subheader">
    <div class="kt-container  kt-container--fluid ">
        <div class="kt-subheader__main">

            <h3 class="kt-subheader__title">Notifications</h3>
            <span class="kt-subheader__separator kt-hidden"></span>
        </div>
    </div>
</div>

<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
    <div class="kt-container  kt-grid__item kt-grid__item--fluid">
        <div class="row justify-content-center">
            <div class="col-lg-10">

                <div class="kt-portlet kt-portlet--mobile">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title">
                                Create Notifications
                            </h3>
                        </div>
                    </div>
                    <div class="kt-portlet__body">

                        <form action="/admin/notification" method="POST" id="notification_form">
                            @include('partials._form_errorbag')
                            @include('admin.notification.form')

                            <div class="form-group">

                                <button type="submit" class="btn btn-primary btn-lg">Create Notification</button>

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

        $("#notification_form").validate({
            rules: {
                title: {
                    required: !0
                },
                type: {
                    required: !0
                },
                message: {
                    required: !0
                },
                'location[]': {
                    required: !0
                },
                start_date: {
                    required: !0
                },
                status: {
                    required: !0
                }
            }
        });
    });
</script>

@endpush
