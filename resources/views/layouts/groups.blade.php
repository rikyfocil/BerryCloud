<div class="row">  
  <div class="col-xs-6 col-sm-6 col-md-2 col-md-offset-10">
      <button type="button" class="btn action-button pull-right" data-toggle="modal" data-target="#modal-create">
        Create group
      </button>
  </div>
</div>

<table class="table table-hover">
  <tr>
      <th>Group name</th>
      <th class="text-right">Options</th>
  </tr>
  @foreach ($groups as $group)
      <tr>
          <td><i class="fa fa-users" id="file-icon"></i> <a href="{{route('groups.show', $group->id)}}">{{$group->representativeUser()->first()->name}}</a></td>
          <td>
          <div class="btn-group visible-xs-* hidden-xs hidden-sm pull-right" role="group" aria-label="actionGroup">
              {!! Helper::createButtonWithIcon('DELETE', ['groups.destroy', $group->id], "Delete", "btn btn-default", "glyphicon-trash") !!}
          </div>
          <div class="dropdown pull-right hidden-md hidden-lg">
              <button class="btn btn-default dropdown-toggle" type="button" id="mobileActionId" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                  Actions
                  <span class="caret"></span>
              </button>
              <ul class="dropdown-menu dropdown-menu-right mobileActionId" aria-labelledby="mobileActionId">
                    <li>{{!! Helper::createButtonWithIcon('DELETE', ['groups.destroy', $group->id], "Delete", "btn btn-default", "glyphicon-trash") !!}</li>
              </ul>
          </div>
          </td>
      </tr>

  @endforeach
</table>
