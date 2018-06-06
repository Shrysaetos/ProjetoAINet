@extends('master')

@section('title', 'List User Accounts')

@section('content')
<div>
            
            @can('createAccount', $user)
            <a class="btn btn-primary" href="{{route('account.create')}}">Add account</a>
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
                    <td>{{ $account->formatted_type}}</td>
                    <td>{{ $account->date}}</td>
                    <td>{{ $account->current_balance}}</td>
                    <td>{{ $account->description}}</td>
                    <td>
                        
                        
                        @can('edit', $account)
                        <a class="btn btn-xs btn-primary" href="{{route('account.edit', $account->id)}}">Edit</a>
                        @endcan
                        
                        @can('delete', $account)
                        <form action="{{route('account.delete', $account->id)}}" method="POST" role="form" class="inline">
                            @method('delete')
                            @csrf
                            <button type="submit" class="btn btn-xs btn-danger">Delete</button>
                        </form>
                       @endcan


                        @can('close', $account)
                        <form action="{{route('account.close', $account->id)}}" method="POST" role="form" class="inline">
                        @method('patch')
                        @csrf
                        <button type="submit" class="btn btn-xs btn-danger">Close</button>
                        </form>
                        @endcan

                        
                        <form action="{{route('movement.index', $account->id)}}" method="get" role="form" class="inline">
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


        <a class="btn btn-default" href="{{route('home')}}">Back to home page</a>

    </div>
@endsection('content')