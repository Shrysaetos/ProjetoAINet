@extends('master')

@section('title', 'Edit Movement')

@section('content')
@if ($errors->count() > 0)
    @include('partials.errors')
@endif
<form action="{{route('movement.update', $movement->id)}}" method="post" class="form-group">
    @method('put')
    @include('movements.partials.add-edit')
    <div class="form-group">
        <button type="submit" class="btn btn-success" name="ok">Save</button>
        <a class="btn btn-default" href="{{route('account.accountsOpened', Auth::user()->id)}}">Cancel</a>
    </div>
</form>
@endsection
