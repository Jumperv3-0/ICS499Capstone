<!-- sale -->
<div class="container">
  <ul class="list-group">
    <li class="list-group-item">
      <div class="row">
        <div class="col-sm-5">
          <div class="col-sm-4">
            <div class="collapse-header">Name:</div>
            <div>' . $row[0]->sale_name . '</div>
          </div>
          <div class="col-sm-8">
            <div class="col-sm-6" style="padding-left:0;">
              <div class="collapse-header">Sart Date:</div><div>' . $dates[0] . '
              </div>
            </div>
            <div class="col-sm-6" style="padding-left:0;">
              <div class="collapse-header">End Date:</div>
              <div>' . $dates[$dates_max-1]  . '</div>
            </div>
          </div>
        </div>
        <div class="col-sm-7 text-right">
          <div class="col-sm-3">
            <a class="btn btn-warning form-control" href="?action=edit&amp;gsale_id=' . $row[0]->gsale_id . '">Edit&nbsp;<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
          </div>
          <div class="col-sm-3">
            <a class="btn btn-danger form-control" href="" data-toggle="modal" data-target="#deleteModal' . $row[0]->gsale_id . '">Delete&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span></a>
          </div>
        </div>
      </div>
      <!-- Modal -->
      <div class="modal fade" id="deleteModal' . $row[0]->gsale_id . '" role="dialog">
        <div class="modal-dialog">
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">×</button>
              <h4 class="modal-title"><span class="glyphicon glyphicon-alert" aria-hidden="true"></span>&nbsp;Warning</h4>
            </div>
            <div class="modal-body">
              <p>You are about to delete a sale are you sure you want to do that?</p>
            </div>
            <div class="modal-footer">
              <a type="button" class="btn btn-danger pull-left" href="?action=delete&amp;gsale_id=' . $row[0]->gsale_id . '">Delete Sale</a>
              <a type="button" class="btn btn-default" data-dismiss="modal">Cancel</a>
            </div>
          </div>
        </div>
      </div>
    </li>
    </div>
  </ul>
