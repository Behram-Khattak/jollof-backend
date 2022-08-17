@extends('admin.layouts.master')

@section('title', config('app.name', 'Laravel'))

@section('content')

<div class="kt-subheader   kt-grid__item" id="kt_subheader">
    <div class="kt-container  kt-container--fluid ">
        <div class="kt-subheader__main">
            <h3 class="kt-subheader__title">Restaurant</h3>
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
                                Create Menu
                            </h3>
                        </div>
                    </div>
                    <div class="kt-portlet__body">

                        <form action="/admin/restaurant/create_menu/{{ Request::segment(4) }}" method="POST" id="menu_form">
                            <div class="form-group slide">
                                <label for="example-readonly">Menu Item</label>
                                <select name="menu" class="form-control select2">
                                    <option value="">Select Menu Item</option>
                                    @foreach ($consumables as $cn)
                                    <option value="{{ $cn->id }}">{{ $cn->name }}</option>
                                    @endforeach
                                </select>
                                @error("menu") <small style="color: red;"> {{ $message }} </small> @enderror
                            </div>

                            <div class="form-group slide">
                                <label for="example-readonly">Delivery Time</label>
                                <select name="delivery_time" class="form-control select2"  >
                                    <option value="">Select Delivery Time</option>

                                    <option value="30">30 Minute</option>
                                    <option value="60">60 Minute</option>
                                    <option value="90">90 Minute</option>
                                    <option value="120">120 Minute</option>
                                    <option value="150">150 Minute</option>
                                    <option value="180">180 Minute</option>

                                </select>
                                @error("menu") <small style="color: red;"> {{ $message }} </small> @enderror
                            </div>

                            <div class="form-group slide">
                                <label for="example-readonly">Menu Category</label>
                                <select name="category" class="form-control select2"  >
                                    <option value="">Select Menu Category</option>
                                    @foreach ($category as $c)
                                    <option value="{{ $c->id }}">{{ $c->name }}</option>
                                    @endforeach
                                </select>
                                @error("menu") <small style="color: red;"> {{ $message }} </small> @enderror
                            </div>

                            <div class="form-group slide">
                                <label for="example-readonly">Extras</label>
                                <select name="extra[]" class="form-control select2">
                                    <option value="">Select Extra</option>
                                    @foreach ($consumables as $cn)
                                    <option value="{{ $cn->id }}">{{ $cn->name }}</option>
                                    @endforeach
                                </select>
                                @error("extra") <small style="color: red;"> {{ $message }} </small> @enderror
                            </div>
                            @csrf
                            <div class="form-group text-right" id="slidebox">
                                <a href="#" class="" id="addslider"><i class="la la-plus"></i> add another extra</a>
                            </div>

                            <div class="form-group">

                                <button type="submit" class="btn btn-primary btn-lg">Create Menu</button>

                            </div>
                        </form>
                    </div>
                </div>

            </div>

        </div>

    </div>

</div>

<div id="hidebox">
    <div class="form-group slidex">
        <div class="row">
            <div class="col"><a href="#" class="removeslide float-right text-danger"><i class="la la-close"></i></a></div>
        </div>

        <label for="example-readonly">Extras</label>
        <select name="extra[]" class="form-control select2x">
            <option value="">Select Extra</option>
            @foreach ($consumables as $cn)
            <option value="{{ $cn->id }}">{{ $cn->name }}</option>
            @endforeach
        </select>
        @error("extra") <small style="color: red;"> {{ $message }} </small> @enderror

    </div>
</div>

@endsection

@push('scripts')

<script>
    jQuery(document).ready(function () {
        $('.select2').select2();

        $("#hidebox").hide();

        $("body").on("click", "#addslider", function (e) {
            e.preventDefault();
            $(".slide:last").after($("#hidebox").html());
            $('.select2x').addClass('select2');

        });

        $("body").on("click", ".removeslide", function (e) {
            e.preventDefault();

            $(this)
                .parents(".slidex")
                .fadeOut(500, function () {
                    $(this).remove();
                });
        });


        $("#menu_form").validate({
            rules: {
                'menu': {
                    required: !0
                },
                'category': {
                    required: !0
                },
                'extra[]': {
                    required: !0
                }

            }
        });
    });
</script>

@endpush
