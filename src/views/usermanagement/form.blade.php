<div class="form-group">
    <div class="col-sm-12">

        <div class="input-group mb15">
            <span class="input-group-addon"><i class="fa fa-list"></i> Name</span>
            <input type="text" class="form-control" name="name" required placeholder="Name"
                   value="@if($item->name){{$item->name}}@endif">

            <div class="text-danger" id="_name"></div>
        </div>
        <!-- input-group -->
        <div class="input-group mb15">
            <span class="input-group-addon"><i class="fa fa-list"></i>  Email</span>
            <input type="email" class="form-control" required name="email"
                   placeholder="Email"
                   value="@if($item->email){{$item->email}}@endif">

            <div class="text-danger" id="_email"></div>
        </div>
        <div class="input-group mb15">
            <span class="input-group-addon"><i class="fa fa-list"></i>  Password</span>
            <input type="password" class="form-control" @if(!$item->password) required @endif name="password"
                   placeholder="Password"
                   value="">

            <div class="text-danger" id="_password"></div>
        </div>
        <div class="input-group mb15">
            <span class="input-group-addon"><i class="fa fa-list"></i> Role</span>
            <select id="role" name="user_role" required class="form-control">
                <option  value="">Select Role</option>
                @foreach($roles AS $role)
                    <option @if($role->id == $item->user_role) selected @endif value="{{$role->id}}">{{$role->role}}</option>
                @endforeach
            </select>
        </div>


    </div>
</div>