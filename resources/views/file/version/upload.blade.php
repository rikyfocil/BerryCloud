@extends('layouts.app')

@section('content')


<div class="jumbotron text-center">
  <h1>Your files will be safe in your own cloud with version control</h1>
  <p>This is where you upload a new version for {{$file->name}}</p>
</div>

{!! Form::open(
    array(
        'route' => ['uploadVersion', $file->id], 
        'class' => 'form',
        'method' => 'post', 
        'files' => true)) !!}
<div class="col-sm-2 col-sm-offset-5">
	<div class="form-group">
	    {!! Form::label('File to upload', null ,[
	    	'class' => "input-group" ]) !!}
	    {!! Form::file('file')	!!}
	</div>

	<div class="form-group">
		<button><i class="fa fa-cloud-upload">&nbsp;Upload version!</i></button>
	</div>
	{!! Form::close() !!}
</div>

@endsection