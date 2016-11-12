@extends('layouts.main')

@section('content')


<div class="jumbotron text-center">
  <h1>Your files are here.</h1>
  <h2> You can upload more <a href="{{route('uploadGet', isset($parent) ? ['parent' => $parent->id] : [] )}}">here</a></h2>
</div>

@if(isset($parent))
	<div>
		<h1 class="text-center"> <i class="fa fa-folder-open-o"></i>{{$parent->name}}</h1>
	</div>
@endif

<div class="col-sm-10 col-sm-offset-1">
  @include('layouts.files', ['files' => $files])
</div>
@endsection
