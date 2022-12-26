<?php
namespace Ahmmed\AdminAncillary\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Role extends Eloquent{

    protected $fillable= [
        'id',
        'role',
        'is_active',
        'permission',
        'is_admin'
    ];
}