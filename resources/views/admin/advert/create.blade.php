@extends('admin.layouts.master')

@section('title', config('app.name', 'Laravel'))

@section('content')

<div class="kt-subheader   kt-grid__item" id="kt_subheader">
    <div class="kt-container  kt-container--fluid ">
        <div class="kt-subheader__main">
            <h3 class="kt-subheader__title">Adverts</h3>
        </div>
    </div>
</div>

<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
    <div class="kt-container  kt-grid__item kt-grid__item--fluid">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <!--begin::Portlet-->
                <div class="kt-portlet">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title">Create New Advert</h3>
                        </div>
                    </div>
                    <!--begin::Form-->
                    <form class="kt-form" action="{{ url('admin/advert') }}" enctype="multipart/form-data" method="POST" id="banner_form">
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

                            <input type="hidden" name="banner_type" value="ad" >

                            <input type="hidden" name="microsite" value="{{ $microsite }}" >

                            <div class="form-group">

                                <label>Advert Slot</label>
                                <select class="form-control" name="slot">
                                    <option value="">Select Advert Slot</option>
                                    @foreach ($slots as $slot)

                                    <option value="{{ $slot }}">{{ ucfirst($slot) }}</option>

                                    @endforeach
                                </select>
                                <span class="form-text text-muted">Advert location on page</span>

                            </div>

                            <div class="form-group row slide">
                                <div class="col">
                                    <label>Advert Image:</label>
                                    <input type="file" name="file_url[]" class="form-control" placeholder="Image File">
                                    <span class="form-text text-muted">Image file of the advert</span>
                                </div>
                                <div class="col">
                                    <label>Advert Link:</label>
                                    <input type="text" name="link[]" value="" class="form-control" placeholder="Image Link/URL">
                                    <span class="form-text text-muted">Optional: URL link of the advert</span>
                                </div>
                            </div>

                            <div class="form-group text-right" id="slidebox">
                                <a href="#" class="" id="addslider"><i class="la la-plus"></i> add another advert</a>
                            </div>
                        </div>
                        <div class="kt-portlet__foot">
                            <div class="kt-form__actions">
                                <button type="submit" class="btn btn-primary">Create Advert</button>

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
                <label>Advert image:</label>
                <input type="file" name="file_url[]" class="form-control" placeholder="Image File">
                <span class="form-text text-muted">Image file of the advert</span>
            </div>
            <div class="col">
                <label>Advert Link:</label>
                <input type="text" name="link[]" value="{{ old('title', ($banner) ? $banner->link: null) }}" class="form-control" placeholder="Image Link/URL">
                <span class="form-text text-muted">Optional: URL link of the advert</span>
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

        $("#banner_form").validate({
            rules: {
                'title': {
                    required: !0
                },
                'slot': {
                    required: !0
                },
                'con_view[]': {
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

