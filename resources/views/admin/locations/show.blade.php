@extends('admin.layouts.master')

@section('title', config('app.name', 'Laravel'))

@section('content')


<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
    <div class="kt-container  kt-grid__item kt-grid__item--fluid">
        <div class="row">
            <div class="col-lg-12">

                <div class="kt-portlet kt-portlet--mobile">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title">
                                {{ $location->state }}
                            </h3>
                        </div>
                        @can('create-area')
                        <div class="kt-portlet__head-toolbar">
                            <a class="btn btn-primary btn-location" href="#" role="button" data-toggle="modal"
                            data-target=".location_form" data-action="/admin/location/create_area/{{ $location->id }}" role="button"><i class="la la-plus"></i> New Area</a>
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
                        <div id="kt_datatable">

                              @if ($location->areas->isEmpty())

                                <p class="py-5 my-5 text-center">No areas added to this state yet</p>

                              @else
                              <table
                              class="kt-datatable"
                                id="roles-table"
                              width="100%"
                              role="grid">
                              <thead>
                                <tr>
                                  <th>Area</th>
                                  @can('delete-area')
                                  <th>Actions</th>
                                    @endcan
                                </tr>
                              </thead>

                              <tbody>
                                  @foreach ($location->areas as $l)
                                  <tr>
                                    <td>{{ $l->area }}</td>
                                    @can('delete-area')
                                    <td>
                                        <a class="btn btn-outline-danger delete-area" href="#" data-toggle="modal" data-target=".delete-modal-sm" data-id="{{ $l->id }}"><i class="fa fa-trash"></i></a>
                                    </td>
                                    @endcan
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

<div class="modal fade location_form" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title h4" id="mySmallModalLabel">Create Area</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="{{ route('admin.location.create', ['id'=>$location->id]) }}" method="POST" id="create_location_form">
                <div class="modal-body">

                    @csrf
                    <div class="form-group">
                        <label>Area - City</label>
                        <input type="text" name="area" class="form-control loc-name" placeholder="Area"
                            required>
                        <input type="hidden" name="states_id" value="{{ $location->id }}">
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary">Save Area</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade delete-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title h4" id="mySmallModalLabel">Create Location</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="{{ route('admin.location.delete') }}" method="POST" class="delete-form" id="delete-modal">
                @csrf
                @method("DELETE")
                <div class="modal-body">
                    <p>Are you sure you want to delete this area?</p>
                    <input class="area-id" type="hidden" name="id" value="">
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger">Yes, Delete Area</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection

@push('scripts')

    <script>
        jQuery(document).ready(function () {

            $("#location_form").validate({
                rules: {
                    area: {
                        required: !0
                    },
                    states_id: {
                        required: !0
                    },
                    delivery_fee: {
                        required: !0
                    }

                }
            });

            $("body").on("click", ".btn-location-update", function () {
                $("#location_form").attr("action", $(this).data('action'));
                $(".method").val('PATCH');
                $(".loc-name").val($(this).data('state'));
            });

            $("body").on("click", ".delete-area", function () {
                $(".area-id").val($(this).data('id'));
            });

        });

    </script>

@endpush
