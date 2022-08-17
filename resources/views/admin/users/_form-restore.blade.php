<form id="restore-user-{{ $user->id }}"
      action="{{ route('admin.users.restore', $user) }}"
      method="POST"
      class="d-none"
>
    @csrf
    @method('PATCH')
</form>
