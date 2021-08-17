<?php

namespace Ahmmed\AdminAncillary\Middleware;

use Ahmmed\AdminAncillary\ResponseMessage;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use Mockery\CountValidator\Exception;


class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    private $adminPermission = 'yes'; // For type admin, it will be 'yes' and for client, it must 'no'
    private $permission = false;
    private $responseMsgInstance = null;
    public function __construct() {
        $this->responseMsgInstance = new ResponseMessage();
    }
    protected $crud = [
        'Create' => 'POST',
        'Read' => 'GET',
        'Update' => 'PUT',
        'Delete' => 'DELETE'
    ];

    public function handle($request, Closure $next)
    {
        $info = [
            'key' => null,
            'route' => null
        ];
        $info['key'] = array_search($request->method(),$this->crud)?:'';
        if(Request::segment(2)=='retrieve')
            $info['route'] = Request::segment(3);
        else
            $info['route'] = Request::segment(2);
        $data = (Object) [];
        try {
            $roleId = Auth::user()->user_role;;
            $rolePermission = $this->getMenu($roleId);
            $menuId = DB::table('menus')
                ->select('id')
                ->where('is_active', '=', 'active')
                ->where('route', '=', $info['route'])
                ->first();
            if(!isset($menuId->id)){
                return response()->view('errors.403', [], 500);
            }
            $this->checkPermission($rolePermission, $menuId->id, $info['key']);
            if ($this->permission) {
                $data->success = $this->permission;
                $data->message = $this->responseMsgInstance->authentication_accept_msg;
            } else {
                $data->success = $this->permission;
                $data->message = $this->responseMsgInstance->authentication_denied_msg;//"You are not authorized to do this action";
            }
        }
        catch(Exception $ex){
            $data->success = false;
            $data->message = $this->responseMsgInstance->exception_msg;
            Log::error($ex->getMessage());
        }
//        dd($this->permission);
        if(!$this->permission){
            return response()->view('errors.403', [], 500);
        }
        return $next($request);
    }

    /*
     * checking the permission with key and route
     * */

    private function checkPermission($permissionObject, $menuId, $key){
        try {
            foreach ($permissionObject as $permission) {
                if ($permission->id == $menuId) {
                    $this->checkCRUD($permission->children, $key);
                } else {
                    if (array_key_exists('children', $permission)) {
                        if ($permission->children != null) {
                            $this->checkPermission($permission->children, $menuId, $key);
                        }
                    }
                }
            }
        }catch(Exception $e){
            Log::error($e->getMessage());
        }
    }
/*
 * check the menu has permission or not
 * */

    private function checkCRUD($crud, $key){
        try {
            foreach ($crud as $c) {
                if ($c->text == $key) {
                    $this->permission = $c->state->selected;
                }
            }
        }catch(Exception $e){
            Log::error($e->getMessage());
        }
    }
/*
 * get the permission of menu according to roles
 * */

    private function getMenu($id){
        try {
            $roleId = DB::table('roles')
                ->select('id', 'permission')
                ->where('is_active', '=', 'active')
                ->where('id', '=', $id)
                ->where('is_admin', '=', $this->adminPermission)
                ->first();
        } catch(Exception $e){
            Log::error($e->getMessage());
        }
        return json_decode($roleId->permission);
    }
}
