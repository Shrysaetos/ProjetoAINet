@extends('master')
@section('content')
<div>
            @can('create', App\Account::class)
            <a class="btn btn-primary" href="{{route('accounts.create')}}">Add Account</a>
            @endcan
        </div>
        @if (count($accounts))
            <table class="table table-striped">
    		<thead>
       	        <tr>
                    <th>Code</th>
                    <th>Account Type</th>
                    <th>Created At</th>
                    <th>Current Balance</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($accounts as $account)
                <tr>
                    <td>{{ $account->code}}</td>
                    <td>{{ $account->account_type_id}}</td>
                    <td>{{ $account->date}}</td>
                    <td>{{ $account->current_balance}}</td>
                    <td>{{ $account->description}}</td>
                    <td>
                        @can('edit', $account)
                        <a class="btn btn-xs btn-primary" href="{{route('accounts.edit', $user->id)}}">Edit</a>
                        @endcan
                        @can('delete', App\Account::class)
                        <form action="{{route('accounts.destroy', $account->id)}}" method="POST" role="form" class="inline">
                            @method('delete')
                            @csrf
                        </form>
                       @endcan
                    </td>
                </tr>
            @endforeach
            </table>
        @else
        <h2>No accounts found</h2>
        @endif
    </div>
@endsection('content')