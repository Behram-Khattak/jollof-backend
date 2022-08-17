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

                        <form action="{{ route('merchant.restaurant.store.menu', request()->route('business')) }}" method="POST" id="menu_form"enctype="multipart/form-data" class="repeater">
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

                            @csrf
                            <div class="form-group text-center mt-5" id="slidebox">
                                <button type="button" class="btn btn-outline-info" data-repeater-create><i class="la la-plus"></i> add another extra group</button>
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

<div class="modal fade category_form" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
    style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title h4" id="mySmallModalLabel">Cuisine Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="{{ route('merchant.restaurant.create.category', request()->route('business')) }}" method="POST" id="create_category_form">
                <div class="modal-body">

                    @csrf
                    <div class="form-group">
                        <label>Cuisine Category Name</label>
                        <input type="text" name="name" class="form-control cat-name" placeholder="Cuisine Category name"
                            required>
                        <input type="hidden" name="restaurant_id" class="form-control" value="{{ $restaurant->id }}" required>
                        <input type="hidden" class="method" name="_method" value="POST">
                    </div>

                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary">Save Category</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                </div>
            </form>
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


        const managePromo = function(menuType){

            if(menuType == "PROMO"){
                $("input[name='sales_price']").val('');
                $("input[name='sales_price']").attr('readonly', false);
                $("input[name='sales_price']").removeClass('form-control-plaintext');
                $("input[name='sales_price']").addClass('form-control');
                $("input[name='schedule']").removeClass('form-control-plaintext');
                $("input[name='schedule']").addClass('form-control');
            }

            if(menuType == "REGULAR"){
                $("input[name='sales_price']").val('0');
                $("input[name='sales_price']").attr('readonly', true);
                $("input[name='sales_price']").removeClass('form-control');
                $("input[name='sales_price']").addClass('form-control-plaintext');
                $("input[name='schedule']").removeClass('form-control');
                $("input[name='schedule']").addClass('form-control-plaintext');
            }
        }

        let selectType = $("select[name='type']").val();
        managePromo(selectType);

        $("body").on('change', "select[name='type']", function(){
            managePromo($(this).val());
        });

        $repeater = $('.repeater').repeater({
            initEmpty: true,
            /**show: function () {
                $(this).slideDown();
            },
            hide: function (deleteElement) {
                if(confirm('Are you sure you want to delete this element?')) {
                    $(this).slideUp(deleteElement);
                }
            },*/
            repeaters: [{
                selector: '.inner-repeater'
            }]

        });

        $repeater.setList();


        $("#menu_form").validate({
            normalizer: function( value ) {
                return $.trim( value );
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
                'picture': {
                    required: !0
                },
                'price': {
                    required: !0,
                    digits: true
                },
                'sales_price': {
                    digits: true
                },
                'category': {
                    required: !0
                },
                'schedule': {
                    required: 0
                },
                'locations[]': {
                    required: !0
                }

            }
        });
    });
</script>

@endpush
