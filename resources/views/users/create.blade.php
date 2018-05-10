@extends('users.template')
@section('content')
<form action="{{ action('UserController@store') }}" method="post">
    {{csrf_field()}}
    <div>
    <label for="inputName">Name</label>
        <input type="text" name="name" id="inputName" placeholder="Name">
    </div>
    <div>
        <label for="inputAge">Age</label>
        <input type="text" name="age" id="inputAge" placeholder="Age">
    </div>
    <div>
        <button type="submit" name="ok">Save</button>
        <button type="submit" name="cancel">Cancel</button>
    </div>
</form>
@endsection('content')