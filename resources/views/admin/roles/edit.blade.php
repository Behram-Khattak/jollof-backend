@extends('admin.layouts.master')

@section('title', ucfirst($role->name) . " | Jollof")

@section('content')

    <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">

        <!-- begin:: Content -->
        <div class="kt-container kt-grid__item kt-grid__item--fluid">
            <div class="row">
                <div class="col-md-12">
                    <!--begin::Portlet-->
                    <div class="kt-portlet">
                        <div class="kt-portlet__head">
                            <div class="kt-portlet__head-label">
                                <h3 class="kt-portlet__head-title">Edit {{ ucfirst($role->name) }} Role</h3>
                            </div>
                        </div>
                        <div class="kt-portlet__body">
                            <!--begin::Form-->

                            <form method="POST" action="{{ route('admin.roles.update', $role) }}" class="kt-form">
                                @csrf

                                @method('PATCH')

                                @include('admin.roles._form-create-edit', ['buttonText' => 'Update Role', 'showDeleteButton' => true])

                            </form>
                            <!--end::Form-->

                            @includeWhen($role->trashed(), 'admin.roles._form-restore')

                            @includeWhen(!$role->trashed(), 'admin.roles._form-delete')

                        </div>

                    </div>

                    <!--end::Portlet-->
                </div>

            </div>
        </div>

        <!-- end:: Content -->
    </div>

@endsection

@push('scripts')

    <script>
        jQuery(document).ready(function () {
            $('.js-delete-trigger').click(function (event) {
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
