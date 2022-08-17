@extends('merchant.layouts.master')

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
            <div class="col-lg-12 mb-5">
                <ul class="nav nav-tabs nav-fill mb-0" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('merchant.restaurant.show', ['any'=>$business->slug]) }}">Details</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('merchant.restaurant.category', ['any'=>$business->slug]) }}">Cuisine Category</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('merchant.restaurant.consumable', ['any'=>$business->slug]) }}">Menu Items</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('merchant.restaurant.menu', ['any'=>$business->slug]) }}">Menus</a>
                    </li>
                </ul>
            </div>
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
                                                <td>{{ $restaurant->address }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Phone</th>
                                                <td>{{ $business->phone }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Email</th>
                                                <td>{{ $business->email }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">City</th>
                                                <td>{{ $restaurant->city }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">State</th>
                                                <td>{{ $restaurant->state }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Minimum Order</th>
                                                <td>{{ $restaurant->min_order }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Min Delivery Fee (NGN)</th>
                                                <td>{{ $restaurant->delivery_fee }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Min Delivery Time (Min)</th>
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
            <form action="{{ url('merchant/restaurant/upload/'.$restaurant->id) }}" method="POST" class="the_upload_form" enctype="multipart/form-data">
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
