<?php

namespace Ahmmed\AdminAncillary\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Menu extends Eloquent{

    protected $fillable= [
        'name',
        'is_active',
        'created_by',
        'updated_at',
        'updated_by',
        'parent',
        'c_order',
        'route',
        'icon'
    ];


}
