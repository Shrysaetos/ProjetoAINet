<form action="{{route('users.demote', $user->id)}}" method="POST" role="form" class="inline">
    @method('patch')
    @csrf
    <button type="submit" class="btn btn-xs btn-danger">Demote</button>
</form>