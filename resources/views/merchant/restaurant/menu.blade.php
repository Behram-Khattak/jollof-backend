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

                <div class="kt-portlet kt-portlet--mobile">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title">
                                Menu
                            </h3>
                        </div>
                        <div class="kt-portlet__head-toolbar">
                            <a class="btn btn-primary" href="{{ route('merchant.restaurant.create.menu', request()->route('business')) }}"
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
                                                <th>Toppings</th>
                                                <th>Price <small>(NGN)</small></th>
                                                <th class="text-right">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($menus as $menu)

                                        <tr>
                                            <td><img src="{{ empty($menu->getFirstMediaUrl('menu')) ? url('images/noimg.png') : $menu->getFirstMediaUrl('menu') }}" class="img-fluid" width="100px"></td>
                                            <td>{{ $menu->menu }}<br>{{ $menu->description }}</td>
                                            <td>
                                            @if($menu->extra)
                                                @foreach ($menu->extra as $key => $menuItems)
                                                    <h5>{{ (isset($menuItems["title"])) ? $menuItems["title"] : "" }}</h5>
                                                    <ul class="list-unstyled">
                                                        @foreach ($menuItems["items"] as $item)
                                                        <li><strong>{{ (isset($item["name"])) ? $item["name"] : "" }}</strong> - N{{ (isset($item["price"])) ? number_format($item["price"], 2) : "" }}</li>
                                                        @endforeach
                                                    </ul>
                                                @endforeach
                                            @endif
                                            </td>
                                            <td>
                                                @if($menu->type == "PROMO")
                                                {!! calculateMenuPrice($menu->price, $menu->sales_price, $menu->sales_start, $menu->sales_end) !!}
                                                @else
                                                    {{ number_format($menu->price, 2) }}
                                                @endif
                                            </td>
                                            <td class="text-right">
                                                <a href="{{ route('merchant.restaurant.edit.menu', [request()->route('business'), 'id' => $menu->id]) }}" class="btn btn-sm btn-outline-primary"><i class="fa fa-pen"></i></a>
                                                <a href="#" class="btn btn-sm btn-outline-danger delete_menu_btn" data-toggle="modal" data-target=".delete_menu" data-action="{{ route('merchant.restaurant.delete.menu', [request()->route('business'), 'id'=> $menu->id ]) }}"><i class="fa fa-trash-alt"></i></a>
                                            </td>
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

<div class="modal fade delete_menu" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
    style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title h4" id="mySmallModalLabel">Delete Menu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="" method="POST" id="delete_menu_form">
                <div class="modal-body">

                    <p>Are you sure you want to delete the menu?</p>
                    @csrf
                    @method('DELETE')

                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger">Yes, Delete Menu</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')

<script>

    $(function(){
        $("body").on("click", ".delete_menu_btn", function () {
            $("#delete_menu_form").attr("action", $(this).data('action'));
        });
    });

</script>

@endpush
