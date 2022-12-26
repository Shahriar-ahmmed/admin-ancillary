<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title" id="myModalLabel"><i class="fa fa-pencil-square-o"></i> Edit Role</h4>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="form-group col-md-12">
                    <form class="form-horizontal" method="POST" role='form' action="#"
                          onsubmit="javascript:updateFormExecution('roles',this,{{$item->id}},null,'PageLoader','title','action','edit_modal_close'); return false;">
                        @csrf()
                        @method('PUT')
                        @include('admin-ancillary.role.form')
                        <div class="modal-footer">
                            <div class="modal-footer">
                                <button type="button" id="edit_modal_close" class="btn btn-danger" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- row -->
        </div>

    </div>
</div>