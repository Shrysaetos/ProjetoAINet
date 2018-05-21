@extends('master')

@section('title', 'Add Account')

@section('content')
@if ($errors->count() > 0)
    @include('partials.errors')
@endif


<form action="{{route('account.store')}}" method="post" class="form-group">
    @include('accounts.partials.add-edit')


    <!--

    <div class="form-group">
        <label for="inputStartBalance">Start Balance </label>
        <input
            type="text" class="form-control"
            name="startBaalaance" id="inputStartBalance"/>
    </div>

    -->
    <div class="form-group">
        <button type="submit" class="btn btn-success" name="ok">Add</button>
        <a class="btn btn-default" href="{{route('account.index')}}">Cancel</a>
    </div>
</form>
@endsection
