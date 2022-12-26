<div class="form-group">
    <div class="col-sm-12">

        <div class="input-group mb15">
            <span class="input-group-addon"><i class="fa fa-list"></i> Menu Name</span>
            <input type="text" class="form-control" required value="@if($item->name){{$item->name}}@endif" name="name"
                   placeholder="Menu Name">

            <div class="text-danger" id="_name"></div>
        </div>
        <!-- input-group -->


        <div class="input-group mb15">
            <span class="input-group-addon"><i class="fa fa-list"></i>  Route</span>
            <input type="text" class="form-control" value="@if($item->route){{$item->route}}@endif" name="route"
                   placeholder="e.g. MenuAdmin">

            <div class="text-danger" id="_route"></div>
        </div>
        <!-- input-group -->

        <div class="input-group mb15">
            <span class="input-group-addon"><i class="fa fa-list"></i>  Icon</span>
            <input type="text" class="form-control" value="@if($item->icon){{$item->icon}}@endif" name="icon"
                   placeholder="e.g. ti-package">
        </div>
        <!-- input-group -->

        <div class="input-group mb15">
            <span class="input-group-addon"><i class="fa fa-list"></i>  Status</span>
            <select name="is_active" class="form-control" required>
                <option value="active" @if($item->is_active == 'active') selected="selected" @endif >Active</option>
                <option value="inactive" @if($item->is_active == 'inactive') selected="selected" @endif >Inactive
                </option>
            </select>

            <div class="text-danger" id="_is_active"></div>
        </div>
        <!-- input-group -->


    </div>
</div>  <!-- form-group -->