@extends('admin.layouts.master')

@section('title', config('app.name', 'Laravel'))

@section('content')

<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
    <div class="kt-container  kt-grid__item kt-grid__item--fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="kt-portlet kt-portlet--height-fluid py-5 text-center">



                        <h1 class="text-success">Payout Completed</h1>
                        <p>
                            <form action="{{ route('admin.billing.details', ['business'=>$business->slug]) }}" method="POST">
                                @csrf
                                <input type="hidden" name="duration" value="{{ $dateStart.' - '.$dateEnd }}" />
                                <input type="hidden" name="business" value="{{ $business->id }}" />
                                <button type="submit" class="btn btn-outline-warning">Billing Details</button>
                                <a href="{{ route('admin.billing.history', ['business'=>$business]) }}" class="btn btn-outline-primary">Payout History</a>
                            </form>

                        </p>




                </div>
            </div>
        </div>


    </div>
</div>

@endsection

