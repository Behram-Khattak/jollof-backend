@extends('admin.layouts.master')

@section('title', 'Admin: Create Shipping')

@section('content')


<div class="kt-subheader   kt-grid__item" id="kt_subheader">
    <div class="kt-container  kt-container--fluid ">
        <div class="kt-subheader__main">
            <h3 class="kt-subheader__title">Restaurant</h3>
            <span class="kt-subheader__separator kt-hidden"></span>
            <div class="kt-subheader__breadcrumbs">
                <a href="/admin/restaurants" class="kt-subheader__breadcrumbs-home"><i
                        class="flaticon2-shelter"></i></a>
                <span class="kt-subheader__breadcrumbs-separator"></span>
                <a class="kt-subheader__breadcrumbs-link">Shipping</a>
            </div>
        </div>
    </div>
</div>


<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
    <div class="kt-container  kt-grid__item kt-grid__item--fluid">

        <div class="row">
            <div class="col-lg-12">
                <div class="kt-portlet kt-portlet--mobile">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title">
                                Create Shipping Group
                            </h3>
                        </div>
                        <div class="kt-portlet__head-toolbar">
                            <a class="btn btn-primary create_category_btn" href="{{ route('admin.shipping') }}" role="button"><i
                                    class="la la-arrow-left"></i> Back to Shipping Group</a>
                        </div>
                    </div>
                    <div class="kt-portlet__body p-0">
                        <div id="kt_table_1_wrapper">
                            <div class="row">
                                <div class="col-sm-12">
                                    <form action="{{ route('admin.shipping.store') }}" method="POST" id="menu_form" class="p-4">
                                        @if ($errors->any())
                                            <div class="alert alert-danger">
                                                <ul>
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif

                                        @include('admin.shipping.form')

                                        @csrf


                                        <div class="form-group">

                                            <button type="submit" id="create" class="btn btn-primary btn-lg">Create Shipping Group</button>

                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



@endsection
