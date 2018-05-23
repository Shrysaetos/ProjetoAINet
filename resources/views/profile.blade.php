@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <img src="/storage/app/public/profiles/{{ $user->profile_photo }}" style="width:100px; height:100px; float:left; border-radius:50%; margin-right:30px">
            <h4>{{ $user->name }}'s Profile</h4>
            <form enctype="multipart/form-data" action="/profile" method="POST">
                <label>Update Profile Image</label><br>
                <input type="file" name="profile_photo"><br>
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="submit"  class="pull-right btn btn-sm btn-primary">
                <br><br><button type="button" onclick="window.location='{{ url("me/password") }}'">Change Password</button><br>
                <br><br><label>Current Email: {{ $user->email }}</label><br>
                <button type="button" onclick="window.location='{{ url("me/email") }}'">Change Email</button><br>
                <br><br><label>Current Name: {{ $user->name }}</label><br>
                <button type="button" onclick="window.location='{{ url("me/name") }}'">Change Name</button><br>
                <br><br><label>Current Phone Number: {{ $user->phone }}</label><br>
                <button type="button" onclick="window.location='{{ url("me/phone") }}'">Change Phone Number</button><br>
            </form>
        </div>
    </div>
</div>
@endsection
