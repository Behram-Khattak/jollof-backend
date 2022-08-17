@extends('admin.layouts.master')

@section('title', 'Roles | Jollof')

@section('content')
    <!-- begin:: Content -->
    <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__head kt-portlet__head--lg">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title">
                        Roles
                    </h3>
                </div>
                @can('create-roles')
                <div class="kt-portlet__head-toolbar">
                    <div class="kt-portlet__head-wrapper">
                        <b-link
                            href="{{ route('admin.roles.create') }}"
                            role="button"
                            class="btn btn-primary btn-bold btn-upper btn-font-sm"
                        >
                            <i class="la la-plus"></i>
                            New Role
                        </b-link>
                    </div>
                </div>
                @endcan
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
                                <div class="col-md-4 kt-margin-b-20-tablet-and-mobile">
                                    <div class="kt-form__group kt-form__group--inline">
                                        <div class="kt-form__label">
                                            <label for="kt_form_status">Status:</label>
                                        </div>
                                        <div class="kt-form__control">
                                            <select class="form-control bootstrap-select" id="kt_form_status">
                                                <option value="">All</option>
                                                <option value="active">Active</option>
                                                <option value="inactive">Inactive</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!--end: Search Form -->
            </div>
            <div class="kt-portlet__body kt-portlet__body--fit">

                <!--begin: Datatable -->
                <table class="kt-datatable" id="roles-table" width="100%">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Created</th>
                        <th>Last Updated</th>
                        <th>Status</th>
                        @canany(['update-roles','delete-roles'])
                        <th>Actions</th>
                        @endcanany
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($roles as $role)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ ucfirst($role->name) }}</td>
                            <td>{{ $role->created_at->toFormattedDateString() }}</td>
                            <td>{{ $role->updated_at->toFormattedDateString() }}</td>
                            <td>
                                <span>
                                    <span
                                        class="kt-badge kt-badge--{{ $role->trashed() ? "danger" : "brand" }} kt-badge--bold kt-badge--lg kt-badge--inline kt-badge--pill">
                                        {{ ucfirst($role->status) }}
                                    </span>
                                </span>
                            </td>
                            <td>
                                @can('update-roles')
                                <b-link
                                    href="{{ route('admin.roles.edit', $role) }}"
                                    class="btn btn-sm btn-icon btn-icon-md btn-outline-hover-info"
                                    title="Edit"
                                >
                                    <i class="fa fa-pen"></i>
                                </b-link>
                                @endcan
                                @can('delete-roles')
                                @if ($role->trashed())
                                    <button
                                        class="btn btn-sm btn-icon btn-icon-md btn-outline-hover-success"
                                        title="Restore"
                                        id="role-{{ $role->id }}"
                                        onclick="document.getElementById('restore-role-{{ $role->id }}').submit();"
                                    >
                                        <i class="fa fa-sync" id="role-{{ $role->id }}"></i>
                                    </button>
                                    @include('admin.roles._form-restore')
                                @else
                                    {{-- duplicate id on button and inner icon is intentional--}}
                                    <button
                                        class="btn btn-sm btn-icon btn-icon-md btn-outline-hover-danger js-delete-trigger"
                                        title="Delete"
                                        id="role-{{ $role->id }}"
                                    >
                                        <i class="fa fa-trash" id="role-{{ $role->id }}"></i>
                                    </button>
                                    @include('admin.roles._form-delete')
                                @endif
                                @endcan

                            </td>
                        </tr>
                    @endforeach

                    </tbody>

                </table>

                <!--end: Datatable -->
            </div>
        </div>

    </div>

    <!-- end:: Content -->
@endsection

@push('scripts')

    <script>
        jQuery(document).ready(function () {
            $('#roles-table').on('click', '.js-delete-trigger', function (event) {
                swal.fire({
                    heightAuto: false,
                    title: 'Are you sure?',
                    text: "All permissions on the role will be removed!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Delete',
                    cancelButtonText: 'Cancel',
                    reverseButtons: true,
                }).then(function (result) {
                    if (result.value) {
                        let role = event.target.id;
                        $(`#delete-${role}`).submit();
                    }
                });
            });
        });
    </script>

@endpush
