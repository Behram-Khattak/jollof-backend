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
                        <h6 class="text-uppercase">My reviews</h6>
                    </div>

                    <div class="table-responsive m-3">
                        @if($reviews->isEmpty())
                            <p>You have not reviewed any order. </p>
                        @else
                        <table class="table table-bordered table-hover table-sm">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>Order Code</th>
                                    <th>Comment</th>
                                    <th>Star</th>
                                    <th>Reviewed on</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($reviews as $review)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $review->order->order_code ?? 'NULL' }}</td>
                                    <td>{{ $review->review }}</td>
                                    <td>
                                        @for ($i = 1; $i <= 5; $i++)
                                            <i

                                                @if($i > $review->rating)

                                                class="fa fa-star text-black-50"

                                                @else

                                                class="fa fa-star"

                                                @endif
                                            ></i>
                                        @endfor
                                    </td>
                                    <td><small class="text-muted">{{ $review->created_at->toDayDateTimeString() }}</small></td>
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
