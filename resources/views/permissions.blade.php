
@extends ('layouts.main')
	@section('content')

	<table class="table">
		<thead>
			<th>User</th>
			<th>Mail</th>
			<th>Permission</th>
			<th>Save changes</th>
		</thead>
		@foreach($users as $user)
			<tbody>
				<td>{{$user->name}}</td>
				<td>{{$user->email}}</td>
				{{ Form::open(array('url' => 'permission/' . $user->id)) }}
				<td>
					<select name ="permission">
						<option {{ $user->permission->id == 1? "selected" :""}} value="1">Standard</option>
						<option {{ $user->permission->id == 2? "selected" :""}} value="2">Administrative</option>
						<option {{ $user->permission->id == 3? "selected" :""}} value="3">Root</option>
					<select>
								
				</td>
				<td>				
                    {{ Form::hidden('_method', 'PUT') }}
                    {{ Form::submit('Change') }}
                {{ Form::close() }}
				</td>
			</tbody>
		@endforeach
	</table>
@endsection