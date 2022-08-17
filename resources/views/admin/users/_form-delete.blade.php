<form id="delete-user-{{ $user->id }}"
      action="{{ route('admin.users.destroy', $user->id) }}"
      method="POST"
      class="d-none"
>
    @csrf
    @method('DELETE')
</form>
