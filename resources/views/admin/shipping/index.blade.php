@extends('admin.layouts.master')

@section('title', 'Admin: Shipping')

@section('content')


<div class="kt-subheader   kt-grid__item" id="kt_subheader">
    <div class="kt-container  kt-container--fluid ">
        <div class="kt-subheader__main">
            <h3 class="kt-subheader__title">Restaurant</h3>
            <span class="kt-subheader__separator kt-hidden"></span>
            <div class="kt-subheader__breadcrumbs">
                <a href="/admin/shipping" class="kt-subheader__breadcrumbs-home"><i
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
                                VAT (Value Added Tax)
                            </h3>
                        </div>
                        <div class="kt-portlet__head-toolbar">

                        </div>
                    </div>
                    <div class="kt-portlet__body p-0">
                        <div id="kt_table_1_wrapper">
                            <div class="row">
                                <div class="col-sm-12">

                                    <table class="table">
                                        <tr>
                                            <td>Value of VAT(%)</td>
                                            <td>{{ ($vat) ? $vat->settings[0]->value : '7.5' }}%</td>
                                            @can('update-vat')
                                            <td><a href="#" data-toggle="modal" data-target="#vat">edit</a></td>
                                            @endcan
                                        </tr>
                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
                                Shipping Groups
                            </h3>
                        </div>
                        <div class="kt-portlet__head-toolbar">
                            {{--  <a class="btn btn-primary create_category_btn" href="{{ route('admin.shipping.create') }}" role="button"><i
                                    class="la la-plus"></i> New Shipping Group</a>  --}}
                        </div>
                    </div>
                    <div class="kt-portlet__body p-0">
                        <div id="kt_table_1_wrapper">
                            <div class="row">
                                <div class="col-sm-12">
                                    @if($states->isEmpty())
                                        <p class="text-center p-5 my-5">No Shipping Group created</p>
                                    @else

                                        <table class="table table-head-noborder">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Areas Count</th>
                                                    {{--  <th class="text-right">Action</th>  --}}
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($states as $state)
                                                    <tr>
                                                        <td><a href="{{ route('admin.shipping.state', ['id'=>$state->id]) }}">{{ $state->state }}</a></td>
                                                        <td>{{ $state->areas->count() }}</td>
                                                        {{--  <td class="text-right">
                                                            <a href="#" class="px-2 update_category_btn"
                                                                data-original-title="Edit"><i
                                                                    class="fa fa-pen"></i></a>
                                                        </td>  --}}
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @endif
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>


{{-- Manage VAT --}}
<div class="modal fade" id="vat" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Manage VAT</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <form method="POST" action="{{ route('admin.vat.update') }}">
                @csrf
            <div class="modal-body">

                <label>VAT Value</label>
                <input class="form-control" name="vat" value="{{ ($vat) ? $vat->settings[0]->value : '7.5' }}" />
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Update VAT Value</button>
            </div>
            </form>
        </div>
    </div>
</div>

{{-- Manage VAT Ends --}}


@endsection
