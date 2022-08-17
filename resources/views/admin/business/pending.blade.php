@extends('admin.layouts.master')

@section('title', 'Business Review | Jollof')

@section('content')

    <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">

        <div class="kt-portlet">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title">Business Approval Review</h3>
                </div>
            </div>
            <div class="kt-portlet__body">

                <!--begin::Section-->
                <div class="kt-section">
                    <div class="kt-section__content">

                        <business-review-component :businesses="{{ json_encode($businesses) }}">
                            @csrf
                        </business-review-component>

                    </div>

                </div>

            </div>
        </div>

    </div>

@endsection

@push('scripts')

    <script>
        jQuery(document).ready(function () {
            $('.js-delete-trigger').on('click', function (event) {
                swal.fire({
                    heightAuto: false,
                    title: 'Are you sure?',
                    text: "The user will be deleted!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Delete',
                    cancelButtonText: 'Cancel',
                    reverseButtons: true,
                }).then(function (result) {
                    if (result.value) {
                        let user = event.currentTarget.id;
                        console.log(user);
                        $(`#delete-${user}`).submit();
                    }
                });
            });
        });
    </script>

@endpush
