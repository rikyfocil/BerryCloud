@extends('layouts.main')

@push('scripts')
    <script src="{{ asset('/js/share.js') }}"></script>
@endpush

@section('content')

<p id="file-data" data-id="{{$file->id}}" hidden>

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

@if($file->publicRead)
<div class="col-sm-12">
  <div class="col-sm-4 col-sm-offset-4">
    {!! Helper::createButton('POST', ['file.unpublish', $file->id], "Make private", "btn-success") !!}
  </div>
</div>
@else
<div class="col-sm-12">
  <div class="col-sm-4 col-sm-offset-4">
    {!! Helper::createButton('POST', ['file.publish', $file->id], "Make public", "btn-danger") !!}
  </div>
</div>
@endif

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

<h2 class="text-center col-xs-12">Sharing table of the file</h2>
<div class="col-sm-10 col-sm-offset-1">
  <table class="table">
    
    <thead>
      <tr>
      <td>Shared with</td>
      <td>Permission type</td>
      <td>Expiring</td>
      <td>Options</td>
    </tr>
    </thead>
    <tbody id="shareTableBody">
      
    </tbody>
  </table>
</div>

<div class="col-xs-12">
<h3 class="text-center"> Share the file with someone else </h3>
<p class="text-center"> Here you can share the file with someone new. If the file is already sharing the file, the settings will be updated to the new selected ones. </p>

{{Form::open([
'method' => 'POST',
'route' => ['file.share.create', $file->id],
'id' => 'share-form-new'
])}}
<div class="col-xs-3 form-group">
  <label for="user">Share with (Email):</label>
  <input type="email" name="user" id="share-email" class="col-xs-12 form-control">
</div>
<div class="col-xs-3 form-group">
  <label for="idPermissionType">Sharing type:</label>
  {{Form::select('idPermissionType', $sharing_types, null, ['class'=>'col-xs-12 form-control'])}}
</div>
<div class="col-xs-3 form-group">
  <label for="dueDate">Due date (optional):</label>
  <input type="text" name="dueDate" id="dueDate" class="col-xs-12 form-control datepicker">
</div>
<div class="col-xs-3 form-group">
  <label>&nbsp;</label>
  <button class="col-xs-12 form-control btn btn-success">Share!</button> 
  <img src="{{asset('img/Preloader_3.gif')}}" width="64px" height="64px" hidden>
</div>

</div>
{{Form::close()}}

{{Form::open([
'method' => 'DELETE',
'route' => ['file.share.delete', $file->id, ':ID'],
'id' => 'share-form-del'
])}}
{{Form::close()}}
@endsection
