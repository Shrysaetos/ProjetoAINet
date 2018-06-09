@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-body" style="">
                        <div class="row" style="margin-bottom: 20px">
                            <div class="col-md-5 " style="text-align: center; margin:0 auto;">
                                <img src="{{asset('uploads/profiles/'.$user->getProfilePhoto())}}" alt="profile_image"
                                     style="width:150px;height:150px;border-radius:20%; ">

                            </div>
                                <h4>{{$user->name}}</h4>
                                <div class="info">
                                    <hr>
                                    <ul class="perfil" style="list-style: none; margin:0; padding:0;">
                                        <li>
                                            <i class="glyphicon glyphicon-envelope"></i>Email:
                                            <strong>{{$user->email}}</strong>
                                        </li>
                                        @if(isset($user->phone))
                                            <li>
                                                <i class="glyphicon glyphicon-phone"></i>Phone:
                                                <strong>{{$user->phone}}</strong>
                                            </li>
                                        @endif
                                    </ul>
                                    <br><br><button type="button" onclick="window.location='{{ url("me/password") }}'">Change Password</button><br>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="text-align: center">
                                <div class="col-md-3 col-md-offset-1">
                                    <a href="me/profile" class="btn btn-primary">Edit</a>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
