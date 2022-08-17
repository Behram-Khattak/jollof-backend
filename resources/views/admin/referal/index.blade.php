@extends('admin.layouts.master')

@section('title', 'Jollof Admin: Report')

@section('content')

@include('partials._flash')

<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
    <div class="kt-container  kt-grid__item kt-grid__item--fluid">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="kt-portlet kt-portlet--mobile">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title">
                                Referrals
                            </h3>
                        </div>
                    </div>
                    @if($referals->count() > 0)
                    <!-- Search input -->
                    <div class="row justify-content-center mt-3 mb-3">
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
                    @if($referals->count() > 0)
                    <div class="kt_datatable">

                        <table class="kt-datatable" id="roles-table" role="grid">
                            <thead>
                                <tr>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Email</th>
                                    <th>Code</th>
                                    <th>Referer</th>
                                    <th>Referal Status</th>
                                    @can('redeem-referrals')
                                    <th>Action</th>
                                    @endcan
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($referals as $referal)
                                <tr>
                                    <td>{{ $referal->first_name }}</td>
                                    <td>{{ $referal->last_name }}</td>
                                    <td>{{ $referal->email }}</td>
                                    <td>{{ $referal->code }}</td>
                                    <td>{{ $referal->user->first_name }} {{ $referal->user->last_name }}</td>
                                    <td>{{ ($referal->signed_up_at) ? date('d-M-Y', strtotime($referal->signed_up_at)) : 'NULL' }}</td>
                                    @can('redeem-referrals')
                                    <td>
                                        @if ($referal->signed_up_at)
                                        @if ($referal->gifted)
                                        <a href="#" class="btn btn-outline-primary disabled">Gifted</a>
                                        @else
                                        <a href="#" class="btn btn-outline-primary" onclick="fillDetails(event)" id="selectemail" data-toggle="modal" data-target="#redeemModal" data-email="{{ $referal->user->email }}" data-code="{{$referal->code}}" data-first_name="{{$referal->first_name}}" data-last_name="{{$referal->last_name}}">Redeem</a>
                                        @endif
                                        @else
                                        --
                                        @endif

                                    </td>
                                    @endcan
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
                        {{$referals->links()}}

                    </div>
                    @else
                    <p class="p-5 text-center">No record found</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="modal fade" id="redeemModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Send Redemption Gift</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('admin.post.referal') }}" method="POST">
                        <div class="modal-body">
                            @csrf
                            <div class="form-group">
                                <label for="message">Email Address of Winner</label>
                                <input class="form-control" id="useremail" readonly type="email" name="email" value="">
                            </div>
                            <div class="form-group">
                                <label for="message">Name of Refered User</label>
                                <input class="form-control" id="username" readonly type="text" name="name" value="">
                            </div>
                            <input type="hidden" name="code" class="form-control" id="refcode" value="">

                            <div class=" form-group">
                                <label for="message">Message to Winner</label>
                                <textarea class="form-control" name="message" required></textarea>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Send Winning Message</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        @endsection
<script>
    function fillDetails(e) {
        e.preventDefault();
        var email = e.target.getAttribute('data-email');
        var code = e.target.getAttribute('data-code');
        var first_name = e.target.getAttribute('data-first_name');
        var last_name = e.target.getAttribute('data-last_name');
        document.getElementById('useremail').value = email;
        document.getElementById('username').value = first_name + ' ' + last_name;
        document.getElementById('refcode').value = code;
    }

</script>
