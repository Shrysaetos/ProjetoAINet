@extends('master')

@section('content')
        <form action="" method="GET">
        @csrf
            <div class="input-group">
            <input type="text" class="form-control" name="name"
            placeholder="Search users (by name)"> <span class="input-group-btn">
            <button type="submit" class="btn btn-default">
            <span class="glyphicon glyphicon-search"></span>
            </button>
            </span>
            </div>

            <div class="input-group">
            <input type="text" class="form-control" name="admin"
            placeholder="Search users (by type: normal - 0 ; admin - 1)"> <span class="input-group-btn">
            <button type="submit" class="btn btn-default">
            <span class="glyphicon glyphicon-search"></span>
            </button>
            </span>
            </div>

            <div class="input-group">
            <input type="text" class="form-control" name="blocked"
            placeholder="Search users (by status: unblocked - 0 ; admin - 1)"> <span class="input-group-btn">
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
                    <th>Name</th>
                    <th>Email</th>
                    <th>Admin</th>
                    <th>Blocked</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->name}}</td>
                    <td>{{ $user->email}}</td>
                    <td>{{ $user->admin}}</td>
                    <td>{{ $user->blocked}}</td>
                    <td>
                    @if ($user->blocked == 0)
                            @include('users.partials.admin_block')
                    @endif
                    @if ($user->blocked == 1)
                        @include('users.partials.admin_unblock')
                    @endif
                    @if ($user->admin == 0)
                        @include('users.partials.admin_promote')
                    @endif
                    @if ($user->admin == 1)
                        @include('users.partials.admin_demote')
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