<form id="delete-role-{{ $role->id }}"
      action="{{ route('admin.roles.destroy', $role) }}"
      method="POST"
      class="d-none"
>
    @csrf
    @method('DELETE')
</form>
