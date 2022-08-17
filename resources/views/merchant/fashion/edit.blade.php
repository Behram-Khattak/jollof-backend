@extends('merchant.layouts.master')

@section('title', ucfirst($product->name) . ' | Jollof')

@section('content')

    <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">

        <div class="kt-portlet">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title">{{ \Illuminate\Support\Str::limit(ucfirst($product->name), 40) }}</h3>
                </div>
            </div>
            <div class="kt-portlet__body">

                <div class="kt-portlet__body">
                    <form method="POST" action="{{ route('merchant.fashion.edit', ['business'=>$business, 'fashionProduct'=>$product]) }}">
                        @method('PATCH')
                        @include('merchant.fashion.form')
                    </form>
                </div>

            </div>
        </div>

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
            init: function(){
                //ajax get product images
                //foreach loop them
                //add them to dropzone js
                var product = '{{ $product->id }}';
                var url = "/merchant/fashion/get/media/"+product;
                var myDropzone = this;

                $.get(url, function(data, status){

                    $.each(data, function(index, img) {
                        var mockFile = {
                            name: img.name,
                            size: img.size,
                            url: img.base64
                        }

                        myDropzone.displayExistingFile(mockFile, img.url);
                        $('form').append('<input type="hidden" name="product_image[]" value="' + img.base64 + '" data-name="'+ img.name +'">')
                        uploadedDocumentMap[img.name] = img.name
                    });

                });

            },
            success: function (file, response) {
                $('form').append('<input type="hidden" name="product_image[]" value="' + file.dataURL + '" data-name="'+ img.name +'">')
                uploadedDocumentMap[file.name] = response.name
            },
            removedfile: function (file) {
                console.log(file);
                file.previewElement.remove()
                var name = ''
                if (typeof file.file_name !== 'undefined') {
                    name = file.file_name
                } else {
                    name = uploadedDocumentMap[file.name]
                }
                //$('form').find('data[name="' + file.name + '"]').remove();
                $('*[data-name="' + file.name + '"]').remove();
            },
         });

        var cat = $('#category').find(':selected').data('id');
        var url = "/merchant/fashioncategory/"+cat;

        $.get(url, function(data, status){
            var cat = $(this).find(':selected').data('id');

            $("#subcategory").find('option').remove();
            $.each(data, function(index, value) {
                $("#subcategory").append("<option value='"+ value.id +"' data-id='"+ value.id +"'>"+ value.name +"</option>");
            });
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
