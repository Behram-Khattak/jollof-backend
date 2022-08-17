@extends('admin.layouts.master')

@section('title', 'Business Review | Jollof')

@section('content')

    <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">

        <div class="kt-portlet">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title">All businesses</h3>
                </div>
            </div>
            <div class="kt-portlet__body">

                <!--begin::Section-->
                <div class="kt-section">
                    <div class="kt-section__content">

                        <business-datatable-component
                            :businesses="{{ json_encode($businesses) }}"
                            :types="{{ json_encode($types) }}"
                        />

                    </div>

                </div>

            </div>
        </div>

    </div>

@endsection

@push('scripts')

@endpush
