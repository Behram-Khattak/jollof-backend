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
                            <h3 class="kt-portlet__head-title">Create New Slider</h3>
                        </div>
                    </div>
                    <!--begin::Form-->
                    <form class="kt-form" action="{{ url('admin/slider') }}" enctype="multipart/form-data" method="POST" id="banner_form">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @csrf
                        <div class="kt-portlet__body">


                            @include('admin.banner.form')
                            <input type="hidden" name="banner_type" value="slider" >
                            <input type="hidden" name="slot" value="slider" >
                            <input type="hidden" name="microsite" value="{{ request()->segment(4) }}" >

                            <div class="form-group row slide">
                                <div class="col">
                                    <label>Slider Image:</label>
                                    <input type="file" name="file_url[]" class="form-control" placeholder="Image File">
                                    <span class="form-text text-muted">Image file of the banner</span>
                                </div>
                                <div class="col">
                                    <label>Slider Link:</label>
                                    <input type="text" name="link[]" value="" class="form-control" placeholder="Image Link/URL">
                                    <span class="form-text text-muted">Optional: URL link of the banner</span>
                                </div>
                            </div>
                            <div class="form-group row slide">
                                <div class="col">
                                    <label>Slider Image:</label>
                                    <input type="file" name="file_url[]" class="form-control" placeholder="Image File">
                                    <span class="form-text text-muted">Image file of the banner</span>
                                </div>
                                <div class="col">
                                    <label>Slider Link:</label>
                                    <input type="text" name="link[]" value="" class="form-control" placeholder="Image Link/URL">
                                    <span class="form-text text-muted">Optional: URL link of the banner</span>
                                </div>
                            </div>
                            <div class="form-group row slide">
                                <div class="col">
                                    <label>Slider Image:</label>
                                    <input type="file" name="file_url[]" class="form-control" placeholder="Image File">
                                    <span class="form-text text-muted">Image file of the banner</span>
                                </div>
                                <div class="col">
                                    <label>Slider Link:</label>
                                    <input type="text" name="link[]" value="" class="form-control" placeholder="Image Link/URL">
                                    <span class="form-text text-muted">Optional: URL link of the banner</span>
                                </div>
                            </div>

                            <div class="form-group text-right" id="slidebox">
                                <a href="#" class="" id="addslider"><i class="la la-plus"></i> add another slider</a>
                            </div>
                        </div>
                        <div class="kt-portlet__foot">
                            <div class="kt-form__actions">
                                <button type="submit" class="btn btn-primary">Create Slider</button>

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

<div id="hidebox">
    <div class="form-group slidex">
        <div class="row">
            <div class="col"><a href="#" class="removeslide float-right text-danger"><i class="la la-close"></i></a></div>
        </div>
        <div class="row">
            <div class="col">
                <label>Slider image:</label>
                <input type="file" name="file_url[]" class="form-control" placeholder="Image File">
                <span class="form-text text-muted">Image file of the banner</span>
            </div>
            <div class="col">
                <label>Image Link:</label>
                <input type="text" name="link[]" value="{{ old('title', ($banner) ? $banner->link: null) }}" class="form-control" placeholder="Image Link/URL">
                <span class="form-text text-muted">Optional: URL link of the banner</span>
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

        $("#banner_form").validate({
            rules: {
                title: {
                    required: !0
                },
                'file_url[]': {
                    required: !0
                },
                'link[]': {
                    required: !0
                }
            }
        });
    });
</script>

@endpush

