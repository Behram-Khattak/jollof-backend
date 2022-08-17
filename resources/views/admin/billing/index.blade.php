@extends('admin.layouts.master')

@section('title', config('app.name', 'Laravel'))

@section('content')

<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
    <div class="kt-container  kt-grid__item kt-grid__item--fluid">
        <div class="row">
            <div class="col-lg-12">

                <div class="kt-portlet kt-portlet--mobile">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title">
                                Billings
                            </h3>
                        </div>
                        <div class="kt-portlet__head-toolbar">

                        </div>
                    </div>
                    <div class="kt-portlet__body">

                        <div class="kt-form kt-fork--label-right kt-margin-t-20 kt-margin-b-10">

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

                        <div id="kt_datatable">
                            <table class="kt-datatable" id="roles-table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Business Name</th>
                                        <th>Phone</th>
                                        <th>Email</th>
                                        <th>Percentage</th>
                                        <th>Frequency</th>
                                        <th>Next Payout</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($businesses as $business)

                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $business->name }}</td>
                                        <td>{{ $business->telephone }}</td>
                                        <td>{{ $business->email }}</td>
                                        <td>
                                            {{ $business->payout ?  $business->payout->percentage : 'NA'}}
                                            @can('update-billing-percentage')
                                            <a href="#" class="pull-right btn-modal" data-percent="{{ $business->payout->percentage }}" data-business="{{ $business->id }}">edit</a>
                                            @endcan
                                        </td>
                                        <td>{{ $business->payout ?  $business->payout->frequency : 'NA' }}</td>
                                        <td>{{ $business->payout ?  $business->payout->next_payout : 'NA' }}</td>
                                        <td>
                                            <form action="{{ route('admin.billing.details', ['business'=>$business->slug]) }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="duration" value="{{ $dateStart.' - '.$dateEnd }}" />
                                                <input type="hidden" name="business" value="{{ $business->id }}" />
                                                <button type="submit" class="btn btn-primary btn-sm">Details</button>
                                            </form>
                                        </td>
                                    </tr>

                                    @endforeach
                                </tbody>

                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="editpercentage" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Billing Percentage</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <form action="{{ route('admin.billing.update') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                    <label for="">Percentage</label>
                    <input type="text" class="form-control" name="percentage">
                    <input type="hidden" class="form-control" name="business_id">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btn-save">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection

@push('scripts')

<script>
$("body").on("click", ".btn-modal", function(){

    $("input[name='percentage']").val($(this).data("percent"));
    $("input[name='business_id']").val($(this).data("business"));
    $("#editpercentage").modal("show");

});
</script>
@endpush
