<form action="{{route('users.promote', $user->id)}}" method="POST" role="form" class="inline">
    @method('patch')
    @csrf
    <button type="submit" class="btn btn-xs btn-primary">Promote</button>
</form>