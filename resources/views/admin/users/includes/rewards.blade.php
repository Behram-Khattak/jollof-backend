@extends('admin.layouts.master')

@section('title', 'Show | Jollof')

@section('content')

<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">

    <!-- begin:: Content -->
    <div class="kt-container kt-grid__item kt-grid__item--fluid">
        <div class="row">
            <div class="col-md-12">
                <!--begin::Portlet-->
                <div class="kt-portlet kt-portlet--tabs">
                    @include('admin.users.header')

                    <div class="kt-portlet__body">
                        <!--begin::Form-->
                        <!-- card -->
                        <div class="card">
                            <h5 class="card-header">Jollof Points</h5>
                            <div class="card-body">
                                <h5 class="card-title">{{number_format($user->points,2)}}</h5>
                            </div>
                        </div>

                        <!--end::Form-->

                        @includeWhen($user->trashed(), 'admin.users._form-restore')

                        @includeWhen(!$user->trashed(), 'admin.users._form-delete')

                    </div>

                </div>

                <!--end::Portlet-->
            </div>

        </div>
    </div>

    <!-- end:: Content -->
</div>

@endsection
