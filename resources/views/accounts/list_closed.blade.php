@extends('master')

@section('title', 'List Closed Accounts')

@section('content')
<div>

    <a class="btn btn-primary" href="{{route('account.accountsOpened', $user->id)}}">Back to open accounts</a>  

</div>


	 @if (count($accounts)) 
    <table class="table table-striped">
    <thead>
        <tr>
            <th>Account Type</th>
            <th>Date</th>
            <th>Created At</th>
            <th>Code</th>
            <th>Decription</th>
            <th>Start Balance</th>
            <th>Current Balance</th>
            <th>Last Movement At</th>
            <th>Deleted At</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($accounts as $account)
        <tr>
            <td>{{ $account->formatted_type}}</td>
            <td>{{ $account->date}}</td>
            <td>{{ $account->created_at}}</td>
            <td>{{ $account->code }} </td>
            <td>{{ $account->description}}</td>
            <td>{{ $account->start_balance}}</td>
            <td>{{ $account->current_balance}}</td>
            <td>{{ $account->last_movement_date}}</td>
            <td>{{ $account->deleted_at}}</td>
            <td>
                
                @can('reopen', $account)
                <a class="btn btn-xs btn-primary" href="{{route('account.reopen', $account->code)}}">Reopen</a>
                @endcan

                 @can('delete', $account)
                        <form action="{{route('account.delete', $account->id)}}" method="POST" role="form" class="inline">
                            @method('delete')
                            @csrf
                            <button type="submit" class="btn btn-xs btn-danger">Delete</button>
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
   
@endsection