@extends('layouts.dispatch')

<blade
    section|(%26%2339%3Btitle%26%2339%3B%2C%20config(%26%2339%3Bapp.name%26%2339%3B%2C%20%26%2339%3BLaravel%26%2339%3B)) />

@push('styles')
    <style>
        <blade media|%20screen%20and%20(max-width%3A%20768px)%20%7B>.logo-wrapper .navbar-collapse {
            margin: 0px 15px;
        }
        }

    </style>
@endpush

@section('content')


<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
    <div class="kt-container  kt-grid__item kt-grid__item--fluid">
        @include('partials._order_delivery_details')
    </div>
</div>


@endsection

