@extends('admin.layouts.master')

@section('title', 'Admin: Restaurants')

@section('content')

<div class="kt-subheader   kt-grid__item" id="kt_subheader">
    <div class="kt-container  kt-container--fluid ">
        <div class="kt-subheader__main">
            <h3 class="kt-subheader__title">Restaurant</h3>
            <span class="kt-subheader__separator kt-hidden"></span>
            <div class="kt-subheader__breadcrumbs">
                <a href="/admin/restaurants" class="kt-subheader__breadcrumbs-home"><i
                        class="flaticon2-shelter"></i></a>
                <span class="kt-subheader__breadcrumbs-separator"></span>
                <a class="kt-subheader__breadcrumbs-link">Restaurant details</a>
            </div>
        </div>
    </div>
</div>

<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
    <div class="kt-container  kt-grid__item kt-grid__item--fluid">
        <div class="row">
            <div class="col-lg-6">
                <div class="kt-portlet kt-portlet--mobile">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title">
                                Restaurant Details
                            </h3>
                        </div>
                    </div>
                    <div class="kt-portlet__body p-0">
                        <div id="kt_table_1_wrapper" class="kt_dataTables_wrapper">
                            <div class="row">
                                <div class="col-sm-12">
                                    <table class="table table-head-noborder">
                                        <tbody>
                                            <tr>
                                                <th scope="row">Name</th>
                                                <td>{{ $business->name }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Address</th>
                                                <td>{{ $location->address }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Phone</th>
                                                <td>{{ $business->telephone }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Email</th>
                                                <td>{{ $business->email }}</td>
                                            </tr> 
                                            <tr>
                                                <th scope="row">City</th>
                                                <td>{{ $location->city }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">State</th>
                                                <td>{{ $location->state }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Minimum Order</th>
                                                <td>{{ $restaurant->min_order }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Delivery Fee</th>
                                                <td>{{ $restaurant->delivery_fee }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Delivery Time</th>
                                                <td>{{ $restaurant->delivery_time }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Pack</th>
                                                <td>{{ $restaurant->disposable }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Delivery Options</th>
                                                <td>{!! str_to_list($restaurant->delivery_options) !!}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Payment Options</th>
                                                <td>{!! str_to_list($restaurant->payment_types) !!}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="kt-portlet kt-portlet--mobile">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title">
                                Logo
                            </h3>

                        </div>
                        <div class="kt-portlet__head-toolbar">
                            <a href="#" role="button" data-toggle="modal" data-target=".upload_form" class="btn btn-outline-primary logo_upload_btn"><i class="fa fa-pen"></i></a>
                        </div>
                    </div>
                    <div class="kt-portlet__body p-0">
                        <div id="kt_table_1_wrapper">
                            <div class="row">
                                <div class="col-sm-12">
                                    <p class="text-center">
                                        @if(isset($pictures['logo']))
                                            <img src="{{ $pictures['logo'] }}"
                                                class="img-fluid">
                                        @else
                                            No Restaurant Logo added
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="kt-portlet kt-portlet--mobile">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title">
                                Cover Profile Picture
                            </h3>
                        </div>
                        <div class="kt-portlet__head-toolbar">
                            <a href="#" role="button" data-toggle="modal" data-target=".upload_form" class="btn btn-outline-primary cover_upload_btn"><i class="fa fa-pen"></i></a>
                        </div>
                    </div>
                    <div class="kt-portlet__body p-0">
                        <div id="kt_table_1_wrapper">
                            <div class="row">
                                <div class="col-sm-12">
                                    <p class="text-center">
                                        @if(isset($pictures['cover']))
                                            <img src="{{ $pictures['cover'] }}"
                                                class="img-fluid">
                                        @else
                                            No Restaurant cover image added
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <ul class="nav nav-tabs nav-fill mb-0" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#kt_tabs_4_1">Cuisine Category</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#kt_tabs_4_2">Consumables</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#kt_tabs_4_3">Menus</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="kt_tabs_4_1" role="tabpanel">
                        <div class="kt-portlet kt-portlet--mobile">
                            <div class="kt-portlet__head">
                                <div class="kt-portlet__head-label">
                                    <h3 class="kt-portlet__head-title">
                                        Cuisine Category
                                    </h3>
                                </div>
                                <div class="kt-portlet__head-toolbar">
                                    <a class="btn btn-primary create_category_btn" href="#" role="button" data-toggle="modal"
                                        data-target=".category_form" data-action="/admin/restaurant/create_category"><i
                                            class="la la-plus"></i> New Cuisine Category</a>
                                </div>
                            </div>
                            <div class="kt-portlet__body p-0">
                                <div id="kt_table_1_wrapper">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            @if($category->isEmpty())
                                                <p class="text-center">No Cuisine Category created</p>
                                            @else

                                                <table class="table table-head-noborder">
                                                    <thead>
                                                        <tr>
                                                            <th>Name</th>
                                                            <th class="text-right">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($category as $cat)
                                                            <tr>
                                                                <td>{{ $cat->name }}</td>
                                                                <td class="text-right">
                                                                    <a href="#" class="px-2 update_category_btn"
                                                                        data-toggle="modal" data-target=".category_form"
                                                                        data-toggle="kt-tooltip" data-placement="top"
                                                                        data-original-title="Edit"
                                                                        data-action="/admin/restaurant/update_category/{{ $cat->id }}"
                                                                        data-category="{{ $cat->name }}"><i
                                                                            class="fa fa-pen"></i></a>
                                                                    <a href="#" class="px-2 delete_category_btn"
                                                                        data-toggle="modal" data-target=".delete_category"
                                                                        data-toggle="kt-tooltip" data-placement="top"
                                                                        data-original-title="Delete"
                                                                        data-action="/admin/restaurant/delete_category/{{ $cat->id }}"><i
                                                                            class="fa fa-trash-alt"></i></a>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            @endif
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="kt_tabs_4_2" role="tabpanel">
                        <div class="kt-portlet kt-portlet--mobile">
                            <div class="kt-portlet__head">
                                <div class="kt-portlet__head-label">
                                    <h3 class="kt-portlet__head-title">
                                        Consumable
                                    </h3>
                                </div>
                                <div class="kt-portlet__head-toolbar">
                                    <a class="btn btn-primary create_consumable_btn" href="#" role="button" data-toggle="modal"
                                        data-target=".consumable_form" data-action="/admin/restaurant/create_consumable"><i
                                            class="la la-plus"></i> New Consumable</a>
                                </div>
                            </div>
                            <div class="kt-portlet__body p-0">
                                <div id="kt_table_1_wrapper">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            @if($consumable->isEmpty())
                                                <p class="text-center">No Consumable created</p>
                                            @else

                                                <table class="table table-head-noborder">
                                                    <thead>
                                                        <tr>
                                                            <th>Picture</th>
                                                            <th>Name</th>
                                                            <th>Type</th>
                                                            <th>Price <small>(NGN)</small></th>
                                                            <th class="text-right">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($consumable as $c)
                                                            <tr>
                                                                <td width=40%><img src="{{ empty($c->getFirstMediaUrl()) ? url('images/noimg.png') : $c->getFirstMediaUrl() }}"
                                                                        class="img-fluid"></td>
                                                                <td>{{ $c->name }}</td>
                                                                <td>{{ $c->type }}</td>
                                                                <td>{{ $c->price }}</td>
                                                                <td class="text-right">
                                                                    <a href="#" class="px-2 update_consumable_btn"
                                                                        data-toggle="modal" data-target=".consumable_form"
                                                                        data-toggle="kt-tooltip" data-placement="top"
                                                                        data-original-title="Edit"
                                                                        data-action="/admin/restaurant/update_consumable/{{ $c->id }}"
                                                                        data-cname="{{ $c->name }}"
                                                                        data-ctype="{{ $c->type }}"
                                                                        data-cprice="{{ $c->price }}"><i
                                                                            class="fa fa-pen"></i></a>
                                                                    <a href="#" class="px-2 delete_consumable_btn"
                                                                        data-toggle="modal" data-target=".delete_consumable"
                                                                        data-toggle="kt-tooltip" data-placement="top"
                                                                        data-original-title="Delete"
                                                                        data-action="/admin/restaurant/delete_consumable/{{ $c->id }}"><i
                                                                            class="fa fa-trash-alt"></i></a>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="kt_tabs_4_3" role="tabpanel">
                        <div class="kt-portlet kt-portlet--mobile">
                            <div class="kt-portlet__head">
                                <div class="kt-portlet__head-label">
                                    <h3 class="kt-portlet__head-title">
                                        Menu
                                    </h3>
                                </div>
                                <div class="kt-portlet__head-toolbar">
                                    <a class="btn btn-primary" href="/admin/restaurant/create_menu/{{ $restaurant->id }}"
                                        role="button"><i class="la la-plus"></i> New Menu</a>
                                </div>
                            </div>
                            <div class="kt-portlet__body">
                                <div id="kt_table_1_wrapper">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <table class="table table-head-noborder">
                                                <thead>
                                                    <tr>
                                                        <th>Picture</th>
                                                        <th>Name</th>
                                                        <th>Price <small>(NGN)</small></th>
                                                        <th class="text-right">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                @foreach ($menus as $menu)

                                                <tr>
                                                    <td width=40%><img src="{{ empty($menu->consumables->getFirstMediaUrl()) ? url('images/noimg.png') : $menu->consumables->getFirstMediaUrl() }}" class="img-fluid"></td>
                                                    <td>{{ $menu->consumables->name }}</td>
                                                    <td><small>(NGN)</small>{{ $menu->consumables->price }}</td>
                                                    <td class="text-right"><a href="#" class="btn btn-sm btn-outline-danger"><i class="fa fa-trash-alt"></i></a></td>
                                                </tr>
                                                @endforeach

                                                </tbody>
                                            </table>

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<div class="modal fade delete_category" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
    style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title h4" id="mySmallModalLabel">Delete Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="" method="POST" class="" id="delete_category_form">
                <div class="modal-body">

                    <p>Are you sure you want to delete the cuisine category?</p>
                    @csrf
                    @method('DELETE')

                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger">Yes, Delete Category</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                </div>
            </form>
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
            <form action="/admin/restaurant/create_category" method="POST" id="create_category_form">
                <div class="modal-body">

                    @csrf
                    <div class="form-group">
                        <label>Cuisine Category Name</label>
                        <input type="text" name="name" class="form-control cat-name" placeholder="Cuisine Category name"
                            required>
                        <input type="hidden" name="restaurant_id" class="form-control" value="{{ $restaurant->id }}"
                            required>
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

<div class="modal fade delete_consumable" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
    style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title h4" id="mySmallModalLabel">Delete Consumable</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="" method="POST" class="" id="delete_consumable_form">
                <div class="modal-body">

                    <p>Are you sure you want to delete the consumable?</p>
                    @csrf
                    @method('DELETE')

                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger">Yes, Delete Consumable</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade consumable_form" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
    style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title h4" id="mySmallModalLabel">Consumable (Food & Drinks)</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="" method="POST" id="consumable_form" enctype="multipart/form-data">
                <div class="modal-body">

                    @csrf
                    <div class="form-group">
                        <label>Consumable Type</label>
                        <div class="kt-radio-inline">
                            <label class="kt-radio">
                                <input type="radio" name="type" value="food"
                                    {{ (isset($consumable->type)) ? ($consumable->type == "food" ? "checked" : "")  : "checked" }}>Food
                                <span></span>
                            </label>
                            <label class="kt-radio">
                                <input type="radio" name="type" value="drink"
                                    {{ (isset($consumable->type)) ? ($consumable->type == "drink" ? "checked" : "") : "" }}>
                                Drink
                                <span></span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Consumable Name</label>
                        <input type="text" name="name" class="form-control consumable-name"
                            placeholder="Consumable name" required>
                        <input type="hidden" name="restaurant_id" class="form-control" value="{{ $restaurant->id }}"
                            required>
                        <input type="hidden" class="method" name="_method" value="POST">
                    </div>
                    <div class="form-group">
                        <label>Consumable Price</label>
                        <input type="text" name="price" class="form-control consumable-price" placeholder="Price"
                            required>
                    </div>
                    <div class="form-group">
                        <label>Picture of Consumable</label>
                        <input type="file" name="picture" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary">Save Consumable</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade upload_form" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
    style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title h4" id="mySmallModalLabel">Upload</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="{{ url('admin/restaurant/upload/'.$restaurant->id) }}" method="POST" class="the_upload_form" enctype="multipart/form-data">
                <div class="modal-body">

                    <div class="form-group">
                        <label>Upload File</label>
                        <input type="file" name="picture" class="form-control picture" required>
                        <input type="hidden" name="image-type" class="image-type" required>
                        <div class="upload-error text-danger"></div>
                    </div>
                    @csrf

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary send-upload">Upload</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection

@push('scripts')

    <script>
        jQuery(document).ready(function () {

            $("#create_category_form").validate({
                rules: {
                    name: {
                        required: !0
                    },
                    restaurant_id: {
                        required: !0
                    }
                }
            });

            $("body").on("click", ".create_category_btn", function () {
                $("#create_category_form").attr("action", $(this).data('action'));
                $(".method").val('POST');
                $(".cat-name").val('');
            });

            $("body").on("click", ".update_category_btn", function () {
                $("#create_category_form").attr("action", $(this).data('action'));
                $(".method").val('PATCH');
                $(".cat-name").val($(this).data('category'));
            });

            $("body").on("click", ".delete_category_btn", function () {
                $("#delete_category_form").attr("action", $(this).data('action'));
            });


            $("#consumable_form").validate({
                rules: {
                    name: {
                        required: !0
                    },
                    restaurant_id: {
                        required: !0
                    },
                    type: {
                        required: !0
                    },
                    price: {
                        required: !0
                    }
                }
            });

            $("body").on("click", ".create_consumable_btn", function () {
                $("#consumable_form").attr("action", $(this).data('action'));
                $(".method").val('POST');
                $(".consumable-name").val('');
                $(".consumable-price").val('');
            });

            $("body").on("click", ".update_consumable_btn", function () {
                $("#consumable_form").attr("action", $(this).data('action'));
                $(".method").val('PATCH');
                $(".consumable-name").val($(this).data('cname'));
                $(".consumable-price").val($(this).data('cprice'));
            });

            $("body").on("click", ".delete_consumable_btn", function () {
                $("#delete_consumable_form").attr("action", $(this).data('action'));
            });

            $("body").on("click", ".logo_upload_btn", function(){
                $(".image-type").val("logo");
            });

            $("body").on("click", ".cover_upload_btn", function(){
                $(".image-type").val("cover");
            });

            $("body").on("click", ".send-upload", function (e) {

                e.preventDefault();
                var _URL = window.URL || window.webkitURL;
                var file = $(".picture")[0].files[0];

                img = new Image();
                imgtype = $('.image-type').val();
                var imgwidth = 0;
                var imgheight = 0;
                var maxwidth = (imgtype == 'logo') ? Number(400) : Number(1920);
                var maxheight = (imgtype == 'logo') ? Number(400) : Number(624);

                img.src = _URL.createObjectURL(file);
                img.onload = function() {

                    imgwidth = Number(this.width);
                    imgheight = Number(this.height);

                    if(imgwidth > maxwidth){
                        $(".upload-error").html("Image should not be more than "+ maxwidth + "x"+ maxheight);
                    }
                    else{
                        $(".the_upload_form").submit();
                    }
                }


            });
        });

    </script>

@endpush
