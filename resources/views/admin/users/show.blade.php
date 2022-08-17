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

                    <div class="kt-portlet__body">
                        <!--begin::Form-->
                        <form method="POST" action="{{ route('admin.users.update', $user) }}" class="kt-form">
                            @csrf

                            @method('PATCH')

                            <div class="kt-form kt-form--label-right">

                                <div class="row">
                                    <div class="col-md-3">
                                        <svg class="bd-placeholder-img img-thumbnail" width="200" height="200" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="A generic square placeholder image with a white border around it, making it resemble a photograph taken with an old instant camera: 200x200">
                                            <title>A generic square placeholder image with a white border around it,
                                                making it resemble a photograph taken with an old instant
                                                camera</title>
                                            <rect width="100%" height="100%" fill="#868e96"></rect>
                                            <text x="50%" y="50%" fill="#dee2e6" dy=".3em">200x200</text>
                                        </svg>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="kt-form__body">
                                            <div class="kt-section kt-section--first">
                                                <div class="kt-section__body">
                                                    <div class="form-group row">
                                                        <label class="col-xl-3 col-lg-3 col-form-label" for="username">
                                                            Username
                                                        </label>
                                                        <div class="col-lg-9 col-xl-6">
                                                            <input class="form-control @error('username') is-invalid @enderror" type="text" value="{{ old('username', $user->username) }}" required name="username" id="username">
                                                            @error('username')
                                                            <x-invalid-feedback message="{{ $message }}"></x-invalid-feedback>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-xl-3 col-lg-3 col-form-label" for="role">Role
                                                        </label>
                                                        <div class="col-lg-9 col-xl-6">
                                                            <select id="roles" name="role" class="form-control @error('role') is-invalid @enderror" required>
                                                                @foreach($roles as $r)
                                                                <option value="{{ $r->name }}" {{ ($role == $r->name) ? 'selected' : '' }}>{{ $r->name }}</option>
                                                                @endforeach
                                                            </select>

                                                            @error('roles')
                                                            <x-invalid-feedback message="{{ $message }}"></x-invalid-feedback>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-xl-3 col-lg-3 col-form-label" for="first-name">
                                                            First Name
                                                        </label>
                                                        <div class="col-lg-9 col-xl-6">
                                                            <input class="form-control @error('first_name') is-invalid @enderror" type="text" name="first_name" id="first-name" value="{{ old('first_name', $user->first_name) }}" required>
                                                            @error('first_name')
                                                            <x-invalid-feedback message="{{ $message }}"></x-invalid-feedback>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-xl-3 col-lg-3 col-form-label" for="last-name">
                                                            Last Name
                                                        </label>
                                                        <div class="col-lg-9 col-xl-6">
                                                            <input class="form-control @error('last_name') is-invalid @enderror" type="text" value="{{ old('last_name', $user->last_name) }}" name="last_name" id="last-name" required>
                                                            @error('last_name')
                                                            <x-invalid-feedback message="{{ $message }}"></x-invalid-feedback>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-xl-3 col-lg-3 col-form-label" for="email">
                                                            Email Address
                                                        </label>
                                                        <div class="col-lg-9 col-xl-6">
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">
                                                                        <i class="la la-at"></i>
                                                                    </span>
                                                                </div>
                                                                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" value="{{ old('email', $user->email) }}" placeholder="Email" required>
                                                                @error('email')
                                                                <x-invalid-feedback message="{{ $message }}"></x-invalid-feedback>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-xl-3 col-lg-3 col-form-label" for="telephone">
                                                            Telephone
                                                        </label>
                                                        <div class="col-lg-9 col-xl-6">
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">
                                                                        <i class="la la-phone"></i>
                                                                    </span>
                                                                </div>
                                                                <input type="tel" class="form-control @error('telephone') is-invalid @enderror" value="{{ old('telephone', $user->telephone) }}" placeholder="Phone" required id="telephone" name="telephone">
                                                                @error('telephone')
                                                                <x-invalid-feedback message="{{ $message }}"></x-invalid-feedback>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <hr>

                            <div class="kt-form__actions d-flex justify-content-between">
                                <div>
                                    @can('update-users')
                                    <b-button type="submit" class="btn btn-primary mr-2">
                                        <i class="la la-save"></i>
                                        Update User
                                    </b-button>
                                    @endcan

                                    <b-link href="{{ url()->previous() }}" role="button" class="btn btn-secondary">
                                        <i class="la la-times"></i>
                                        Cancel
                                    </b-link>

                                </div>
                                @can('delete-users')
                                @if ($user->trashed())
                                <b-button type="button" class="btn btn-outline-brand" onclick="document.getElementById('restore-user-{{ $user->id }}').submit();">
                                    <i class="fa fa-sync" id="user-{{ $user->id }}"></i>
                                    Reactivate User
                                </b-button>

                                @else
                                <b-button type="button" class="btn btn-outline-danger js-delete-trigger" id="user-{{ $user->id }}">
                                    <i class="la la-trash"></i>
                                    Deactivate User
                                </b-button>
                                @endif
                                @endcan

                            </div>

                        </form>
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
