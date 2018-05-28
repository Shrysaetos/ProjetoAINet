@extends('master')

@section('content')
        <form action="" method="GET">
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
                    <td><img src="\storage\app\public\profiles"></td>
                    <td>{{ $user->name}}</td>>
                    <td><button type="submit" class="btn btn-xs btn-primary">Add Associate</button></td>
                </tr>
            @endforeach
            </table>
        @else
        <h2>No users found</h2>
        @endif
    </div>
@endsection('content')