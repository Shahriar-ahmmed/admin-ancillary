<?php

namespace Ahmmed\AdminAncillary;

use App\Http\Controllers\Controller;
use Ahmmed\AdminAncillary\ResponseMessage;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CommonLib extends Controller {
    private $adminPermission = 'yes'; // For type admin, it will be 'yes' and for client, it becomes 'no'
    private $permissionOptArr = array();
    private $permission = false;
    private $responseMsgInstance = null;
    public $path = null;
    private $errorMsgInstance = null;

    public function __construct()
    {
        $this->errorMsgInstance = new ResponseMessage();
    }

    public function initiateMenu($path){
        $sideMenu = $this->index($path);
        return $sideMenu;

    }

    private function index($path) {
        $data = (Object) [];
        $this->path = $path;
        try {
            $roleId = Auth::user()->user_role;
            $userValidator = DB::table('roles')
                ->where('is_active', '=', 'active')
                ->where('id', '=', $roleId)
                ->where('is_admin', '=', $this->adminPermission)
                ->count();
            if ($userValidator == 0) {
                return (String)view('pages.error.denied');
            }
            $value = $this->makeMenu($roleId);
        }catch(\Exception $e){
            $data->success = false;
            $data->message = $this->responseMsgInstance->exception_msg;
            Log::error($e->getMessage());
        }
        return $value;
    }

    public function makeMenu($id){
        $data = (Object) [];
        try {
            $menuArray = $this->getPermission($id);
            $this->createMenu($menuArray);
            $sideMenu = $this->fetchAdminInitiateMenu($this->permissionOptArr);
            $navigationHTML = $this->getAdminHtmlInitiate($sideMenu, 0);
        }catch(\Exception $e){
            $data->success = false;
            $data->message = $this->responseMsgInstance->exception_msg;
            Log::error($e->getMessage());
        }
        return $navigationHTML;
    }
    private function getPermission($id){

        try {
            $roleId = DB::table('roles')
                ->select('id', 'permission')
                ->where('is_active', '=', 'active')
                ->where('id', '=', $id)
                ->first();
        } catch(\Exception $e){
            Log::error($e->getMessage());
        }
        return json_decode($roleId->permission);
    }

    private function createMenu($object){
        try {
            $flag = false;
            foreach ($object as $obj) {
                if (strpos($obj->id, '_') !== false) {
                    if ($this->getStatus($object)) {
                        return true;
                    } else {
                        return false;
                    }
                } else {
                    $value = $this->createMenu($obj->children);
                    if ($value) {
                        $flag = $value;
                        $this->permissionOptArr[$obj->id] = $obj->id;
                    }
                }
            }
        }catch(\Exception $e){
            Log::error($e->getMessage());
        }
        return $flag;
    }
    private function getStatus($object){
        foreach($object as $o){
            if($o->state->selected){
                return true;
            }
        }
        return false;
    }

    private function fetchAdminInitiateMenu($menuArray){
        $catList = array();
        try {
            $categoryList = DB::table('menus')
                ->select('id', 'name', 'parent', 'c_order', 'route', 'icon')
                ->where('is_active', '=', 'active')
                ->whereIn('id', $menuArray)
                ->orderBy('parent', 'asc')
                ->orderBy('c_order', 'asc')
                ->get();
            if (count($categoryList) > 0) {
                foreach ($categoryList as $list) {
                    if (!isset($catList[$list->parent])) $catList[$list->parent] = array();
                    array_push($catList[$list->parent], $list);
                }
            }
        }catch(\Exception $e){
            Log::error($e->getMessage());
        }
        return $catList;
    }

    private function getAdminHtmlInitiate($menuArr, $id){
        $menu_html="";
        try {
            $currentPath = $this->path;
            if(!isset($menuArr[$id])){
                return '';
            }
            $HTML_MENU = view('admin-ancillary.layouts.menu_initiator',compact('currentPath','menuArr','id'));
            $menu_html .= (String) $HTML_MENU;

        }catch(\Exception $e){
            Log::error($e->getMessage());
        }
        return $menu_html;
    }

    private function getHtml($value, $id){
        $menu_html="";
        if($id != 0) $menu_html .= '<ol class="dd-list">';
        foreach($value as $parent){
            foreach($parent as $val){
                if($val->parent==$id){
                    $menuTrigger = (isset($value[$val->id]))?true:false;
                    $menu_html .= '<li class="dd-item" data-id="'.$val->id.'">';
                    $menu_html .= '<div class="dd-handle">';
                    $menu_html .= $val->name;
                    $menu_html .= '</div>';
                    if($menuTrigger) $menu_html .= $this->getHtml($value,$val->id);
                    $menu_html .= '</li>';
                }
            }
        }
        if($id != 0) $menu_html .= '</ol>';
        return $menu_html;
    }
/*
 * for json menu list in setpermission page
 * */
    public function adminMenuListing()
    {
        $menuList = array();
        $menuList = $this->fetchMenu();

        $navigationHTML = $this->getAdminHtml($menuList,0);
        return $navigationHTML;
    }

    private function fetchMenu(){
        $mList = array();
        $menuList = DB::table('menus')
            ->select('id','name','parent','c_order')
            ->where('is_active','=','active')
            ->orderBy('parent','asc')
            ->orderBy('c_order','asc')
            ->get();
        if(count($menuList)>0) {
            foreach ($menuList as $list) {
                if(!isset($mList[$list->parent])) $mList[$list->parent] = array();
                array_push($mList[$list->parent],$list);
            }
        }
        return $mList;
    }

    private function getAdminHtml($value, $id){
        $menu_html="";
        if($id != 0) $menu_html .= '<ol class="dd-list">';
        foreach($value as $parent){
            foreach($parent as $val){
                if($val->parent==$id){
                    $menuTrigger = (isset($value[$val->id]))?true:false;

                    $menu_html .= '<li class="dd-item" data-id="'.$val->id.'">';
                    $menu_html .= '<div class="dd-handle">';
                    $menu_html .= $val->name;
                    $menu_html .= '</div>';
                    if($menuTrigger) $menu_html .= $this->getAdminHtml($value,$val->id);
                    $menu_html .= '</li>';
                }
            }
        }
        if($id != 0) $menu_html .= '</ol>';
        return $menu_html;
    }

    /*
     * upload single file and checking extension and size limit
     * */
    public function uploadFile($storage_file, $storage_path, $storage_limit)
    {
        $data = (object)[];
        $fileNames = array();
        try {

            $fileExtension = strtolower($storage_file->getClientOriginalExtension());
//            $whitelist = array('csv','txt','xlsx','xlx','pdf', 'ppt', 'xlsx', 'docx','doc','xls); #example of white list for csv file
            $whitelist = array('jpg', 'png', 'gif', 'jpeg'); #example of white list
            if(in_array($fileExtension, $whitelist) && $storage_file->isValid()){
                if (($storage_file->getSize()) <= $storage_limit) {
//                    $file_name = $storage_file->getClientOriginalName();
                    $file_name = time() . '_' . random_int (100000,999999) . '.' . $storage_file->getClientOriginalExtension();
                    $storage_file->move($storage_path, $file_name);

                    array_push($fileNames, $file_name);
                } else {
                    $data->success = false;
                    $data->message = 'File size '.(round($storage_file->getSize()/1048576,2)).'MB exceed the limit '. round($storage_limit/1048576,2).'MB';
                    $data->fileNames = null;
                }
            } else {
                $data->success = false;
                $data->message = 'Invalid Extension';
                $data->fileNames = null;
            }


            if(count($fileNames) > 0)
            {
                $data->success = true;
                $data->message = 'Upload Successful';
                $data->fileNames = $fileNames;
            }

        } catch (\Exception $e) {
            $data->success = false;
            $data->message = 'Sorry! Something Wrong.';
            $data->fileNames = $fileNames;
            Log::error($e->getMessage());
        }
        return $data;
    }

}
