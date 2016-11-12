<table class="table">

    <tr>
      <td> Type </td>
      <td>File name</td>
      <td>Options</td>
    </tr>

    @foreach ($files as $file)

      <tr>
        <td><i class="fa {{$file->isFolder ? "fa-folder-o" : "fa-file"}}"></i></td>
        <td><a href="{{route('file.show', $file->id)}}">{{$file->name}}</a></td>
        <td>
          <div class="col-xs-6">
            {!! Helper::createButton('GET', ['file.download',$file->id], "Download", "btn-success") !!}
          </div>
          @if(Auth::check() && Auth::user()->id == $file->owner)
            <div class="col-xs-6">
              {!! Helper::createButton('DELETE', ['file.delete', $file->id], "Delete", "btn-danger") !!}
            </div>
          @endif
        </td>
      </tr>

    @endforeach

  </table>