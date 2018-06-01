<form action="{{route('users.unblock', $user->id)}}" method="POST" role="form" class="inline">
    @method('patch')
    @csrf
    <button type="submit" class="btn btn-xs btn-primary">Unblock</button>
</form>