@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>
                
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                    Please, choose one of the following things to do!
                </div>


                <div class="card-body">
                    <a class="btn btn-default" href="{{route('user.stats')}}">Statistics</a>
                    <a class="btn btn-default" href="{{route('account.accountsOpened')}}">View Accounts</a>
                    <a class="btn btn-default" href="{{route('user.profile')}}">View Profile</a>

                </div>                
            </div>
        </div>
    </div>
</div>
@endsection
