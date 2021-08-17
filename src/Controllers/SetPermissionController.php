<?php


namespace Ahmmed\AdminAncillary\Controllers;

use Ahmmed\AdminAncillary\Models\Role;
use Ahmmed\AdminAncillary\ResponseMessage;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request as HTTPREQUEST;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Mockery\CountValidator\Exception;

class SetPermissionController extends Controller
{
    private $responseMsgInstance = null;
    public function __construct()
    {
        $this->responseMsgInstance = new ResponseMessage();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            if (Auth::check())
                $userId = Auth::user()->id;
            $roles = Role::where('id','>',Auth::user()->id)
                    ->where('is_admin','yes')
                    ->get();
            $response = array();
            $response['plugins'] = array("wholerow", "checkbox", "types");
            $response['core'] = array(
                'themes' => array('responsive' => true),
                'data' => array(array(
                    'text' => 'Dashboard',
                    'state' => array(
                        'selected' => true
                    )
                )
                )
            );
            $response['types'] = array(
                'default' => array(
                    'icon' => 'fa fa-folder text-danger fa-lg'
                ),
                'file' => array(
                    'icon' => 'fa fa-file text-danger fa-lg'
                )
            );
            $dataString = view('admin-ancillary.convertToJson', compact('response'));
            $resp = $dataString->getData()['response'];
            $data = json_encode($resp);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
        return view('admin-ancillary.setpermission.index', compact('roles', 'data'));
    }

/*
 * get the structure of the tree of menu
 * */

    public function getMenuJson()
    {
        $response = array();
        $response['plugins'] = array("wholerow", "changed", "checkbox", "types");
        $response['core'] = array(
            'themes' => array('responsive' => true),
            'data' => $this->createJSONData()
        );
        $response['types'] = array(
            'default' => array(
                'icon' => 'fa fa-folder text-danger fa-lg'
            ),
            'file' => array(
                'icon' => 'fa fa-file text-danger fa-lg'
            )
        );
        $dataString = view('admin-ancillary.convertToJson', compact('response'));
        $resp = $dataString->getData()['response'];
        $data = json_encode($resp);
        return $data;
    }

/*
 * get the role wise permission
 * */
    public function getPermission($id)
    {
        try {
            $roleID = $id;
            $permissionJSON = "";
            if ($roleID != 0) {
                $permission = DB::table('roles')
                    ->select( 'permission')
                    ->where('is_active', 'active')
                    ->where('id', $roleID)
                    ->first();
                if ($permission->permission == "") {
                    $permissionMain = DB::table('roles')
                        ->select('roles.id', 'roles.permission')
                        ->where('is_active', 'active')
                        ->where('id', 1)
                        ->get();
                    $permissionJSON = $this->initaitePermissionForNewRole(json_decode('[' . $permissionMain[0]->permission . ']'), true, false);
                } else {
                    $value = '[' . $permission->permission . ']';
                    $permissionJSON = $this->makeTempArray(json_decode($value), true);
                }
            }
            $response = array();
            $response['plugins'] = array("wholerow", "changed", "checkbox", "types");
            $response['core'] = array(
                'themes' => array('responsive' => true),
                'data' => $permissionJSON
            );
            $response['types'] = array(
                'default' => array(
                    'icon' => 'fa fa-folder text-danger fa-lg'
                ),
                'file' => array(
                    'icon' => 'fa fa-file text-danger fa-lg'
                )
            );
            $dataString = view('admin-ancillary.convertToJson', compact('response'));
            $resp = $dataString->getData()['response'];
            $data = json_encode($resp);
            return $data;
        } catch (\ErrorException $e) {
            Log::error($e->getMessage());
        }
    }

    public function createJSONData()
    {
        $sideMenu = $this->getMenu();
        $resp = $this->makeJSONArray(array(), $sideMenu, 0);
        return $resp;
    }

    public function getMenu()
    {
        $catList = array();
        try {
            $catList = $this->fetchMenu();
        }catch(\Exception $e){
            Log::error($e->getMessage());
        }
        return $catList;
    }

