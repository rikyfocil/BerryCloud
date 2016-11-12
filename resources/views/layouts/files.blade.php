<table class="table table-hover">
  <tr>
      <th>File name</th>
      <th class="text-right hidden-xs">Last version modified</th>
      <th class="text-right">Options</th>
  </tr>
  @foreach ($files as $file)
      <tr>
          <td><i class="fa {{ $file-> isFolder ? "fa-folder" : "fa-file" }}"></i> <a href="{{route('file.show', $file->id)}}">{{$file->name}}</a></td>
          <td class="text-right hidden-xs">
              {{ $file->currentVersion() }}
          </td>
          <td>
          <div class="btn-group visible-xs-* hidden-xs hidden-sm pull-right" role="group" aria-label="actionGroup">
              {!! Helper::createButtonWithIcon('GET', ['file.download',$file->id], "Download", "btn btn-default", "glyphicon-download-alt") !!}
              {!! Helper::createButtonWithIcon('DELETE', ['file.delete', $file->id], "Delete", "btn btn-default", "glyphicon-trash") !!}
          </div>
          <div class="dropdown pull-right hidden-md hidden-lg">
              <button class="btn btn-default dropdown-toggle" type="button" id="mobileActionId" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                  Actions
                  <span class="caret"></span>
              </button>
              <ul class="dropdown-menu dropdown-menu-right mobileActionId" aria-labelledby="mobileActionId">
                  <li>{!! Helper::createButton('GET', ['file.download',$file->id], "Download", "") !!}</li>
                  @if(Auth::check() && Auth::user()->id == $file->owner)
                   <li>{!! Helper::createButton('DELETE', ['file.delete', $file->id], "Delete", "") !!}</li>
                  @endif
              </ul>
          </div>
          </td>
      </tr>

  @endforeach
</table>