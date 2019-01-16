{{--this is for tree view menu--}}

@foreach($menuArr[$id] as $val)
    <?php if(isset($menuArr[$val->id])){ $hasChildren = $menuArr[$val->id]; }else {$hasChildren = 0;} ?>

    @if($hasChildren)
        <li>
            <a href=" javascript:void(0)" class="@if($val->parent == 0) has-arrow waves-effect waves-dark @else has-arrow @endif" aria-expanded="false">
                @if($val->icon) <i class="{{$val->icon}}"></i> @endif <span class="hide-menu"> {{$val->name}} </span>
                </span>
            </a>
            <ul aria-expanded="false" class="collapse">
                <?php $id = $val->id; ?>
                {!! view('admin-ancillary.layouts.menu_initiator',compact('currentPath','menuArr','id'))  !!}
            </ul>
        </li>
    @else
        <li class="@if($currentPath == 'admin/'.$val->route) active @endif">
            <a href="@if($val->route != "") {{url('admin/'.$val->route)}} @else javascript:void(0) @endif">
                @if($val->icon) <i class="{{$val->icon}}"></i> @endif <span class="@if($val->parent == 0)hide-menu @endif">{{$val->name}}</span></a>
        </li>
    @endif


@endforeach


