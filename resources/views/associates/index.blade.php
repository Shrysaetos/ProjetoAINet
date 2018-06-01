@extends('master')

@section('content')
        @if (count($my_associates))
            <table class="table table-striped">
            <thead>
                <tr>
                    <th>Photo</th>
                    <th>Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($my_associates as $my_associate)
                <tr>
                    <td><img src="\storage\app\public\profiles\{{ $my_associate->profile_photo }}"></td>
                    <td>{{ $my_associate->name }}</td>
                    <td><button type="submit" class="btn btn-xs btn-danger">Remove Associate</button></td>
                </tr>
            @endforeach
            </table>
        @else
        <h2>No users found</h2>
        @endif
    </div>
@endsection('content')