@extends('merchant.layouts.master')

@section('title', 'Business Review | Jollof')

@section('content')

    <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">

        <div class="kt-portlet">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title">All Products</h3>
                </div>
            </div>
            <div class="kt-portlet__body">

                <!--begin::Section-->
                <div class="kt-section">
                    <div class="kt-section__content">

                        <!-- <fashion-datatable-component
                            :products="{{ json_encode($products) }}"
                        /> -->
                        <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
                            <div class="kt-container  kt-grid__item kt-grid__item--fluid">
                                <div class="row">
                                    <div class="col-lg-12">

                                        <div class="kt-portlet kt-portlet--mobile">
                                            <div class="kt-portlet__head">
                                                <div class="kt-portlet__head-label">
                                                    <h3 class="kt-portlet__head-title">
                                                        Products
                                                    </h3>
                                                </div>
                                                <div class="kt-portlet__head-toolbar">
                                                    <a class="btn btn-primary" href="{{ route('merchant.fashion.create', request()->route('business')) }}"
                                                        role="button"><i class="la la-plus"></i> New Product</a>
                                                </div>
                                            </div>
                                            <div class="kt-portlet__body">
                                                <div id="kt_table_1_wrapper">
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <table class="table table-head-noborder">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Image</th>
                                                                        <th>Name</th>
                                                                        <th>Qty</th>
                                                                        <th>Price</th>
                                                                        <th>Discount Price</th>
                                                                        <th>Discount Status</th>
                                                                        <th>State</th>
                                                                        <th class="text-right">Action</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                @foreach ($products as $product)
                                                                <?php
                                                                    $sales_start = strtotime($product->sales_start);
                                                                    $sales_end = strtotime($product->sales_end);

                                                                    $diff = ($sales_end - $sales_start)/60/60/24;
                                                                ?>
                                                                <tr>
                                                                    <td>
                                                                        <img src="{{ $product->getFirstMediaUrl('featured-image') }}" class="img-fluid" width="100px" height="50px" alt="No Image available">
                                                                    </td>
                                                                    <td>
                                                                        <a href="/merchant/fashion/{{$product->owner->slug}}/products/{{$product->slug}}">{{ $product->name }}</a>
                                                                    </td>
                                                                    <td>{{ $product->quantity }}</td>
                                                                    <td>{{number_format($product->price)}}</td>
                                                                    <td>{{ number_format($product->sales_price)}}</td>
                                                                    <td>
                                                                        @if($product->sales_price > 0)
                                                                            @if($diff > 0)
                                                                                <div style="text-align:center; color:green; width: 50px; height: 20px; background-color:powderblue">
                                                                                    <span class="kt-badge kt-badge--inline">Active</span>
                                                                                </div>
                                                                            @else
                                                                                <div style="text-align:center; color:red; width: 90px; height: 20px; background-color:powderblue">
                                                                                    <span class="kt-badge kt-badge--inline">In-Active</span>
                                                                                </div>
                                                                            @endif 
                                                                        @else
                                                                        <div style="text-align:center; color:red; width: 70px; height: 20px; background-color:powderblue">
                                                                                <span class="kt-badge kt-badge--inline">In-Active</span>
                                                                            </div>
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                    @if($product->quantity > 0)
                                                                            <div style="text-align:center; color:green; width: 60px; height: 20px; background-color:powderblue">
                                                                                <span class="kt-badge kt-badge--inline">Available</span>
                                                                            </div>
                                                                        @else
                                                                        <div style="text-align:center; color:red; width: 70px; height: 20px; background-color:powderblue">
                                                                                <span class="kt-badge kt-badge--inline">Unavailable</span>
                                                                            </div>
                                                                        @endif 
                                                                    </td>
                                                                    <td class="text-right">
                                                                        <a href="#" class="btn btn-sm btn-outline-danger delete_product_btn" data-toggle="modal" data-target="#deleteproduct-{{$product->id}}" data-action="{{ route('merchant.fashion.delete', ['id'=> $product->id ]) }}"><i class="fa fa-trash-alt"></i></a>
                                                                    </td>
                                                                </tr>
                                                                <!-- Modal -->
                                                                <div class="modal fade" id="deleteproduct-{{$product->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                <div class="modal-dialog" role="document">
                                                                    <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="exampleModalLabel">Are you sure you want to delete this product?</h5>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <span style="color:red">This action is inreversable.</span>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <a href="{{route('merchant.fashion.delete',$product->id)}}" class="btn btn-outline-danger">Yes, Delete Product</a>
                                                                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">No</button>
                                                                    </div>
                                                                </div>
                                                                </div>
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

                    </div>

                </div>

            </div>
        </div>

    </div>
    

@endsection

@push('scripts')

@endpush
<script>
</script>
