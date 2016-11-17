<div class="col-sm-12 " id="version-table">
    <div id="version-toggle" onclick="toggleTableVersion()">
        <button class="btn btn-default toggle-button">Versions
            <br>        
            <span class="glyphicon glyphicon-chevron-down" id="version-arrow"></span>
        </button>
    </div>
    <table class="table table-hover">
    <tr id="version-header" >
        <th>Versions of the file</th>
        <th class="text-right">Options</th>
    </tr>
    @foreach ($versions as $version)
        <tr id="version-info">
            <td>{{$version->created_at}}</td>
            <td>
            <div class="btn-group visible-xs-* hidden-xs hidden-sm pull-right" role="group" aria-label="actionGroup">
                {!! Helper::createButtonWithIcon('GET', ['file.version.download',$file->id, $version->id], "Download Version", "btn btn-default", "glyphicon-download-alt") !!}
                @if($file->isOwner() || ( Auth::check() && $file->ensureUserWritePermission(Auth::user()) )) 
                    {!! Helper::createButtonWithIcon('POST', ['file.version.restore', $file->id, $version->id], "Restore this version", "btn btn-default", "glyphicon glyphicon-cloud-upload") !!}
                    @if($file->isOwner())
                        {!! Helper::createButtonWithIcon('DELETE', ['file.version.delete',$file->id, $version->id], "Delete this version", "btn btn-default", "glyphicon-trash") !!}
                    @endif
                @endif
            </div>
            <div class="dropdown pull-right hidden-md hidden-lg">
                <button class="btn btn-default dropdown-toggle" type="button" id="mobileActionId" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    Actions
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu dropdown-menu-right mobileActionId" aria-labelledby="mobileActionId">
                <li>
                    {!! Helper::createButton('GET', ['file.version.download',$file->id, $version->id], "Download Version", "") !!}
                </li>
                @if($file->isOwner() || ( Auth::check() && $file->ensureUserWritePermission(Auth::user()) )) 
                    <li>
                        {!! Helper::createButton('POST', ['file.version.restore', $file->id, $version->id], "Restore this version", "") !!}
                    </li>
                    @if($file->isOwner())
                        <li>
                            {!! Helper::createButton('DELETE', ['file.version.delete',$file->id, $version->id], "Delete this version", "") !!}
                        </li>
                    @endif
                @endif
                </ul>
            </div>
            </td>
        </tr>

    @endforeach
    </table>
</div>

@push('scripts')
<script>
    function onLoadFunctions() {
        $("table").hide();
    }
    function toggleTableVersion() {
        $( "#version-table>table" ).fadeToggle("slow");
        $( "#version-arrow").toggleClass('glyphicon glyphicon-chevron-down').toggleClass('glyphicon glyphicon-chevron-up');
    }

    window.onload = onLoadFunctions;
    </script>
@endpush
