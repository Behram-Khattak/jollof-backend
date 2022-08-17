@extends('admin.layouts.master')

@section('title', 'Sliders')

@section('content')

<div class="kt-subheader   kt-grid__item" id="kt_subheader">
    <div class="kt-container  kt-container--fluid ">
        <div class="kt-subheader__main">
            <h3 class="kt-subheader__title">PopUp</h3>
        </div>
    </div>
</div>

@if ($banners->isEmpty())

    <p class="text-center">No pop up added yet</p>
    @can('create-banners')
    <div class="text-center"><a href="{{ url('admin/popup/create/'.request()->segment(4)) }}" class="btn btn-primary"><i class="la la-plus"></i> New PopUp</a></div>
    @endcan
@else
<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
    <div class="kt-container  kt-grid__item kt-grid__item--fluid">
        <div class="row">
            <div class="col-lg-12">

                <div class="kt-portlet kt-portlet--mobile">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title">
                                Slider
                            </h3>
                        </div>
                        <div class="kt-portlet__head-toolbar">
                            <a class="btn btn-primary" href="{{ url('admin/popup/create/'.request()->segment(4)) }}" role="button"><i class="la la-plus"></i> New PopUp</a>
                        </div>
                    </div>
                    <div class="kt-portlet__body">
                        <div class="bg-info text-white rounded p-3 mb-5">
                            <h4>INFORMATION</h4>
                            <p>Only one popup can display at a time. Any popup you want to display would be the active popup. You can add multiple images to the slide. Only one active popup show at a time with multiple images on the popup.</p>
                        </div>
                        <div
                        id="kt_table_1_wrapper"
                        class="dataTables_wrapper dt-bootstrap4 no-footer"
                      >
                        <div class="row">
                          <div class="col-sm-12">
                            <table
                              class="kt-datatable" id="roles-table" width="100%"
                              role="grid"
                              aria-describedby="kt_table_1_info"
                            >
                              <thead>
                                <tr role="row">
                                  <th
                                    class="sorting_desc"
                                    tabindex="0"
                                    aria-controls="kt_table_1"
                                  >
                                    Title
                                  </th>
                                  <th
                                    class="sorting"
                                    tabindex="0"
                                    aria-controls="kt_table_1"
                                  >
                                    Banner
                                  </th>
                                  <th
                                    class="sorting"
                                    tabindex="0"
                                    aria-controls="kt_table_1"
                                  >
                                    Image Count
                                  </th>
                                  <th
                                    class="sorting"
                                    tabindex="0"
                                    aria-controls="kt_table_1"
                                  >
                                    Can View
                                  </th>
                                  <th
                                    class="sorting"
                                    tabindex="0"
                                    aria-controls="kt_table_1"
                                  >
                                    Status
                                  </th>

                                  <th class="sorting_disabled">
                                    Actions
                                  </th>
                                </tr>
                              </thead>

                              <tbody>
                                  @foreach ($banners as $banner)
                                  <tr role="row" class="odd">
                                    <td><a href="{{ url('admin/popup/'.$banner->id) }}"> {{ $banner->title }}</a></td>
                                    <td><img src="{{ $banner->getFirstMediaUrl() }}" class="img-fluid" /></td>
                                    <td>{{ $banner->can_view }}</td>
                                    <td>{{ count($banner->getMedia()) }}</td>
                                    <td>
                                        @if ($banner->status == "active")
                                            <span class="text-success">
                                                <strong>{{ $banner->status }}</strong>
                                            </span>
                                        @else
                                            <span class="text-danger">
                                                <strong>{{ $banner->status }}</strong>
                                            </span>
                                        @endif

                                    </td>
                                    <td nowrap="">
                                      <span class="dropdown">
                                        <a
                                          href="#"
                                          class="btn btn-sm btn-clean btn-icon btn-icon-md"
                                          data-toggle="dropdown"
                                          aria-expanded="true"
                                        >
                                          <i class="la la-ellipsis-h"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            @can('update-banners')
                                          <a class="dropdown-item" href="{{ url('admin/popup/edit/'.$banner->id) }}"><i class="fa fa-pen"></i> Edit</a>
                                            @endcan
                                            @can('delete-banners')
                                          <a class="dropdown-item delete" href="#" data-toggle="modal" data-target=".delete-modal-sm" onclick="document.getElementById('delete-form').action = '/admin/advert/{{ $banner->id }}';"><i class="fa fa-trash"></i> Delete</a>
                                            @endcan
                                        </div>
                                      </span>

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
                <h5 class="modal-title h4" id="mySmallModalLabel">Delete Banner</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="" method="POST" class="delete-form" id="delete-form">
                <div class="modal-body">

                    <p>Are you sure you want to delete the banner?</p>
                    @csrf
                    @method('DELETE')

                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger">Yes, Delete Banner</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection
