@extends('master')

@section('title', 'Personal Finances Assistant')

@section('content')
<div>
    @can('create', App\User::class)
    <a class="btn btn-primary" href="{{route('users.create')}}">Add user</a>
    @endcan
</div>
    @if (count($users))
    <table class="table table-striped">
    <thead>
        <tr>
            <th>Email</th>
            <th>Name</th>
            <th>Created At</th>
            <th>Type</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($users as $user)
        <tr>
            <td>{{ $user->email}}</td>
            <td>{{ $user->name}}</td>
            <td>{{ $user->created_at}}</td>
            <td>{{ $user->formatted_type}}</td>
            <td>
                @can('edit', $user)
                <a class="btn btn-xs btn-primary" href="{{route('users.edit', $user->id)}}">Edit</a>
                @endcan
                @can('delete', App\User::class)
                <form action="{{route('users.destroy', $user->id)}}" method="POST" role="form" class="inline">
                    @method('delete')
                    @csrf
                    <button type="submit" class="btn btn-xs btn-danger">Delete</button>
                </form>
                @endcan

            </td>
        </tr>
        @endforeach
    </table>
@else
    <h2>No users found</h2>
@endif
@endsection
