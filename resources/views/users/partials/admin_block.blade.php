
		<form id="logout-form" action="{{route('users.block', $user->id)}}" method="POST" role="form" class="inline">
			@method('patch')
    		@csrf
    		<button type="submit" class="btn btn-xs btn-danger">Block</button>
		</form>

