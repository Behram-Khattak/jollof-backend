@extends('admin.layouts.master')

@section('title', config('app.name', 'Jollof'))

@section('content')


<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
    <div class="kt-container  kt-grid__item kt-grid__item--fluid">
        <div class="row">
            <div class="col-lg-12">

                <div class="kt-portlet kt-portlet--mobile">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title">
                                Sliders
                            </h3>
                        </div>
                        <div class="kt-portlet__head-toolbar">
                            <a class="btn btn-dark mr-3"href="#" data-toggle="modal" data-target=".update-banner-modal"><i class="fa fa-image" aria-hidden="true"></i> Add Banner Image</a>
                            <a class="btn btn-primary mr-3" href="/admin/popup/edit/{{ $banner->id }}" role="button"><i class="la la-edit"></i> Edit PopUp</a>
                            <a class="btn btn-danger" href="#" data-toggle="modal" data-target=".delete-modal-sm" onclick="document.getElementById('delete-form').action = '/admin/popup/{{ $banner->id }}'"><i class="la la-trash"></i> Delete PopUp</a>
                        </div>
                    </div>
                    <div class="kt-portlet__body p-0">

                        <table class="kt-datatable" id="roles-table" width="100%">
                            <thead>
                                <tr>
                                    <th>Label</th>
                                    <th>Value</th>
                                    <th>Link</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><strong>Title</strong></td>
                                    <td>{{ $banner->title }}</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td><strong>Slot</strong></td>
                                    <td>{{ $banner->slot }}</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td><strong>Start date</strong></td>
                                    <td>{{ $banner->start_date }}</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td><strong>Expire date</strong></td>
                                    <td>{{ $banner->expiry_date }}</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td><strong>Status</strong></td>
                                    <td>{{ $banner->status }}</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                @foreach ($banner->getMedia() as $slide)
                                <tr>
                                    <td><strong>Slide</strong></td>
                                    <td><img src="{{ $slide->getUrl() }}" class="img-fluid"></td>
                                    <td>{{ $slide->getCustomProperty('link') }}</td>
                                    <td>
                                        <a href="#" data-toggle="modal" data-target=".delete-modal-sm" onclick="document.getElementById('delete-form').action = '/admin/popup/pop/{{ $banner->id }}/{{ $loop->index }}'" class="btn btn-sm btn-icon btn-icon-md btn-outline-hover-danger"><i class="fa fa-trash" aria-hidden="true"></i></a>
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



<div class="modal fade delete-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title h4" id="mySmallModalLabel">Delete Slide</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="" method="POST" class="delete-form" id="delete-form">
                <div class="modal-body">

                    <p>Are you sure you want to delete the slide?</p>
                    @csrf
                    @method('DELETE')

                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger">Yes, Delete Slide</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                </div>
            </form>
        </div>
    </div>
</div>


@include('admin.partials._addBanner')


@endsection
