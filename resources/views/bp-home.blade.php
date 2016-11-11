@extends('layouts.main')

@section('content')


<div class="jumbotron text-center">
  <h1>Your files are here.</h1>
  <h2> You can upload more <a href="{{route('uploadGet')}}">here</a></h2>
</div>

<div class="col-sm-10 col-sm-offset-1">
  <table class="table">

    <tr>
      <td>File name</td>
      <td>Options</td>
    </tr>

    @foreach ($files as $file)

      <tr>

        <td><a href="{{route('file.show', $file->id)}}">{{$file->name}}</a></td>
        <td>
          <div class="col-xs-6">
            {!! Helper::createButton('GET', ['file.download',$file->id], "Download", "btn-success") !!}
          </div>
          <div class="col-xs-6">
            {!! Helper::createButton('DELETE', ['file.delete', $file->id], "Delete", "btn-danger") !!}
          </div>
        </td>
      </tr>

    @endforeach

  </table>
</div>
@endsection
