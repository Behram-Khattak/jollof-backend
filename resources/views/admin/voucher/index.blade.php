@extends('admin.layouts.master')

@section('title', config('app.name', 'Laravel'))

@section('content')

@if ($vouchers->isEmpty())

    <p class="text-center">No voucher added yet</p>
    @can('create-voucher')
    <div class="text-center"><a href="/admin/voucher/create" class="btn btn-primary"><i class="la la-plus"></i> New Voucher</a></div>
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
                                Vouchers
                            </h3>
                        </div>
                        <div class="kt-portlet__head-toolbar">
                            <a class="btn btn-primary" href="/admin/voucher/create" role="button"><i class="la la-plus"></i> New Voucher</a>
                        </div>
                    </div>
                    <div class="kt-portlet__body">
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
                                <tr>
                                  <th>Title</th>
                                  <th>Description</th>
                                  <th>Redemption Details</th>
                                  <th>Locations</th>
                                  <th>Duration</th>
                                  <th>Status</th>
                                    @canany(['update-voucher', 'delete-voucher'])
                                  <th>Actions</th>
                                    @endcanany
                                </tr>
                              </thead>

                              <tbody>
                                  @foreach ($vouchers as $voucher)
                                  <tr role="row" class="odd">
                                    <td>{{ $voucher->title }}</td>
                                    <td>{{ $voucher->description }}</td>
                                    <td>{{ $voucher->redemption_details }}</td>
                                    <td>{{ $voucher->location }}</td>
                                    <td>starts {{ $voucher->start_date }} for {{ $voucher->duration }} day(s)</td>
                                    <td>
                                        @if ($voucher->status == "active")
                                            <span class="text-success">
                                                <strong>{{ strtoupper($voucher->status) }}</strong>
                                            </span>
                                        @else
                                            <span class="text-danger">
                                                <strong>{{ strtoupper($voucher->status) }}</strong>
                                            </span>
                                        @endif

                                    </td>
                                    <td>
                                      <span class="dropdown">
                                        <a
                                          href="#"
                                          class="btn btn-sm btn-clean btn-icon btn-icon-md"
                                          data-toggle="dropdown"
                                          aria-expanded="true"
                                        >
                                          <i class="fa fa-ellipsis-h"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            @can('update-voucher')
                                          <a class="dropdown-item" href="/admin/voucher/edit/{{ $voucher->id }}"><i class="fa fa-pen"></i> Edit</a>
                                            @endcan
                                            @can('delete-voucher')
                                          <a class="dropdown-item delete" href="#" data-toggle="modal" data-target=".delete-modal-sm" onclick="document.getElementById('delete-modal').action='/admin/voucher/{{ $voucher->id }}'"><i class="fa fa-trash"></i> Delete</a>
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
                <h5 class="modal-title h4" id="mySmallModalLabel">Delete Voucher</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="" method="POST" class="delete-form" id="delete-modal">
                <div class="modal-body">

                    <p>Are you sure you want to delete the voucher?</p>
                    @csrf
                    @method('DELETE')

                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger">Yes, Delete Voucher</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection
