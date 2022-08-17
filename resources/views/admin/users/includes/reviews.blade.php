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
                    @if($reviews->isEmpty())
                    <p>There are no reviews currently</p>
                    @else
                    <div class="kt-portlet__body">
                        <!--begin::Form-->
                        <div id="kt_datatable">

                            <table class="kt-datatable" id="roles-table" width="100%" role="grid">
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
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $count = 0 ?>
                                    @foreach($reviews as $review)
                                    <tr>
                                        <td scope="row">{{$loop->iteration}}</td>
                                        <td>{{$review->user->first_name}}</td>
                                        <td>{{$review->user->last_name}}</td>
                                        <td>{{$review->user->email}}</td>
                                        <td>{{$review->model_type}}</td>
                                        <td>{{$review->review}}</td>
                                        <td>
                                            @for ($i = 1; $i <= 5; $i++) <i @if($i> $review->rating)

                                                class="fa fa-star text-black-50"

                                                @else

                                                class="fa fa-star"

                                                @endif
                                                ></i>
                                                @endfor
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($review->created_at)->diffForHumans() }}</td>
                                        <td>
                                            <a href="#" onclick="reviewDelete()" class="btn btn-sm btn-danger">Delete</a>
                                            <form action="{{ route('admin.review.delete', $review->id) }}" method="GET" id="reviewdelete">
                                                @csrf
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @endif
                            <script>
                                function reviewDelete() {
                                    if (confirm("Are you sure you want to delete this review?")) {
                                        document.getElementById("reviewdelete").submit();
                                    }
                                }
                            </script>
                        </div>
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
