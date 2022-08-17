@extends('admin.layouts.master')

@section('title', config('app.name', 'Laravel'))

@section('content')

@if ($locations->isEmpty())

    <p class="text-center">No location added yet</p>
    {{--  <div class="text-center"><a href="#" class="btn btn-primary btn-location" data-toggle="modal"
        data-target=".location_form" data-target=".location_form" data-action="/admin/location"><i class="la la-plus"></i> New Location</a></div>  --}}

@else
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
    <div class="kt-container  kt-grid__item kt-grid__item--fluid">
        <div class="row">
            <div class="col-lg-12">

                <div class="kt-portlet kt-portlet--mobile">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title">
                                States
                            </h3>
                        </div>
                        <div class="kt-portlet__head-toolbar">
                            {{--  <a class="btn btn-primary" href="#" role="button" data-toggle="modal"
                            data-target=".location_form" data-action="/admin/location" role="button"><i class="la la-plus"></i> New State</a>  --}}
                        </div>
                    </div>
                    <div class="kt-portlet__body">

                        <!--begin: Search Form -->
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

                        <!--end: Search Form -->
                    </div>
                    <div class="kt-portlet__body kt-portlet__body--fit allstates">

                            <div id="kt_datatable">
                                <table

                                class="kt-datatable"
                                id="roles-table"
                                width="100%"
                                role="grid"
                                >
                                <thead>
                                    <tr>
                                    <th>State</th>
                                    <th>Status</th>
                                    @can('update-area')
                                    <th>Action</th>
                                    @endcan
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($locations as $l)

                                        <tr role="row" data-status="{{ $l->status }}">
                                            <td><a href="{{ route('admin.location.show', ['id'=>$l->id]) }}">{{ $l->state }}</a></td>
                                            <td>{!! ($l->status == 'active') ? '<span class="badge badge-success">active</span>' : '<span class="badge badge-warning">inactive</span>' !!}</td>
                                            @can('update-area')
                                            <td class="text-left">
                                                <a class="btn btn-outline btn-state-update" href="#" data-state="{{ $l->state }}" data-status="{{ $l->status }}" data-id="{{ $l->id }}">
                                                    <i class="fa fa-pen"></i> Edit
                                                </a>
                                            </td>
                                            @endcan
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

@endif

<div class="modal fade" id="location_form" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title h4" id="mySmallModalLabel">Create Location</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <form method="POST" action="{{ route('admin.location.update') }}">
                <div class="modal-body">

                    @csrf
                    @method('PATCH')
                    <div class="form-group">
                        <label>State</label>
                        <input type="text" name="state" class="form-control state" placeholder="State"
                            required>
                        <input type="hidden" name="stateid" class="stateid" value="">
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>

                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary">Save State</button>
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

            $("#location_form").validate({
                rules: {
                    state: {
                        required: !0
                    },
                    status: {
                        required: !0
                    }

                }
            });

            $("body").on("click", ".btn-state-update", function () {

                $(".state").val($(this).data('state'));
                $(".status").val($(this).data('status'));
                $(".stateid").val($(this).data('id'));

                $("#location_form").modal('show');
            });

            /**$("body").on("click", ".delete_category_btn", function () {
                $("#delete_category_form").attr("action", $(this).data('action'));
            });**/

        });

    </script>

@endpush
