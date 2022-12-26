<div class="form-group">
    <div class="col-sm-12">
        <div class="input-group mb15">
            <span class="input-group-addon"><i class="fa fa-list"></i> Role Name</span>
                <input type="text" class="form-control" name="role_name" required placeholder="Role Name"
                       value="@if($item->role){{$item->role}}@endif">
                <div class="text-danger" id="_role_name"></div>
        </div>

        <div class="input-group mb15">
            <span class="input-group-addon"><i class="fa fa-list"></i> Status</span>
                <select name="role_status" class="form-control">
                        <option @if($item->is_active=="active") selected @endif value="active">Active</option>
                        <option @if($item->is_active=="inactive") selected @endif value="inactive">Inactive</option>
                </select>
            <div class="text-danger" id="_role_status"></div>
        </div>
        <div class="input-group mb15">
            <span class="input-group-addon"><i class="fa fa-list"></i> Admin</span>
                <select name="is_admin" class="form-control">
                        <option @if($item->admin=="yes") selected @endif value="yes">Yes</option>
                        <option  @if($item->admin=="no") selected @endif  value="no">No</option>
                </select>
            <div class="text-danger" id="_is_admin"></div>
        </div>

    </div>
</div><!-- form-group -->