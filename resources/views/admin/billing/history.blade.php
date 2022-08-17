@extends('admin.layouts.master')

@section('title', config('app.name', 'Laravel'))

@section('content')

<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
    <div class="kt-container  kt-grid__item kt-grid__item--fluid">
        <div class="row">
            <div class="col-12 text-right">
                <form action="{{ route('admin.billing.details', ['business'=>$business->slug]) }}" method="POST">
                    @csrf
                    <input type="hidden" name="duration" value="{{ $dateStart.' - '.$dateEnd }}" />
                    <input type="hidden" name="business" value="{{ $business->id }}" />
                    <button type="submit" class="btn btn-primary">Billing Details</button>

                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="kt-portlet kt-portlet--height-fluid">
                    <div class="kt-portlet__head kt-portlet__head--noborder">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title">Billing Details</h3>
                        </div>
                    </div>
                    <div class="kt-portlet__body kt-portlet__body--fluid">


                            <table class="table row">
                                <tr>
                                    <td><strong>Frequency</strong></td>
                                    <td>{{ $history->frequency }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Percentage</strong></td>
                                    <td>{{ $history->percentage }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Next Payout Date</strong></td>
                                    <td>{{ $history->next_payout }}</td>
                                </tr>
                            </table>


                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="kt-portlet kt-portlet--mobile">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title">
                                Payout History
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
                                        <th>Amount</th>
                                        <th>Payout Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($history->requests as $h)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $h->amount }}</td>
                                            <td>{{ $h->payout_date }}</td>
                                            <td></td>
                                        </tr>
                                    @empty

                                    @endforelse

                                </tbody>

                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

