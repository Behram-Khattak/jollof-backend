<p>
    Hello {{ auth()->user()->first_name }} (not {{ auth()->user()->first_name }}? <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>)
</p>
<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    @csrf
</form>
<hr />
