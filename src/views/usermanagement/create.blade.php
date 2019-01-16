<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title" id="myModalLabel"><i class="fa fa-user-plus"></i> Add User</h4>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="form-group col-md-12">

                    <form class="form-horizontal" method="POST" role='form' action="#"
                          onsubmit="javascript:createFormExecution('users',this,null,'PageLoader','title','action','modal_close'); return false;">

                        @include('admin-ancillary.usermanagement.form')

                        <div class="modal-footer">
                            <button type="button" id="modal_close" class="btn btn-danger" data-dismiss="modal">Close
                            </button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- row -->
        </div>
    </div>
</div>
