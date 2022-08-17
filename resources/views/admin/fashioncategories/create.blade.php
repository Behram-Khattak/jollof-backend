@extends('admin.layouts.master')

@section('title', config('app.name', 'Jollof'))

@section('content')

<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
    <div class="kt-container  kt-grid__item kt-grid__item--fluid">
        <div class="row">
            <div class="col-lg-12">

                <div class="kt-portlet kt-portlet--mobile">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title">
                                Create Category
                            </h3>
                        </div>
                    </div>
                    <div class="kt-portlet__body">

                        <form action="/admin/categories/store" method="POST" id="voucher_form">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <div class="row">

                                @include('admin.fashioncategories.form')
                            </div>

                            <div class="form-group">

                                <button type="submit" class="btn btn-primary btn-lg">Merge Category</button>

                            </div>
                        </form>
                    </div>
                </div>

            </div>

        </div>

    </div>

</div>

<!-- Add new categories -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="/admin/maincategory/add" method="post">
      @csrf
        <div class="modal-body">
            <div class="form-group">
                <label for="category">Category</label>
                <input type="text" class="form-control" id="category" name="category" placeholder="Enter category name">
            </div>  
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
        </form>
    </div>
  </div>
</div>

<!-- Add sub category -->

<div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="/admin/subcategory/add" method="post">
      @csrf
        <div class="modal-body">
            <input id="subcatid" type="hidden" name="category" value="">
            <div class="form-group">
                <label for="subcategory">Sub Category</label>
                <input type="text" class="form-control" id="subcategory" name="subcategory" placeholder="Enter sub category name" required>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Add sub variant -->


<div class="modal fade" id="exampleModal3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add sub variant</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="/admin/subvariant/add" method="post">
      @csrf
        <div class="modal-body">
            <input id="subvarid" type="hidden" name="subcategory" value="">
            <div class="form-group">
                <label for="subcategory">Sub Variant</label>
                <input type="text" class="form-control" name="subvariant" placeholder="Enter sub variant name" required>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>
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

        $("#voucher_form").validate({
            rules: {
                title: {
                    required: !0
                },
                description: {
                    required: !0
                },
                redemption_details: {
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
            },
            invalidHandler: function(e, r) {
                $("#kt_form_1_msg").parent().removeClass("kt-hidden"), KTUtil.scrollTo("kt_form_1", -200)
            }
        })
    });

    if($('#category').val() == null){
        $('#addsubcat').attr('hidden', true);
        $('#addsubvar').attr('hidden', true);
    }
    $('#category').on('change', function(){
        // console.log($(this).val());
            var cat = $(this).find(':selected').data('id');
            // console.log(cat);
            $('#addsubcat').attr('hidden', false);
            $('#addsubvar').attr('hidden', false);
            $('#subcatid').val(cat);
            
            var url = "/admin/fashioncategory/"+cat;
            
            $.get(url, function(data, status){
                var cat = $(this).find(':selected').data('id');
                // console.log($('#category').val());
                if(data.length > 0){
                    $("#subcategory").find('option').remove();
                    $.each(data, function(index, value) {
                        $("#subcategory").append("<option value='"+ value.id +"' data-id='"+ value.id +"'>"+ value.name +"</option>");
                    });
                }else{
                    $("#subcat").find('select').remove();
                    $("#subvar").find('select').remove();
                    $("#subcat").append("<input type='text' class='form-control' placeholder='Enter new subcategory' readonly>");
                    $("#subcat").append("<input type='hidden' name='category' class='form-control' placeholder='Enter new subcategory' value='"+ $('#category').val() +"'>");
                    $("#subvar").append("<input type='text' class='form-control' placeholder='Enter new sub varient'>");
                }
            });
        });


        $('#subcategory').on('change', function(){
            var cat = $(this).find(':selected').data('id');
            var url = "/admin/fashioncategory/"+cat;
            $('#subvarid').val(cat);
            // if($('#subcategory').val() != null){
            // }
            $.get(url, function(data, status){
                if(data.length > 0){
                    $("#variant").find('option').remove();
                    $.each(data, function(index, value) {
                        $("#variant").append("<option value='"+ value.id +"'>"+ value.name +"</option>");
                    });
                }
                else {
                    $("#subvar").find('select').remove();
                    $("#subvar").append("<input type='text' name='subvariant' class='form-control' placeholder='Enter new sub varient' readonly>");
                }
            });
        });
</script>

@endpush