    public function fetchMenu()
    {
        $catList = array();
        try {
            $categoryList = DB::table('menus')
                ->select('id', 'name', 'parent', 'c_order', 'route', 'icon')
                ->where('is_active', '=', 'active')
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

    private function makeJSONArray($resp, $value, $id)
    {
        foreach ($value as $parent) {
            foreach ($parent as $val) {
                if ($val->parent == $id) {
                    $data = array();
                    $data['id'] = $val->id;
                    $data['text'] = $val->name;
                    $data['state'] = array('selected' => false);
                    $menuTrigger = (isset($value[$val->id])) ? true : false;
                    if ($menuTrigger) {
                        $data['children'] = $this->makeJSONArray(array(), $value, $val->id);
                    } else {
                        $child = array(
                            array(
                                'name' => 'Create',
                                'flag' => false,
                            ),
                            array(
                                'name' => 'Read',
                                'flag' => false,
                            ),
                            array(
                                'name' => 'Update',
                                'flag' => false,
                            ),
                            array(
                                'name' => 'Delete',
                                'flag' => false,
                            )
                        );
                        $data['children'] = $this->getCRUD($child);

                    }
                    array_push($resp, $data);
                }
            }
        }
        return $resp;
    }

    private function getCRUD($array)
    {
        $resp = array();
        foreach ($array as $a) {
            $d = array();
            $d['text'] = $a['name'];
            $d['state'] = array('selected' => $a['flag']);
            $d['icon'] = 'fa fa-key text-danger fa-xs';
            array_push($resp, $d);
        }
        return $resp;
    }

    public function savePermission(HTTPREQUEST $permission)
    {
        $data = (Object)[];
        try {
            $datajson = $permission->all();
            $myvalue = json_decode($datajson['value']);
            $role = $datajson['role'];
            $permsn = $this->makePermissionArray($myvalue);
            $roleobj = Role::find($role);
            try {
                $roleinfo = array();
                $roleinfo['permission'] = $permsn;
                $roleobj->fill($roleinfo)->update();
                $data->success = TRUE;
                $data->message = $this->responseMsgInstance->permission_success_msg;
            } catch (Exception $ex) {
                $data->success = FALSE;
                $data->message = $this->responseMsgInstance->exception_msg;
                Log::error($ex->getMessage());
            }
        }catch(\Exception $e){
            $data->success = false;
            $data->message = $this->responseMsgInstance->exception_msg;
            Log::error($e->getMessage());
        }
        return view('admin-ancillary.convertToJson', compact('data'));
    }

    /*
     * update the permission according to menu
     * */

    public function updatePermission()
    {
        $permArray = array();
        $menuArray = array();
        $currentUserRole = Auth::user()->user_role;
        $roleList = DB::table('roles')->select('id','permission')->get();
        try {
            $menuArray = $this->fetchMenu();
            foreach($roleList as $role){
                $roleID = $role->id;
                $permission = trim($role->permission);
                if ($roleID == 1 || $permission=="") {
                    $trigger = true;
                    $resp = (object)$this->setPermSuperAdmin(array(), $menuArray, 0, $trigger);
                    $permArray = json_encode($resp);
                    $roleobj = Role::find($roleID);
                    $roleinfo = array();
                    $roleinfo['permission'] = $permArray;
                    $roleobj->fill($roleinfo)->update();

                }else{
                    $currentPermissionArr = $this->permissionArrRedefine($permission);
                    $resp = (object)$this->setPerm(array(), $menuArray, 0, $currentPermissionArr);
                    $permArray = json_encode($resp);
                    $roleobj = Role::find($roleID);

                    $roleinfo = array();
                    $roleinfo['permission'] = $permArray;
                    $roleobj->fill($roleinfo)->update();
                }
            }

        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }

        return true;
    }

    private function permissionArrRedefine($permissionJson){
        $permissionArr = array();
        $currentPermissionArr = json_decode($permissionJson);
        $permissionArr = $this->permissionFlagIdentifier($currentPermissionArr,$permissionArr);
        return $permissionArr;
    }

    private function permissionFlagIdentifier($currentPermissionArr,$permissionArr){
        foreach($currentPermissionArr as $parentMenu){
            $permissionArr[$parentMenu->id] = $parentMenu->state->selected;
            if($parentMenu->children != null) $permissionArr = $this->permissionFlagIdentifier($parentMenu->children,$permissionArr);
        }

        return $permissionArr;
    }

    private function makePermissionArray($value)
    {
        $resp = array();
        for ($i = 0; $i < count($value); $i++) {
            if ($value[$i]->parent == '#') {
                $val = $value[$i];
                $resp[$val->id]['id'] = $val->id;
                $resp[$val->id]['text'] = $val->text;
                $resp[$val->id]['state'] = array('selected' => $val->state->selected);
                $resp[$val->id]['icon'] = $val->icon;
                $resp[$val->id]['children'] = $this->getChild($val->id, $value);
            }
        }
        return json_encode($resp);
    }


    private function getChild($pid, $value)
    {
        $result = array();
        foreach ($value as $val) {
            if ($val->parent == $pid) {
                $data = array();
                $data['id'] = $val->id;
                $data['text'] = $val->text;
                $data['icon'] = $val->icon;
                $data['state'] = array('selected' => $val->state->selected);
                if (strpos($val->id, '_') !== false) {
                    $data['children'] = null;
                }else{
                    $data['children'] = $this->getChild($val->id, $value);
                }
                array_push($result, $data);
            }
        }
        return $result;
    }

    private function initaitePermissionForNewRole($value, $flag, $key){
        $response = array();
        if($flag)
            $value = $value[0];
        foreach($value as $parent){
            $data = array();
            $data['id'] = $parent->id;
            $data['text'] = $parent->text;
            $data['state'] = array('selected'=>$key);
            if(array_key_exists('children', $parent)) {
                if ($parent->children != null) {
                    $data['children'] = $this->initaitePermissionForNewRole($parent->children, false, $key);
                }
            }
            array_push($response,$data);
        }
        return $response;
    }

    public function makeTempArray($value, $flag)
    {
        $response = array();
        try {
            if ($flag)
                $value = $value[0];
            foreach ($value as $parent) {
                $data = array();
                $data['id'] = $parent->id;
                $data['text'] = $parent->text;
                $data['state'] = array('selected' => $parent->state->selected);
                if (array_key_exists('children', $parent)) {
                    if ($parent->children != null) {
                        $data['children'] = $this->makeTempArray($parent->children, false);
                    }
                }
                array_push($response, $data);
            }
        }catch(\Exception $e){
            Log::error($e->getMessage());
        }
        return $response;
    }

    private function setPerm($resp, $value, $id, $currentPermissionArr)
    {
        foreach ($value as $parent) {
            foreach ($parent as $val) {

                if ($val->parent == $id) {
                    $data = array();
                    $data['id'] = $val->id;
                    $data['text'] = $val->name;
                    $data['state'] = array('selected' => (isset($currentPermissionArr[$val->id]))?$currentPermissionArr[$val->id]:false);
                    $menuTrigger = (isset($value[$val->id])) ? true : false;
                    if ($menuTrigger) {
                        $data['children'] = $this->setPerm(array(), $value, $val->id, $currentPermissionArr);
                    } else {
                        $child = array(
                            array(
                                'name' => 'Create',
                                'flag' => (isset($currentPermissionArr['j'.$val->id.'_0']))?$currentPermissionArr['j'.$val->id.'_0']:false,
                            ),
                            array(
                                'name' => 'Read',
                                'flag' => (isset($currentPermissionArr['j'.$val->id.'_1']))?$currentPermissionArr['j'.$val->id.'_1']:false,
                            ),
                            array(
                                'name' => 'Update',
                                'flag' => (isset($currentPermissionArr['j'.$val->id.'_2']))?$currentPermissionArr['j'.$val->id.'_2']:false,
                            ),
                            array(
                                'name' => 'Delete',
                                'flag' => (isset($currentPermissionArr['j'.$val->id.'_3']))?$currentPermissionArr['j'.$val->id.'_3']:false,
                            )
                        );
                        $data['children'] = $this->CRUD($child,$val->id);
                    }
                    array_push($resp, $data);
                }
            }
        }
        return $resp;
    }

    private function setPermSuperAdmin($resp, $value, $id, $trigger = true)
    {
        foreach ($value as $parent) {
            foreach ($parent as $val) {

                if ($val->parent == $id) {
                    $data = array();
                    $data['id'] = $val->id;
                    $data['text'] = $val->name;
                    $data['state'] = array('selected' => $trigger);
                    $menuTrigger = (isset($value[$val->id])) ? true : false;
                    if ($menuTrigger) {
                        $data['children'] = $this->setPermSuperAdmin(array(), $value, $val->id, $trigger);
                    } else {
                        $child = array(
                            array(
                                'name' => 'Create',
                                'flag' => $trigger,
                            ),
                            array(
                                'name' => 'Read',
                                'flag' => $trigger,
                            ),
                            array(
                                'name' => 'Update',
                                'flag' => $trigger,
                            ),
                            array(
                                'name' => 'Delete',
                                'flag' => $trigger,
                            )
                        );
                        $data['children'] = $this->CRUD($child,$val->id);
                    }
                    array_push($resp, $data);
                }
            }
        }
        return $resp;
    }

    private function CRUD($array,$parent)
    {
        $resp = array();
        foreach ($array as $bottomChildCount=>$a) {
            $d = array();
            $d['id'] = 'j'.$parent.'_'.$bottomChildCount;
            $d['text'] = $a['name'];
            $d['state'] = array('selected' => $a['flag']);
            $d['icon'] = 'fa fa-key text-danger fa-xs';
            $d['children'] = null;
            array_push($resp, $d);
        }

        return $resp;

    }


}