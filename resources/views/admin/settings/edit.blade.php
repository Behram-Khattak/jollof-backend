@extends('admin.layouts.master')

@section('title', "Setting | $settings->name | Jollof")

@section('content')

    <div class="kt-content kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">

        <!-- begin:: Content -->
        <div class="kt-container kt-grid__item kt-grid__item--fluid">
            <div class="row">
                <div class="col-md-9 mx-auto">
                    <!--begin::Portlet-->
                    <div class="kt-portlet">
                        <div class="kt-portlet__head">
                            <div class="kt-portlet__head-label">
                                <h3 class="kt-portlet__head-title">Edit {{ $settings->name }} {{ $settingType->name }} Setting </h3>
                            </div>
                        </div>
                        <div class="kt-portlet__body">
                            <!--begin::Form-->

                            <b-form method="POST" action="{{ route('admin.settings.update', [$settingType, $settings]) }}" class="kt-form">
                                @csrf

                                @method('PATCH')

                                @include('admin.settings._form-create-edit', ['buttonText' => 'Update Setting', 'showCancelButton' => false])

                            </b-form>
                            <!--end::Form-->

{{--                            @includeWhen($role->trashed(), 'admin.roles._form-restore')--}}

{{--                            @includeWhen(!$role->trashed(), 'admin.roles._form-delete')--}}

                        </div>

                    </div>

                    <!--end::Portlet-->
                </div>

            </div>
        </div>

        <!-- end:: Content -->
    </div>


@endsection
