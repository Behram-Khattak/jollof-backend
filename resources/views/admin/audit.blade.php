@extends('admin.layouts.master')

@section('title', config('app.name', 'Laravel'))

@section('content')

<!-- begin:: Content -->
    <div class="kt-container  kt-grid__item kt-grid__item--fluid">

        <!--[html-partial:begin:{"id":"demo5/dist/inc/view/demos/pages/index","page":"index"}]/-->

        <!--[html-partial:begin:{"id":"demo5/dist/inc/view/partials/content/dashboards/dashboard-1","page":"index"}]/-->

        <!--begin::Dashboard 1-->

        <!--begin::Row-->
        <div class="row">

            <div class="col-lg-12 col-xl-8 order-lg-3 order-xl-1">
                <!--begin::Portlet-->
                <div class="kt-portlet kt-portlet--height-fluid">
                    <div class="kt-portlet__head kt-portlet__head--lg kt-portlet__head--noborder kt-portlet__head--break-sm">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title">Recent Orders <small>32500 total</small></h3>
                        </div>
                        <div class="kt-portlet__head-toolbar">
                            <div class="kt-portlet__head-wrapper kt-form">
                                <div class="kt-form__group kt-form__group--inline kt-margin-r-10">
                                    <div class="kt-form__label">Sort By:</div>
                                    <div class="kt-form__control" style="width: 160px;">
                                        <div class="dropdown bootstrap-select form-control"><select class="form-control bootstrap-select" id="kt_form_status" title="Status" tabindex="-98"><option class="bs-title-option" value=""></option>
                                                <option value="1">Pending</option>
                                                <option value="2">Delivered</option>
                                                <option value="3">Canceled</option>
                                                <option value="4">Success</option>
                                                <option value="5">Info</option>
                                                <option value="6">Danger</option>
                                        </select><button type="button" class="btn dropdown-toggle btn-light bs-placeholder" data-toggle="dropdown" role="combobox" aria-owns="bs-select-1" aria-haspopup="listbox" aria-expanded="false" data-id="kt_form_status" title="Status"><div class="filter-option"><div class="filter-option-inner"><div class="filter-option-inner-inner">Status</div></div> </div></button><div class="dropdown-menu "><div class="inner show" role="listbox" id="bs-select-1" tabindex="-1"><ul class="dropdown-menu inner show" role="presentation"></ul></div></div></div>
                                    </div>
                                </div>
                                <a href="#" class="btn btn-brand btn-upper btn-bold">New Record</a>
                            </div>
                        </div>
                    </div>
                    <div class="kt-portlet__body kt-portlet__body--fit">
                        <table class="kt-datatable__table">

                            <thead class="kt-datatable__head">
                              <tr>
                                <th scope="col">Model</th>
                                <th scope="col">Action</th>
                                <th scope="col">User</th>
                                <th scope="col">Time</th>
                                <th scope="col">Old Values</th>
                                <th scope="col">New Values</th>
                              </tr>
                            </thead>
                            <tbody id="audits">
                              @foreach($audits as $audit)
                                <tr>
                                  <td>{{ $audit->auditable_type }} (id: {{ $audit->auditable_id }})</td>
                                  <td>{{ $audit->event }}</td>
                                  <td>{{ $audit->user->name }}</td>
                                  <td>{{ $audit->created_at }}</td>
                                  <td>
                                    <table class="table">
                                      @foreach($audit->old_values as $attribute => $value)
                                        <tr>
                                          <td><b>{{ $attribute }}</b></td>
                                          <td>{{ $value }}</td>
                                        </tr>
                                      @endforeach
                                    </table>
                                  </td>
                                  <td>
                                    <table class="table">
                                      @foreach($audit->new_values as $attribute => $value)
                                        <tr>
                                          <td><b>{{ $attribute }}</b></td>
                                          <td>{{ $value }}</td>
                                        </tr>
                                      @endforeach
                                    </table>
                                  </td>
                                </tr>
                              @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <!--end::Portlet-->
            </div>



        </div>

    </div>


@endsection
