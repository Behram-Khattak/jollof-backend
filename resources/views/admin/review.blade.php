@extends('admin.layouts.master')

@section('title', 'Admin: reviews')

@section('content')

<!-- Create reaponsive table for reviews -->
<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
    <div class="kt-container  kt-grid__item kt-grid__item--fluid">
        <div class="row justify-content-center">
            <div class="col-lg-12">

                <div class="kt-portlet kt-portlet--mobile">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title">
                                Reviews ({{ $reviews->total() }})
                            </h3>
                        </div>
                    </div>
                    <div class="kt-portlet__body">
                        @if($reviews->isEmpty())
                        <p>There are no reviews currently</p>
                        @else

                        <!-- <div class="kt-form kt-fork--label-right kt-margin-t-20 kt-margin-b-10">
                            <div class="row align-items-center">
                                <div class="col-xl-12 order-2 order-xl-1">
                                    <div class="row align-items-center">
                                        <div class="col-md-4 kt-margin-b-20-tablet-and-mobile">
                                            <div class="kt-input-icon kt-input-icon--left">
                                                <input type="text" class="form-control" placeholder="Search..."
                                                       id="generalSearch">
                                                <span class="kt-input-icon__icon kt-input-icon__icon--left">
                                                    <span><i class="la la-search"></i></span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                        <table class="table">
                            <thead>
                                <tr>
                                <th scope="col">#</th>
                                <th scope="col">First Name</th>
                                <th scope="col">Last Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Business Type</th>
                                <th scope="col">Comment</th>
                                <th scope="col">Star</th>
                                <th scope="col">Reviewed On</th>
                                @can('delete-review')
                                <th scope="col">Action</th>
                                @endcan
                                </tr>
                            </thead>
                            <tbody>
                                <?php $count = 0 ?>
                                @foreach($reviews as $review)
                                <tr>
                                    <th scope="row">{{$count += 1}}</th>
                                    <td>{{$review->user->first_name}}</td>
                                    <td>{{$review->user->last_name}}</td>
                                    <td>{{$review->user->email}}</td>
                                    <td>{{$review->model_type}}</td>
                                    <td>{{$review->review}}</td>
                                    <td>
                                        @for ($i = 1; $i <= 5; $i++)
                                        <i

                                            @if($i > $review->rating)

                                            class="fa fa-star text-black-50"

                                            @else

                                            class="fa fa-star"

                                            @endif
                                        ></i>
                                        @endfor
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($review->created_at)->diffForHumans() }}</td>
                                    @can('delete-review')
                                    <td>
                                        <a href="#" onclick="reviewDelete()"
                                            class="btn btn-sm btn-danger">Delete</a>
                                        <form action="{{ route('admin.review.delete', $review->id) }}" method="GET" id="reviewdelete">
                                            @csrf
                                        </form>
                                    </td>
                                    @endcan
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @endif
                        {{$reviews->links()}}
                        <script>
                            function reviewDelete() {
                                if (confirm("Are you sure you want to delete this review?")) {
                                    document.getElementById("reviewdelete").submit();
                                }
                            }
                        </script>
@endsection
