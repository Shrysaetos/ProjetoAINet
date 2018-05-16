@extends('master')

@section('title', 'Add Account')

@section('content')
@if ($errors->count() > 0)
    @include('partials.errors')
@endif


<!--Falta alterar para as contas-->

<form action="{{route('account.store')}}" method="post" class="form-group">
    @include('accounts.partials.add-edit')


    <!--Alterar codigo abaixo-->

    <div class="form-group">
        <label for="inputPassword">Password</label>
        <input
            type="password" class="form-control"
            name="password" id="inputPassword"
            value="{{old('password')}}"/>
    </div>
    <div class="form-group">
        <label for="inputPasswordConfirmation">Password confirmation</label>
        <input
            type="password" class="form-control"
            name="password_confirmation" id="inputPasswordConfirmation"/>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-success" name="ok">Add</button>
        <a class="btn btn-default" href="{{route('users.index')}}">Cancel</a>
    </div>
</form>
@endsection
