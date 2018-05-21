@extends('master')
@section('content')
<div>
    @can('create', App\Account::class)
    <a class="btn btn-primary" href="{{route('account.store')}}">Add account</a>
    @endcan
</div>
    @if (count($accounts)) 
    <table class="table table-striped">
    <thead>
        <tr>
            <th>Account Type</th>
            <th>Date</th>
            <th>Created At</th>
            <th>Decription</th>
            <th>Start Balance</th>
            <th>Current Balance</th>
            <th>Last Movement At</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($accounts as $account)
        <tr>
            <td>{{ $account->formatted_type}}</td>
            <td>{{ $account->date}}</td>
            <td>{{ $account->created_at}}</td>
            <td>{{ $account->description}}</td>
            <td>{{ $account->start_balance}}</td>
            <td>{{ $account->current_balance}}</td>
            <td>{{ $account->last_movement_date}}</td>
            <td>
                @can('edit', $user)
                <a class="btn btn-xs btn-primary" href="{{route('account.update', $account->code)}}">Edit</a>
                @endcan
                @can('delete', App\Account::class)
                <form action="{{route('account.delete', $account->code)}}" method="POST" role="form" class="inline">
                    @method('delete')
                    @csrf
                    <button type="submit" class="btn btn-xs btn-danger">Delete</button>
                </form>
                @endcan
                 @can('close', App\Account::class)
                <form action="{{route('account.close', $account->code)}}" method="POST" role="form" class="inline">
                    @method('patch')
                    @csrf
                    <button type="submit" class="btn btn-xs btn-danger">Close</button>
                </form>
                @endcan

            </td>
        </tr>
        @endforeach
    </table>
@else
    <h2>No accounts found</h2>
@endif
@endsection