@extends('layouts.app')

@section('content')

<h1 class="text-center">{{$file->name}}</h1>

<p class="text-center"> This file was created at {{$file->createdAt}} </p>
<p class="text-center"> The current version was uploaded at {{ $versions[0]->created_at }} </p>

<div class="col-sm-12">
	<div class="col-sm-4 col-sm-offset-4">
		{!! Helper::createButton('GET', ['file.download',$file->id], "Download", "btn-success") !!}
	</div>
</div>
<div class="col-sm-12">
	<div class="col-sm-4 col-sm-offset-4">
		{!! Helper::createButton('GET', ['uploadVersionGet', $file->id], "Upload new version", "btn-info") !!}
	</div>
</div>
<div class="col-sm-12">
	<div class="col-sm-4 col-sm-offset-4">
		{!! Helper::createButton('DELETE', ['file.delete',$file->id], "Move to trash", "btn-warning") !!}
	</div>
</div>
<div class="col-sm-12">
	<div class="col-sm-4 col-sm-offset-4">
		{!! Helper::createButton('DELETE', ['file.delete.hard',$file->id], "Delete permanently", "btn-danger") !!}
	</div>
</div>

<h2 class="text-center">Versions of the file</h2>
<div class="col-sm-10 col-sm-offset-1">
  <table class="table">
    
    <tr>
      <td>Version uploaded at</td>
      <td>Options</td>
    </tr>

    @foreach ($versions as $version)

      <tr>
        
        <td>{{$version->created_at}}</td>
        <td>
          <div class="col-xs-4"> 
            {!! Helper::createButton('GET', ['file.version.download',$file->id, $version->id], "Download Version", "btn-success") !!}
          </div>
          <div class="col-xs-4"> 
            {!! Helper::createButton('POST', ['file.version.restore', $file->id, $version->id], "Restore this version", "btn-info") !!}
          </div>
          <div class="col-xs-4"> 
            {!! Helper::createButton('DELETE', ['file.version.delete',$file->id, $version->id], "Delete this version", "btn-danger") !!}
          </div>
        </td>
      </tr>
      
    @endforeach

  </table>
</div>

@endsection