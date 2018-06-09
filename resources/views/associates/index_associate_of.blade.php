@extends('master')

@section('content')
        @if (count($my_associates))
            <table class="table table-striped">
            <thead>
                <tr>
                    <th>Photo</th>
                    <th>Name</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($my_associates as $my_associate)
                <tr>
                    <td><img src="/uploads/profiles/{{$my_associate->getProfilePhoto()}}" alt="profile_image" style="width:100px; height:100px; float:left; border-radius:50%; margin-right:30px"></td>
                    <td>{{ $my_associate->name }}</td>
                </tr>
            @endforeach
            </table>
        @else
        <h2>No users found</h2>
        @endif
    </div>
@endsection('content')