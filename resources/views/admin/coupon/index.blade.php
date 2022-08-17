@extends('admin.layouts.master')

@section('title', config('app.name', 'Laravel'))

@section('content')

@if ($coupons->isEmpty())

<p class="text-center">No coupons added yet</p>
<div class="text-center"><a href="/admin/coupon/create" class="btn btn-primary"><i class="la la-plus"></i> New Coupon</a></div>

@else
<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
    <div class="kt-container  kt-grid__item kt-grid__item--fluid">
        <div class="row">
            <div class="col-lg-12">

                <div class="kt-portlet kt-portlet--mobile">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title">
                                Coupons
                            </h3>
                        </div>
                        @can('create-coupon')
                        <div class="kt-portlet__head-toolbar">
                            <a class="btn btn-primary" href="/admin/coupon/create" role="button"><i class="la la-plus"></i> New Coupon</a>
                        </div>
                        @endcan
                    </div>

                    @if($coupons->count() > 0)
                    <div class="row justify-content-center mt-2 mb-2">
                        <div class="col-md-5">
                            <div class="kt-input-icon kt-input-icon--left">
                                <input type="text" class="form-control" placeholder="Search..." id="generalSearch">
                                <span class="kt-input-icon__icon kt-input-icon__icon--left">
                                    <span><i class="la la-search"></i></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    @endif
                    <div class="kt-portlet__body">
                        <div id="kt_table_1_wrapper" class="kt_dataTables_wrapper">
                            <div class="row">
                                <div class="col-sm-12">
                                    <table class="kt-datatable" id="roles-table" width="100%" role="grid">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Receiver's Name</th>
                                                <th>Receiver's Email</th>
                                                <th>Code - Type</th>
                                                {{--<th>Code</th> --}}
                                                <th>Percentage</th>
                                                <th>Total Usable</th>
                                                <th>Total Used</th>
                                                <th>Total Remains</th>
                                                <!-- <th>Location</th> -->
                                                <!-- <th>Start & Duration</th> -->
                                                <th>Minimum Price</th>
                                                <th>Maximum Price</th>
                                                <th>Expiring Date</th>
                                                <th>Status</th>
                                                @canany(['update-coupon', 'delete-coupon'])
                                                <th>Actions</th>
                                                @endcanany
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach ($coupons as $coupon)
                                            <tr role="row" class="odd">
                                                <td>
                                                    {{ $coupon->name }}<br>
                                                    <small class="text-muted text-truncate">{{ $coupon->description }}</small>
                                                </td>
                                                <td>{{ $coupon->receivers_name }}</td>
                                                <td>{{ $coupon->receivers_email }}</td>
                                                <td>
                                                    <strong>{{ $coupon->code }}</strong>
                                                    <hr>
                                                    {{ $coupon->type }}<br>
                                                </td>
                                                <td>{{$coupon->percentage}}%</td>
                                                <td>{{$coupon->number_of_usage}}</td>
                                                <td>{{$coupon->number_of_uses}}</td>
                                                <td>{{$coupon->remains}}</td>
                                                <td>{{$coupon->min_price}}</td>
                                                <td>{{$coupon->max_price}}</td>
                                                <!-- <td>{{ $coupon->site }}</td> -->
                                                <!-- <td>starts {{ $coupon->start_date }} for {{ $coupon->duration }} day(s)</td> -->
                                                <?php
                                                $date = date_create($coupon->expire);
                                                $expiry_date = date_format($date, 'd-F-Y');
                                                ?>
                                                <td>{{$expiry_date}}</td>
                                                <td>
                                                    <!-- If coupon is deleted -->
                                                    @if($coupon->deleted_at != null)
                                                    <span class='font-weight-bold text-danger'>DELETED</span>
                                                    @else
                                                    {!! $status = getCouponStatus($coupon->start,$coupon->expire, $coupon->used) !!}
                                                    @endif

                                                </td>
                                                <td>
                                                    {{-- @can('update-coupon')
                                                    <a class="btn btn-sm btn-outline-primary" href="/admin/coupon/edit/{{ $coupon->id }}"><i class="fa fa-pen"></i></a>
                                                    @endcan --}}
                                                    @can('delete-coupon')
                                                    @if ($coupon->deleted_at == null)
                                                    <a class="btn btn-sm btn-outline-danger delete" href="#" data-toggle="modal" data-target=".delete-modal-sm" onclick="document.getElementById('delete-modal').action='/admin/coupon/{{ $coupon->id }}'"><i class="fa fa-trash"></i></a>
                                                    @else
                                                    <!-- <a class="btn btn-sm btn-outline-success delete" href="#" data-toggle="modal" data-target=".recover-modal-sm" onclick="document.getElementById('recover-modal').action='/admin/coupon/{{ $coupon->id }}'"><i class="fa fa-undo"></i></a> -->
                                                    @endif
                                                    @endcan
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
    </div>
</div>

@endif


<div class="modal fade delete-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title h4" id="mySmallModalLabel">Delete Coupon</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="" method="POST" class="delete-form" id="delete-modal">
                <div class="modal-body">

                    <p>Are you sure you want to delete the coupon?</p>
                    @csrf
                    @method('DELETE')

                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger">Yes, Delete Coupon</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection
