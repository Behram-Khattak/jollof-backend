{{-- @extends('layouts.master') --}}

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

{{-- @section('content') --}}
<main>
    <article>
        <div class="my-orders-wrapper">
            @include('partials._flash')
            <div class="container">

                <!-- <br /><br /> -->

                <!-- <div class="">
                    <h4>My Account</h4>
                    @include('user.partials._myAccount')
                </div> -->

                <div class="row">
                    <!-- <br /> -->
                    <div class="col-12 text-center">
                        <h6 class="text-uppercase">My vendors</h6>
                    </div>

                    <div class="table-responsive m-3">
                        @if($orders->isEmpty())
                            <p>You have not bought from any vendor. </p>
                        @else
                        <table class="table table-bordered table-hover table-sm">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>Vendor Name</th>
                                    <th>Product</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $order)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $order->business->name ?? 'NULL' }}</td>
                                    <td>{{ $order->name }}</td>
                                    <td><small class="text-muted">{{ $order->created_at->toDayDateTimeString() }}</small></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @endif
                    </div>
                </div>
                <!-- Order End -->
    </article>
</main>
<script>
    
</script>


{{-- @endsection --}}
