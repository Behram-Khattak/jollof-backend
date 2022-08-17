@extends('admin.layouts.master')

@section("title", "Notifications")

@section('content')

<div class="kt-subheader   kt-grid__item" id="kt_subheader">
    <div class="kt-container  kt-container--fluid ">
        <div class="kt-subheader__main">

            <h3 class="kt-subheader__title">Notifications</h3>
            <span class="kt-subheader__separator kt-hidden"></span>
        </div>

    </div>
</div>

@if($notifications->isEmpty())

<div class="p-5 my-5">
    <p class="text-center">No notifications added yet</p>
    @can('create-notification')
    <div class="text-center"><a href="/admin/notification/create" class="btn btn-primary"><i class="la la-plus"></i>
            New Notification</a></div>
    @endcan
</div>
@else
<div class="d-flex flex-column-fluid">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">

                <div class="card card-custom gutter-b">
                    <div class="card-header">
                        <div class="card-title">
                            @can('create-notification')
                            <a class="btn btn-primary float-right" href="/admin/notification/create" role="button"><i class="la la-plus"></i> New Notification</a>
                            @endcan
                            <h3 class="card-label">
                                Notifications
                            </h3>

                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table" id="roles-table" width="100%" role="grid">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Message</th>
                                    <th>Location</th>
                                    <th>Duration</th>
                                    <th>Status</th>
                                    @canany(['update-notification', 'delete-notification'])
                                    <th>Actions</th>
                                    @endcanany
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($notifications as $notification)
                                <tr role="row" class="odd">
                                    <td>
                                        {{ $notification->title }}<br>
                                        <strong class="text-muted">{{ $notification->type }}</strong>
                                    </td>
                                    <td>{{ $notification->message }}</td>
                                    <td>{{ $notification->locations }}</td>
                                    <td><strong>Starts:</strong><br>
                                        {{ Carbon\Carbon::parse($notification->start_date)->diffForHumans() }}
                                        <br> <strong>Expire:</strong><br>
                                        {{ Carbon\Carbon::parse($notification->expire_date)->diffForHumans() }}
                                    </td>
                                    <td>
                                        @if($notification->status == "active")
                                        <span class="badge badge-pill badge-success">
                                            <strong>{{ strtoupper($notification->status) }}</strong>
                                        </span>
                                        @else
                                        <span class="badge badge-pill badge-danger">
                                            <strong>{{ strtoupper($notification->status) }}</strong>
                                        </span>
                                        @endif

                                    </td>
                                    <td>
                                        @can('update-notification')
                                        <a class="btn btn-outline" href="/admin/notification/edit/{{ $notification->id }}"><i class="fa fa-pen"></i> Edit</a>
                                        @endcan
                                        @can('delete-notification')
                                        <a class="btn btn-outline delete" href="#" data-toggle="modal" data-target=".delete-modal-sm" data-id="{{ $notification->id }}" onclick="document.getElementById('delete-modal').action='/admin/notification/{{ $notification->id }}';"><i class="fa fa-trash"></i> Delete</a>
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
@endif


<div class="modal fade delete-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title h4" id="mySmallModalLabel">Delete Notification</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="" method="POST" class="delete-form" id="delete-modal">
                <div class="modal-body">

                    <p>Are you sure you want to delete the notification?</p>

                    @csrf
                    @method('DELETE')

                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger">Yes, Delete Notifcation</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection
