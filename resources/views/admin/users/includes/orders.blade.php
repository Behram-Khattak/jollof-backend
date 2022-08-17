@extends('admin.layouts.master')

@section('title', 'Show | Jollof')

@section('content')

<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">

    <!-- begin:: Content -->
    <div class="kt-container kt-grid__item kt-grid__item--fluid">
        <div class="row">
            <div class="col-md-12">
                <!--begin::Portlet-->
                <div class="kt-portlet kt-portlet--tabs">
                    @include('admin.users.header')

                    <div class="kt-portlet__body">
                        <!--begin::Form-->
                        <div id="kt_datatable">
                            <table class="kt-datatable" id="roles-table" width="100%" role="grid">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Order Code</th>
                                        <th>Price</th>
                                        <th>Payment Status</th>
                                        <th>Amount Paid</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td><a href="{{ route('admin.order.details', ['code'=>$item->order_code]) }}">{{ $item->order_code }}</a></td>
                                        <td>NGN {{ $item->subtotal }}</td>
                                        <td>
                                            @if($item->status == 'paid')
                                            <span class="text-success">Paid</span>
                                            @else
                                            <span class="text-danger">Unpaid</span>
                                            @endif
                                        </td>   
                                        <td>
                                            @if($item->status == 'paid')
                                            ₦{{number_format($item->total,2)}}
                                            @else
                                            ----
                                            @endif</td>
                                        <td>{!! style_status($item->status) !!}<br><small>Ready in about {{ $item->duration }}mins</small></td>
                                        <td>{!! merchantOrderStatus($item->status, $item->id) !!}</td>
                                    </tr>
                                    @endforeach
                                </tbody>

                            </table>
                        </div>
                        <!--end::Form-->

                        @includeWhen($user->trashed(), 'admin.users._form-restore')

                        @includeWhen(!$user->trashed(), 'admin.users._form-delete')

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

<script>
    jQuery(document).ready(function() {
        $('.js-delete-trigger').on('click', function(event) {
            swal.fire({
                heightAuto: false,
                title: 'Are you sure?',
                text: "The user will be deleted!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Delete',
                cancelButtonText: 'Cancel',
                reverseButtons: true,
            }).then(function(result) {
                if (result.value) {
                    let user = event.currentTarget.id;
                    console.log(user);
                    $(`#delete-${user}`).submit();
                }
            });
        });
    });
</script>

@endpush
