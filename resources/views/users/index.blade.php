@extends('master')

@section('title', 'Personal Finances Assistant')

@section('content')
    @if (count($users))
    <table class="table table-striped">
    <thead>
        <tr>
            <th>Photo</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Created At</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($users as $user)
        <tr>
            <td>{{ $user->profile_photo}}</td>
            <td>{{ $user->name}}</td>
            <td>{{ $user->email}}</td>
            <td>{{ $user->phone}}</td>
            <td>{{ $user->created_at}}</td>
        </tr>
        @endforeach
    </table>
@else
    <h2>No users found</h2>
@endif
@endsection
