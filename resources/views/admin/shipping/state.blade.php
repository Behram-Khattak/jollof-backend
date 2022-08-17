@extends('admin.layouts.master')

@section('title', 'Merchant: Restaurant Shipping')

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
                <a class="kt-subheader__breadcrumbs-link">Shipping</a>
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
                                {{ $state->state }} State Shipping
                            </h3>
                        </div>
                        @can('create-shipping-group')
                        <div class="kt-portlet__head-toolbar">
                            <a class="btn btn-primary create_category_btn" href="{{ route('admin.shipping.create', ['id'=>$state->id]) }}" role="button"><i
                                    class="la la-plus"></i> Create Shipping</a>
                        </div>
                        @endcan
                    </div>
                    <div class="kt-portlet__body">
                        <div class="kt-form kt-fork--label-right kt-margin-t-20 kt-margin-b-10">
                            <div class="row align-items-center">
                                <div class="col-xl-12 order-2 order-xl-1">
                                    <div class="row align-items-center">
                                        <div class="col-md-4 kt-margin-b-20-tablet-and-mobile">
                                            <div class="kt-input-icon kt-input-icon--left">
                                                <input type="text" class="form-control" placeholder="Search..."
                                                        id="generalSearch">
                                                <span class="kt-input-icon__icon kt-input-icon__icon--left">
                                                    <span><i class="la la-search"></i></span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="kt-portlet__body">
                        <div id="kt-datatable">

                            <table class="table table-head-noborder table-hover" id="roles-table">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Shipping</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($areas as $area)
                                        <tr>
                                            <td><a href="#">{{ $area->area }}</a></td>
                                            <td>
                                                @if($area->shipping->isEmpty())
                                                    <p>NA</p>
                                                @else
                                                <ul class="list-unstyled">
                                                    <li><span class='text-muted'>Min. Shipment Qty</span> - {{ $area->shipping[0]->min_shipment_qty }}</li>
                                                    <li><span class='text-muted'>Max. Shipment Qty</span> - {{ $area->shipping[0]->max_shipment_qty }}</li>
                                                    <li><span class='text-muted'>Shipment Price</span> - {{ $area->shipping[0]->shipment_price }}</li>
                                                </ul>
                                                @endif
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


<div class="modal fade" id="shippingCost" tabindex="-1" aria-labelledby="shippingCostModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Shipping Cost</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{ route('admin.shipping.store') }}" method="POST" id="menu_form">
            <div class="modal-body">

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="form-group">
                    <label for="example-readonly">Min. Shipment Quantity</label>
                    <input name="min_shipment_qty" type="text" class="form-control" value="{{ $group->min_shipment_qty ? old('min_shipment_qty', $group->min_shipment_qty) : '' }}" placeholder="Min. Shipment Quantity">
                    @error("min_shipment_qty") <small style="color: red;"> {{ $message }} </small> @enderror
                </div>

                <div class="form-group">
                    <label for="example-readonly">Max. Shipment Quantity</label>
                    <input name="max_shipment_qty" type="text" class="form-control" value="{{ $group->max_shipment_qty ? old('max_shipment_qty', $group->max_shipment_qty) : '' }}" placeholder="Max. Shipment Quantity">
                    @error("max_shipment_qty") <small style="color: red;"> {{ $message }} </small> @enderror
                </div>

                <div class="form-group">
                    <label for="example-readonly">Shipment Price/ Max. Shipment Quantity</label>
                    <input name="shipment_price" type="text" class="form-control" value="{{ $group->shipment_price ? old('shipment_price', $group->shipment_price) : '' }}" placeholder="Shipping Price">
                    @error("shipment_price") <small style="color: red;"> {{ $message }} </small> @enderror
                </div>

                @csrf

            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save Shipping Cost</a>
            </div>
        </form>
      </div>
    </div>
</div>



@endsection

@push('scripts')

<script>
    $(function(){
        $('body').on('click', '.manage_shipping_btn', function(){
            $('#shippingCost').modal('show');
        });
    });
</script>

@endpush
