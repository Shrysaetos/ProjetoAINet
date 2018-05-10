@extends('master')
@section('content')
<table>
	<thead> <tr> <th>Name</th> <th>Age</th> <th></th> <th></th> </tr> </thead>
	<tbody>
		@foreach ($users as $user)
		<tr>
			<td>{{ $user->name }} </td>
			<td>{{ $user->age }} </td>
			<td><a href="#">Edit</a></td>
			<td>
				<form action="#" method="post">
					<input type="hidden" name="id" value="{{$user->id}}">
					<input type="submit" value="Delete">
				</form>
			</td>
		</tr>
	@endforeach
	</tbody>
</table>
@endsection('content')