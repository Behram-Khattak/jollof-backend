@extends('admin.layouts.master')

@section('title', ' Setting | ' . ucwords($settingType->name) . ' | Jollof')

@section('content')
    <!-- begin:: Content -->
    <div class="kt-container kt-grid__item kt-grid__item--fluid">
        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__head kt-portlet__head--lg">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title">
                        Settings
                    </h3>
                </div>
                <div class="kt-portlet__head-toolbar">
                    <div class="kt-portlet__head-wrapper">
                        <b-button variant="primary" v-b-modal.create-settings-modal
                                  class="btn-bold btn-upper btn-font-sm"
                        >
                            <i class="la la-plus"></i>
                            New {{ $settingType->name }} Setting
                        </b-button>
                    </div>
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
            <div class="kt-portlet__body kt-portlet__body--fit">

                <!--begin: Datatable -->
                <table class="kt-datatable" id="settings-table" width="100%">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Value</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($settings as $setting)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ ucfirst($setting->name) }}</td>
                            <td>{{ $setting->value }}</td>
                            <td>
                                <b-link
                                    id="{{ $loop->iteration }}"
                                    href="{{ route('admin.settings.edit', [$settingType, $setting]) }}"
                                    class="btn btn-sm btn-icon btn-icon-md btn-outline-hover-info btn-edit"
                                    title="Edit"
                                >
                                    <i class="fa fa-pen"></i>
                                </b-link>
{{--                                @if ($role->trashed())--}}
{{--                                    <button--}}
{{--                                        class="btn btn-sm btn-icon btn-icon-md btn-outline-hover-success"--}}
{{--                                        title="Restore"--}}
{{--                                        id="role-{{ $role->id }}"--}}
{{--                                        onclick="document.getElementById('restore-role-{{ $role->id }}').submit();"--}}
{{--                                    >--}}
{{--                                        <i class="fa fa-sync" id="role-{{ $role->id }}"></i>--}}
{{--                                    </button>--}}
{{--                                    @include('admin.roles._form-restore')--}}
{{--                                @else--}}
{{--                                    duplicate id on button and inner icon is intentional--}}
{{--                                    <button--}}
{{--                                        class="btn btn-sm btn-icon btn-icon-md btn-outline-hover-danger js-delete-trigger"--}}
{{--                                        title="Delete"--}}
{{--                                        id="role-{{ $role->id }}"--}}
{{--                                    >--}}
{{--                                        <i class="fa fa-trash" id="role-{{ $role->id }}"></i>--}}
{{--                                    </button>--}}
{{--                                    @include('admin.roles._form-delete')--}}
{{--                                @endif--}}

                            </td>
                        </tr>
                    @endforeach

                    </tbody>

                </table>


            {{--                <settings-datatable-component--}}
            {{--                    :initial-items="{{ $settings }}"--}}
            {{--                    :fields="['id', 'name', 'value']"--}}
            {{--                />--}}

            <!--end: Datatable -->
            </div>
        </div>

    </div>

    <!-- end:: Content -->
@endsection

@push('modals')

    @include('admin.settings._create-settings-modal')

@endpush

@push('scripts')

    <script>
        //
        // jQuery(document).ready(function () {
        //     $('#html_table').on('click', '.js-delete-trigger', function (event) {
        //         swal.fire({
        //             heightAuto: false,
        //             title: 'Are you sure?',
        //             text: "All permissions on the role will be removed!",
        //             type: 'warning',
        //             showCancelButton: true,
        //             confirmButtonText: 'Delete',
        //             cancelButtonText: 'Cancel',
        //             reverseButtons: true,
        //         }).then(function (result) {
        //             if (result.value) {
        //                 let role = event.target.id;
        //                 $(`#delete-${role}`).submit();
        //             }
        //         });
        //     });
        // });
    </script>

@endpush
