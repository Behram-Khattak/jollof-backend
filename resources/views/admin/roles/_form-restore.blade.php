<form id="restore-role-{{ $role->id }}"
      action="{{ route('admin.roles.restore', $role) }}"
      method="POST"
      class="d-none"
>
    @csrf
    @method('PATCH')
</form>
