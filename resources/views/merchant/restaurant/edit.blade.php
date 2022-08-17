@extends('merchant.layouts.master')

@section('title', config('app.name', 'Laravel'))

@section('content')

<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
    <div class="kt-container  kt-grid__item kt-grid__item--fluid">
        <div class="row justify-content-center">
            <div class="col-lg-10">

                <div class="kt-portlet kt-portlet--mobile">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title">
                                Edit Restaurant
                            </h3>
                        </div>
                    </div>
                    <div class="kt-portlet__body">

                        <form action="/admin/restaurant/{{ $restaurant->id }}" enctype="multipart/form-data" method="POST">
                            @method('PATCH')

                            @include('admin.restaurant.form')

                            <div class="form-group">

                                <button type="submit" class="btn btn-primary btn-lg">Update Restaurant</button>

                            </div>
                        </form>
                    </div>
                </div>

            </div>

        </div>

    </div>

</div>
<div id="state-data" style="display: none;">{{ json_encode(locations_json()) }}</div>
@endsection

@push('scripts')

<script>
    jQuery(document).ready(function () {
        $('.select2').select2();
        $('state-data').hide();

        $("body").on("click", ".all", function (e) {
            if($(this).prop("checked") == true){
                $(".location").prop("checked", true);
            }
            else{
                $(".location").prop("checked", false);
            }
        });

        function load_areas(state){
            var data = JSON.parse($("#state-data").html());
            var areas = data[state];

            $.each(areas, function(index, value) {
                $("#areas").append("<option value='"+ index +"'>" + value + "</option>");
            });
        }

        if($("#states").val() !== ""){
            load_areas($("#states").val());
        }

        $("#states").change("#states", function(){
            var state = $(this).val();
            load_areas(state);
        });

        $("body").on("click", ".location", function (e) {
            if($(this).prop("checked") == false){
                $(".all").prop("checked", false);
            }
        });

        $("#restaurant_form").validate({
            rules: {
                name: {
                    required: !0
                },
                about: {
                    required: !0
                },
                address: {
                    required: !0
                },
                state: {
                    required: !0
                },
                city: {
                    required: !0
                },
                min_order: {
                    required: !0
                },
                delivery_fee: {
                    required: !0
                },
                delivery_time: {
                    required: !0
                },
                'delivery_options[]': {
                    required: !0
                },
                disposable: {
                    required: !0
                },
                'payment_types[]': {
                    required: !0
                },
                logo: {
                    required: !0
                },
                cover: {
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
