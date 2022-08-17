<div class="kt_datatable">

    <table class="kt_datatable" id="roles-table" width="100%" role="grid">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Telephone</th>
                <th>Role</th>
                <th>Date Registered</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>

            @forelse($users as $user)

            @if($user)
            <tr>
                <td>
                    <a href="{{ route('admin.users.show', $user) }}">
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
