@extends('master')

@section('title', 'Add Movement')

@section('content')
@if ($errors->count() > 0)
    @include('partials.errors')
@endif


<form action="{{route('movement.store', $account->id)}}" method="post" class="form-group">
    @include('movements.partials.add-edit')


    <div class="form-group">
        <button type="submit" class="btn btn-success" name="ok">Add</button>
        <a class="btn btn-default" href="{{route('movement.index', $account->id)}}">Cancel</a>
    </div>
</form>
@endsection
