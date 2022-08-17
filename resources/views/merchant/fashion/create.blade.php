@extends('merchant.layouts.master')

@section('title', 'Create New Product | Jollof')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/basic.css') }}">
<link rel="stylesheet" href="{{ asset('css/dropzone.css') }}">
@endpush

@section('content')

    <div class="kt-content kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">

        <!-- begin:: Content -->
        <div class="kt-container kt-grid__item kt-grid__item--fluid">
            <div class="row">
                <div class="col-md-12">
                    <!--begin::Portlet-->
                    <div class="kt-portlet">
                        <div class="kt-portlet__head">
                            <div class="kt-portlet__head-label">
                                <h3 class="kt-portlet__head-title">Create New Fashion Product</h3>
                            </div>
                        </div>
                        <div class="kt-portlet__body">
                            <form method="POST" action="{{ route('merchant.fashion.store', ['business'=>$business]) }}">
                                @include('merchant.fashion.form')
                            </form>
                        </div>

                    </div>

                    <!--end::Portlet-->
                </div>

            </div>
        </div>

        <!-- end:: Content -->
    </div>



@endsection

@push('scripts')

<script type="text/javascript" src="{{ asset('js\dropzone.js') }}"></script>

<script>
    Dropzone.autoDiscover = false;
    $(function(){
        var uploadedDocumentMap = {}
        $("div#product-image").dropzone({
            url: "{{ route('merchant.fashion.media') }}",
            addRemoveLinks: true,
            maxFiles: 5,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            success: function (file, response) {
                console.log(file.dataURL);

                $('form').append('<input type="hidden" name="product_image[]" value="' + file.dataURL + '">')
                uploadedDocumentMap[file.name] = response.name
            },
            removedfile: function (file) {
                file.previewElement.remove()
                var name = ''
                if (typeof file.file_name !== 'undefined') {
                    name = file.file_name
                } else {
                    name = uploadedDocumentMap[file.name]
                }
                $('form').find('input[name="product_image[]"][value="' + file.dataURL + '"]').remove()
            },
         });

        $('body').on('change', '#category', function(){
            var cat = $(this).find(':selected').data('id');
            var url = "/merchant/fashioncategory/"+cat;

            $.get(url, function(data, status){
                var cat = $(this).find(':selected').data('id');

                $("#subcategory").find('option').remove();
                $.each(data, function(index, value) {
                    $("#subcategory").append("<option value='"+ value.id +"' data-id='"+ value.id +"'>"+ value.name +"</option>");
                });
            });
        });


        $('body').on('change', '#subcategory', function(){
            var cat = $(this).find(':selected').data('id');
            var url = "/merchant/fashioncategory/"+cat;

            $.get(url, function(data, status){
                $("#variant").find('option').remove();
                $.each(data, function(index, value) {
                    $("#variant").append("<option value='"+ value.id +"'>"+ value.name +"</option>");
                });
            });
        });

        $('.daterange').daterangepicker({
            timePicker: true,
            timePicker24Hour: true,
            timePickerIncrement: 30,
            locale: {
                format: 'MM/DD/YYYY H:mm'
            }
        });
    });
</script>

@endpush
