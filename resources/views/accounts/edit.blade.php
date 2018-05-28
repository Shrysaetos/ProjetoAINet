@extends('master')

@section('title', 'Edit Account')

@section('content')
@if ($errors->count() > 0)
    @include('partials.errors')
@endif
<form action="{{route('account.update', $account->id)}}" method="post" class="form-group">
    @method('put')
    @include('accounts.partials.add-edit')
    <div class="form-group">
        <button type="submit" class="btn btn-success" name="ok">Save</button>
        <a class="btn btn-default" href="{{route('account.accountsOpened', $account->owner_id)}}">Cancel</a>
    </div>
</form>
@endsection
