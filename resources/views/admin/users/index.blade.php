@extends('admin.layouts.master')

@section('title', 'Users | Jollof')

@section('content')

<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">

    <div class="kt-portlet kt-portlet--tabs">
        <div class="kt-portlet__head">

            <div class="kt-portlet__head-toolbar">

                <ul class="nav nav-tabs nav-tabs-line nav-tabs-line-brand nav-tabs-line-2x nav-tabs-line-right nav-tabs-bold" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->query('role') ? '' : 'active' }}" href="{{ route('admin.users.index') }}" role="tab" aria-selected="{{ request()->query('role') ? 'false' : 'true' }}">
                            <i class="flaticon2-heart-rate-monitor" aria-hidden="true"></i>
                            All Users
                        </a>
                    </li>
                    @foreach($roles as $role)
                    <li class="nav-item">
                        <a class="nav-link {{ request()->query('role') === $role->name ? 'active' : '' }}" href="{{ route('admin.users.index', ['role' => $role->name]) }}" role="tab" aria-selected="{{ request()->query('role') === $role->name ? 'true' : 'false' }}">
                            <i class="flaticon2-pie-chart-2" aria-hidden="true"></i>
                            {{ \Illuminate\Support\Str::plural(ucfirst($role->name)) }}
                        </a>
                    </li>
                    @endforeach
                </ul>

            </div>
            @can('create-users')
            <div class="kt-portlet__head-wrapper align-self-center">

                <b-dropdown right variant="primary" toggle-class="btn-bold btn-upper btn-font-sm">
                    <template v-slot:button-content>
                        <i class="la la-plus"></i>
                        New User
                    </template>
                    <b-dropdown-item href="{{ route('admin.users.create', ['role' => \App\Enums\DefaultRoles::MERCHANT]) }}">
                        Merchant
                    </b-dropdown-item>
                    <b-dropdown-item href="{{ route('admin.users.create') }}">
                        Others
                    </b-dropdown-item>
                </b-dropdown>

            </div>
            @endcan

        </div>
        <!-- Search input -->
        @if($users->count() > 0)
        <div class="row justify-content-center mt-2 mb-2">
            <div class="col-md-5">
                <div class="kt-input-icon kt-input-icon--left">
                    <input type="text" class="form-control" placeholder="Search..." id="generalSearch">
                    <span class="kt-input-icon__icon kt-input-icon__icon--left">
                        <span><i class="la la-search"></i></span>
                    </span>
                </div>
            </div>
            <!-- Export button -->
            <div class="dropdown show">
                <a class="btn btn-secondary dropdown-toggle" href="#" size="20" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Export
                </a>

                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                    <a class="dropdown-item" href="export/users/csv">CSV</a>
                    <a class="dropdown-item" href="export/users/excel">Excel</a>
                </div>
            </div>
        </div>
        @endif
        <div class="kt-portlet__body">

            <div class="kt-section">
                <div class="kt_datatable">

                    <table class="kt_datatable" id="roles-table" width="100%" role="grid">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>E-mail</th>
                                <th>Telephone</th>
                                <th>Role(s)</th>
                                <th>Date Registered</th>
                                <th>Status</th>
                                @canany(['update-users','delete-users'])
                                <th>Actions</th>
                                @endcanany
                            </tr>
                        </thead>
                        <tbody>

                            @forelse($users as $user)

                            @if($user)
                            <tr>
                                <td>
                                    <a>
                                        {{ ucwords("{$user->first_name} {$user->last_name}") }}
                                    </a>
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->telephone ?? 'Not Available' }} </td>
                                <td>
                                    {{ $user->roles->pluck('name')->implode(' | ') }}
                                </td>
                                <td>
                                    {{ date('d-M-Y, h:i A', strtotime($user->created_at)) }}
                                </td>
                                <td>
                                    <span>
                                        <span class="kt-badge kt-badge--{{ $user->trashed() ? "danger" : "success" }} kt-badge--bold kt-badge--lg kt-badge--inline kt-badge--pill">
                                            @if ($user->trashed())
                                            {{ ucfirst('deactivated') }}
                                            @else
                                            {{ ucfirst('active') }}
                                            @endif
                                        </span>
                                    </span>
                                </td>
                                <td>
                                    @can('update-users')

                                    <b-link href="{{ route('admin.users.show', $user->id) }}" class="btn btn-sm btn-icon btn-icon-md btn-outline-hover-info" title="Edit">
                                        <i class="fa fa-pen"></i>
                                    </b-link>
                                    @endcan
                                    @can('delete-users')
                                    @if ($user->trashed())
                                    <button class="btn btn-sm btn-icon btn-icon-md btn-outline-hover-success" title="Restore" onclick="document.getElementById('restore-user-{{ $user->id }}').submit();">
                                        <i class="fa fa-sync" id="user-{{ $user->id }}"></i>
                                    </button>
                                    @include('admin.users._form-restore')
                                    @else
                                    {{-- duplicate id on button and inner icon is intentional--}}
                                    <button class="btn btn-sm btn-icon btn-icon-md btn-outline-hover-danger js-delete-trigger" title="Deactivate" id="user-{{ $user->id }}">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                    @include('admin.users._form-delete')
                                    @endif
                                    @endcan

                                </td>

                            </tr>
                            @endif
                            @empty
                            <tr>
                                <td class="p-5 text-center">No record found</td>
                            </tr>
                            @endforelse

                        </tbody>

                    </table>



                </div>
            </div>

        </div>
    </div>

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
