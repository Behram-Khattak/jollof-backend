

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
                        @if($referrals->count() > 0)
                        <div class="kt_datatable">

                            <table class="kt-datatable" id="roles-table" role="grid">
                                <thead>
                                    <tr>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Email</th>
                                        <th>Code</th>
                                        <th>Referer</th>
                                        <th>referral Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($referrals as $referral)
                                    <tr>
                                        <td>{{ $referral->first_name }}</td>
                                        <td>{{ $referral->last_name }}</td>
                                        <td>{{ $referral->email }}</td>
                                        <td>{{ $referral->code }}</td>
                                        <td>{{ $referral->user->first_name }} {{ $referral->user->last_name }}</td>
                                        <td>{{ ($referral->signed_up_at) ? date('d-M-Y', strtotime($referral->signed_up_at)) : 'NULL' }}</td>
                                        <td>
                                            @if ($referral->signed_up_at)
                                            @if ($referral->gifted)
                                            <a href="#" class="btn btn-outline-primary disabled">Gifted</a>
                                            @else
                                            <a href="#" class="btn btn-outline-primary selectemail" data-toggle="modal" data-target="#redeemModal" data-email="{{ $referral->user->email }}" data-code="{{$referral->code}}" data-first_name="{{$referral->first_name}}" data-last_name="{{$referral->last_name}}">Redeem</a>
                                            @endif
                                            @else
                                            --
                                            @endif

                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td>
                                            No result for this filter
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            {{$referrals->links()}}

                        </div>
                        @else
                        <p class="p-5 text-center">No record found</p>
                        @endif
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
