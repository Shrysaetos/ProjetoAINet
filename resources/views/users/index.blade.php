@extends('master')

@section('title', 'List users')

@section('content')
<div><a class="btn btn-primary" href="{{route('users.create')}}">Add user</a></div>
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
            <td>{{ $user->typeToStr()}}</td>
            <td>
                <a class="btn btn-xs btn-primary" href="{{route('users.edit', $user->id)}}">Edit</a>
                <form action="{{route('users.destroy', $user->id)}}" method="POST" role="form" class="inline">
                    <!-- FICAM A FALTAR DUAS LINHAS DE CODIGO -->
                    <button type="submit" class="btn btn-xs btn-danger">Delete</button>
                </form>

            </td>
        </tr>
        @endforeach
    </table>
@else
    <h2>No users found</h2>
@endif
@endsection
