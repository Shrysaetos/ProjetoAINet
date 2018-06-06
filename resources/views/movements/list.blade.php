@extends('master')

@section('title', 'List Account Moviments')

@section('content')

<div>
    
    @can('create', $account)
    <a class="btn btn-primary" href="{{route('movement.create', $account->id)}}">Add account movement</a>
    @endcan

    <a class="btn btn-default" href="{{route('account.accountsOpened', Auth::user()->id)}}">Back to Accounts</a>
    
    

    
</div>
    @if (count($movements)) 
    <table class="table table-striped">
    <thead>
        <tr>
            <th>Moviment Category</th>
            <th>Date</th>
            <th>Value</th>
            <th>Start Balance</th>
            <th>End Balance</th>
            <th>Description</th>
            <th>Type</th>
            <th>Document</th>
            <th>Created At</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($movements as $movement)
        <tr>
            <td>{{ $movement->formatted_category}}</td>
            <td>{{ $movement->date}}</td>
            <td>{{ $movement->value}}</td>
            <td>{{ $movement->start_balance}}</td>
            <td>{{ $movement->end_balance}}</td>
            <td>{{ $movement->description}}</td>
            <td>{{ $movement->type}}</td>
            <td>{{ $movement->document_id}}</td>
            <td>{{ $movement->created_at}}</td>
            <td>

                
                @can('edit', $movement)
                <a class="btn btn-xs btn-primary" href="{{route('movement.edit', $movement->id)}}">Edit</a>
                @endcan
                
               @can('delete', $movement) 
                <form action="{{route('movement.delete', $movement->id)}}" method="POST" role="form" class="inline">
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
    <h2>No movements found</h2>
@endif

        

</div>

@endsection