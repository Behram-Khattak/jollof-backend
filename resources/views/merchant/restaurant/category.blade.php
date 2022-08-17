@extends('merchant.layouts.master')

@section('title', 'Merchant: Restaurants')

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
            <div class="col-lg-12">
                <div class="kt-portlet kt-portlet--mobile">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title">
                                Cuisine Category
                            </h3>
                        </div>
                        <!-- If any errors are encountered-->
                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        <div class="kt-portlet__head-toolbar">
                            <a class="btn btn-primary create_category_btn" href="#" role="button" data-toggle="modal"
                            data-target=".category_form" data-action="/merchant/restaurant/create_category"><i
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
                                                                data-action="{{ route('merchant.restaurant.edit.category', [request()->route('business'), 'id'=> $cat->id ]) }}"
                                                                data-category="{{ $cat->name }}"><i
                                                                    class="fa fa-pen"></i></a>
                                                            <a href="#" class="px-2 delete_category_btn"
                                                                data-toggle="modal" data-target=".delete_category"
                                                                data-toggle="kt-tooltip" data-placement="top"
                                                                data-original-title="Delete"
                                                                data-action="{{ route('merchant.restaurant.delete.category', [request()->route('business'), 'id'=> $cat->id ]) }}"><i
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
            <form action="/merchant/restaurant/create_category" method="POST" id="create_category_form">
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
        });

    </script>

@endpush
