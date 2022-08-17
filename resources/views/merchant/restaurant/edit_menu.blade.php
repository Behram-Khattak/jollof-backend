@extends('merchant.layouts.master')

@section('title', config('app.name', 'Laravel'))

@section('content')

<div class="kt-subheader   kt-grid__item" id="kt_subheader">
    <div class="kt-container  kt-container--fluid ">
        <div class="kt-subheader__main">
            <h3 class="kt-subheader__title">Restaurant</h3>
            <span class="kt-subheader__separator kt-hidden"></span>

        </div>
        <div class="kt-subheader__toolbar">
            <h5><a href="{{ route('merchant.restaurant.menu', request()->route('business')) }}"><i class="fas fa-arrow-left"></i> Back to Menus</a></h5>
            <span class="kt-subheader__separator kt-hidden"></span>

        </div>
    </div>
</div>

<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
    <div class="kt-container  kt-grid__item kt-grid__item--fluid">
        <div class="row justify-content-center">
            <div class="col-lg-12">

                <div class="kt-portlet kt-portlet--mobile">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title">
                                Create Menu
                            </h3>
                        </div>
                    </div>
                    <div class="kt-portlet__body">

                        <form action="{{ route('merchant.restaurant.update.menu', request()->route('business')) }}" method="POST" id="menu_form" enctype="multipart/form-data" class="repeater">
                            @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif

                            @include('merchant.restaurant.form')
                            <input type="hidden" name="id" value="{{ $menus->id }}">
                            @csrf
                            @method('PATCH')

                            <div class="form-group text-center mt-5" id="slidebox">
                                <button type="button" class="btn btn-outline-info" data-repeater-create><i class="la la-plus"></i> Add another extra group</button>
                            </div>

                            <div class="form-group">

                                <button type="submit" id="createmenu" class="btn btn-primary btn-lg">Create Menu</button>

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
        $('.select2').select2();

        $('.daterange').daterangepicker({
            timePicker: true,
            timePicker24Hour: true,
            timePickerIncrement: 30,
            locale: {
                format: 'MM/DD/YYYY H:mm'
            }
        });

        $("#hidebox").hide();

        $("#hidebox2").hide();

        var repeater = $('.repeater').repeater({
            initEmpty: true,
            repeaters: [{
                selector: '.inner-repeater'
            }]


        });

        var setData = '{!! $menus->toppings !!}';
        var jsondata = JSON.parse(setData);
        repeater.setList(jsondata);


        $("#menu_form").validate({
            normalizer: function(value) {
                return $.trim(value);
            },
            rules: {
                'menu': {
                    required: !0
                },
                'category': {
                    required: !0
                },
                'delivery_time': {
                    required: !0
                },
                'description': {
                    required: !0
                },
                'price': {
                    required: !0,
                    digits: true
                },
                'sales_price': {
                    required: !0,
                    digits: true
                },
                'category': {
                    required: !0
                },
                'schedule': {
                    required: !0
                },
                'locations[]': {
                    required: !0
                }

            }
        });
    });
</script>

@endpush
