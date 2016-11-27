
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
				{{ Form::open(array('url' => 'permissions/' . $user->id)) }}
				<td>

					

					<select name ="permission">
						@foreach($permission_types as $p_types )
							<option {{ $user->idUserType == $p_types->id? "selected" :""}} value="{{$p_types->id}}">{{$p_types->name}}</option>
						@endforeach
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
