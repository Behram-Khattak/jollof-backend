@extends('admin.layouts.master')

@section('title', config('app.name', 'Laravel'))

@section('content')

<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
    <div class="kt-container  kt-grid__item kt-grid__item--fluid">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <!--begin::Portlet-->
                <div class="kt-portlet">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title">Edit PopUp</h3>
                        </div>
                    </div>
                    <!--begin::Form-->
                    <form class="kt-form" action="/admin/popup/{{ $banner->id }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="kt-portlet__body">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            @include('admin.banner.form')

                        </div>
                        <div class="kt-portlet__foot">
                            <div class="kt-form__actions">
                                <button type="submit" class="btn btn-primary">Update PopUp</button>

                            </div>
                        </div>
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Portlet-->
            </div>

        </div>
    </div>
</div>


@endsection


@push('scripts')

<script>
    jQuery(document).ready(function () {
        $('.daterange').daterangepicker();

        $("#hidebox").hide();

        $("body").on("click", "#addslider", function (e) {
            e.preventDefault();
            $(".slide:last").after($("#hidebox").html());

        });

        $("body").on("click", ".removeslide", function (e) {
            e.preventDefault();

            $(this)
                .parents(".slidex")
                .fadeOut(500, function () {
                    $(this).remove();
                });
        });

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
