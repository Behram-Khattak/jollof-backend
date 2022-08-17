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
            <div class="col-lg-12">
                <ul class="nav nav-pills" id="myTab1" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('merchant.restaurant.menu', ['any'=>$business->slug]) }}" aria-controls="profile">
                            <span class="nav-icon">
                                <i class="icon-xl fas fa-hamburger"></i>
                            </span>
                            <span class="nav-text">Menu</span>
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link active" href="{{ route('merchant.restaurant.consumable', ['any'=>$business->slug]) }}">
                            <span class="nav-icon">
                                <i class="icon-xl fas fa-ice-cream"></i>
                            </span>
                            <span class="nav-text">Menu Items</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('merchant.restaurant.category', ['any'=>$business->slug]) }}">
                            <span class="nav-icon">
                                <i class="icon-xl fas fa-tags"></i>
                            </span>
                            <span class="nav-text">Cuisine Category</span>
                        </a>
                    </li>
                </ul>
                {{--  <ul class="nav nav-tabs nav-fill mb-0" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('merchant.restaurant.show', ['any'=>$business->slug]) }}">Details</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('merchant.restaurant.category', ['any'=>$business->slug]) }}">Cuisine Category</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('merchant.restaurant.consumable', ['any'=>$business->slug]) }}">Menu Items</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('merchant.restaurant.menu', ['any'=>$business->slug]) }}">Menus</a>
                    </li>
                </ul>  --}}
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="kt-portlet kt-portlet--mobile">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title">
                                Consumable
                            </h3>
                        </div>
                        <div class="kt-portlet__head-toolbar">
                            <a class="btn btn-primary create_consumable_btn" href="#" role="button" data-toggle="modal"
                                data-target=".consumable_form" data-action="/merchant/restaurant/create_consumable"><i
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
                                                        <td><img src="{{ empty($c->getFirstMediaUrl()) ? url('images/noimg.png') : $c->getFirstMediaUrl() }}"
                                                                class="img-fluid" width="100px"></td>
                                                        <td>{{ $c->name }}</td>
                                                        <td>{{ $c->type }}</td>
                                                        <td>{{ $c->price }}</td>
                                                        <td class="text-right">
                                                            <a href="#" class="px-2 update_consumable_btn"
                                                                data-toggle="modal" data-target=".consumable_form"
                                                                data-toggle="kt-tooltip" data-placement="top"
                                                                data-original-title="Edit"
                                                                data-action="/merchant/restaurant/update_consumable/{{ $c->id }}"
                                                                data-cname="{{ $c->name }}"
                                                                data-ctype="{{ $c->type }}"
                                                                data-cprice="{{ $c->price }}"><i
                                                                    class="fa fa-pen"></i></a>
                                                            <a href="#" class="px-2 delete_consumable_btn"
                                                                data-toggle="modal" data-target=".delete_consumable"
                                                                data-toggle="kt-tooltip" data-placement="top"
                                                                data-original-title="Delete"
                                                                data-action="/merchant/restaurant/delete_consumable/{{ $c->id }}"><i
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


@endsection

@push('scripts')

    <script>
        jQuery(document).ready(function () {

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

        });

    </script>

@endpush
