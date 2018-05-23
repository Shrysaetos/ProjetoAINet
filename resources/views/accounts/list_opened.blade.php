@extends('master')

@section('title', 'List User Accounts')

@section('content')
<div>
            @can('create', App\Account::class)
            <a class="btn btn-primary" href="{{route('accounts.create')}}">Add Account</a>
            @endcan


            <a class="btn btn-default" href="{{route('account.accountsClosed', $user->id)}}">List Closed Accounts</a>


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


                        <form action="{{route('movement.index', $account->code)}}" method="get" role="form" class="inline">
                        @csrf
                        <button type="submit" class="btn btn-xs btn-primary">List Moviments</button>
                        </form>


                    </td>
                </tr>
            @endforeach
            </table>
        @else
        <h2>No accounts found</h2>
        @endif
    </div>
@endsection('content')