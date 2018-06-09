@extends('master')

@inject('associate', 'App\Http\Controllers\UserController')

@section('content')
        <form enctype="multipart/form-data" action="{{ route('users.index') }}" method="GET">
        @csrf
            <div class="input-group">
            <input type="text" class="form-control" name="name"
            placeholder="Search users"> <span class="input-group-btn">
            <button type="submit" class="btn btn-default">
            <span class="glyphicon glyphicon-search"></span>
            </button>
            </span>
            </div>
        </form>
        @if (count($users))
            <table class="table table-striped">
            <thead>
                <tr>
                    <th>Photo</th>
                    <th>Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($users as $user)
                <tr>
                    <td><img src="{{asset('storage/profiles/'.$user->getProfilePhoto())}}" alt="profile_photo" style="width:100px; height:100px; float:left; border-radius:50%; margin-right:30px"></td>
                    <td>{{ $user->name }}
                        @if ($associate::amAssociate($user))
                            <span>associate-of</span>
                        @endif
                        @if ($associate::isAssociate($user))
                            <span>associate</span>
                        @endif
                    <td>
                        @if ($associate::isAssociate($user))
                        <form id="deletemember-form" action="{{route('user.delete.associate', $user->id)}}" method="POST" role="form" class="inline">
                            @method('post')
                            @csrf
                            <button type="submit" class="btn btn-xs btn-primary">Delete Associate</button>
                        </form>
                        @else
                            <form id="addmember-form" action="{{route('user.add.associate')}}" method="POST" role="form" class="inline">
                            @method('post')
                            @csrf
                            <button type="submit" class="btn btn-xs btn-primary">Add Associate</button>
                        </form>
                        @endif
                    </td>
                </tr>
            @endforeach
            </table>
        @else
        <h2>No users found</h2>
        @endif
    </div>
@endsection('content')