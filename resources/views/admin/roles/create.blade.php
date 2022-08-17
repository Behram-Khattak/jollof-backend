@extends('admin.layouts.master')

@section('title', 'Create New Role | Jollof')

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
                                <h3 class="kt-portlet__head-title">Create New Role</h3>
                            </div>
                        </div>
                        <div class="kt-portlet__body">

                            <!--begin::Form-->
                            <form method="POST" action="{{ route('admin.roles.store') }}" class="kt-form">
                                @csrf

                                @include('admin.roles._form-create-edit', ['role' => new \App\Models\Role, 'buttonText' => 'Create Role', 'showDeleteButton' => false])

                            </form>
                            <!--end::Form-->
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

@endpush
