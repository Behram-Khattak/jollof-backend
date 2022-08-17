@extends('admin.layouts.master')

@section('title', config('app.name', 'Laravel'))

@section('content')

@if ($promos->isEmpty())

<p class="text-center">No promos added yet</p>
<div class="text-center"><a href="/admin/promo/create" class="btn btn-primary"><i class="la la-plus"></i> New promo</a></div>

@else
<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
    <div class="kt-container  kt-grid__item kt-grid__item--fluid">
        <div class="row">
            <div class="col-lg-12">

                <div class="kt-portlet kt-portlet--mobile">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title">
                                promos
                            </h3>
                        </div>
                        @can('create-promo')
                        <div class="kt-portlet__head-toolbar">
                            <a class="btn btn-primary" href="/admin/promo/create" role="button"><i class="la la-plus"></i> New promo</a>
                        </div>
                        @endcan
                    </div>
                    <div class="kt-portlet__body">
                        <div id="kt_table_1_wrapper" class="kt_dataTables_wrapper">
                            <div class="row">
                                <div class="col-sm-12">
                                    <table class="kt-datatable" id="roles-table" width="100%" role="grid">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Description</th>
                                                <th>Expiring Date</th>
                                                <th>Status</th>
                                                @canany(['update-promo', 'delete-promo'])
                                                <th>Actions</th>
                                                @endcanany
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach ($promos as $promo)
                                            <tr role="row" class="odd">
                                                <td>{{ $promo->name }}</td>
                                                <td>{{ $promo->description }}</td>
                                                <?php
                                                $date = date_create($promo->expire);
                                                $expiry_date = date_format($date, 'd-F-Y');
                                                ?>
                                                <td>{{$expiry_date}}</td>
                                                <td>
                                                    {!! $status = getPromoStatus($promo->start,$promo->expire) !!}
                                                </td>
                                                <td>
                                                    @can('update-promo')
                                                    <a class="btn btn-sm btn-outline-primary" href="/admin/promo/edit/{{ $promo->id }}"><i class="fa fa-pen"></i></a>
                                                    @endcan
                                                    @can('delete-promo')
                                                    <a class="btn btn-sm btn-outline-danger delete" href="#" data-toggle="modal" data-target=".delete-modal-sm" onclick="document.getElementById('delete-modal').action='/admin/promo/{{ $promo->id }}'"><i class="fa fa-trash"></i></a>
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
                <h5 class="modal-title h4" id="mySmallModalLabel">Delete promo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="" method="POST" class="delete-form" id="delete-modal">
                <div class="modal-body">

                    <p>Are you sure you want to delete the promo?</p>
                    @csrf
                    @method('DELETE')

                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger">Yes, Delete promo</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection
