@extends('master')

@section('content')
        @if (count($associates))
            <table class="table table-striped">
            <thead>
                <tr>
                    <th>Photo</th>
                    <th>Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($associates as $associate)
                <tr>
                    <td><img src="\storage\app\public\profiles\{{ $my_associate->profile_photo }}"></td>
                    <td>{{ $associate->name }}</td>
                    <td>
                        <form id="deletemember-form" action="" method="POST" role="form" class="inline">
                            @method('post')
                            @csrf
                            <button type="submit" class="btn btn-xs btn-danger">Delete Associate</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </table>
        @else
        <h2>No users found</h2>
        @endif
    </div>
@endsection('content')