@extends('layouts.app')

@section('content')


<div class="jumbotron text-center">
  <h1>Your files will be here.</h1>
  <p>Comming soon you will have all your files showing up here.<br>Stay tuned.</p>

  <h2> While you are waiting you can start uploading your files <a href="{{route('uploadGet')}}">here</a></h2>
</div>

@endsection