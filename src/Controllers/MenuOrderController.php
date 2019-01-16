<?php

namespace Ahmmed\AdminAncillary\Controllers;

use Ahmmed\AdminAncillary\models\Role;
use Ahmmed\AdminAncillary\ResponseMessage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use DB;
use Illuminate\Support\Facades\Auth;
use Mockery\CountValidator\Exception;

class MenuOrderController extends Controller
{
    private $responseMsgInstance = null;
    private $setPermInstance = null;

    public function __construct()
    {
        $this->responseMsgInstance = new ResponseMessage();
        $this->setPermInstance = new SetPermissionController();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin-ancillary.menuorder.index');
    }

    private function menuList($parent){
        $menuList = DB::table('menus')
            ->select('*')
            ->where('is_active', 'active')
            ->where('parent', $parent)
            ->orderBy('id','asc');

        if($menuList->count() > 0 )
            return $menuList->get();

        return 0;
    }

    private function menuDataLoop($menuList){
        $responseArr = array();
        $data = array();
        foreach($menuList as $menuDetails){
            $data['id'] = $menuDetails->id;
            $data['text'] = $menuDetails->name;
            $data['state'] = array('selected' => true);
            $data['icon'] = "fa fa-folder text-primary fa-lg";
            $data['children'] = $this->getSubMenu($menuDetails->id);
            array_push($responseArr,$data);
        }

        return $responseArr;
    }

    private function getSubMenu($parent)
    {
        $responseArr = array();
        $menuList = $this->menuList($parent);
        if($menuList == 0){
            $bottomChildCount = 1;
            $d = array();
            $d['state'] = array('selected' => true);
            $d['icon'] = 'fa fa-key text-primary fa-xs';
            $d['children'] = null;
            $d['id'] = 'j'.$parent.'_'.$bottomChildCount;
            $d['text'] = 'Create';
            array_push($responseArr, $d);
            $d['id'] = 'j'.$parent.'_'.($bottomChildCount+1);
            $d['text'] = 'Read';
            array_push($responseArr, $d);
            $d['id'] = 'j'.$parent.'_'.($bottomChildCount+2);
            $d['text'] = 'Update';
            array_push($responseArr, $d);
            $d['id'] = 'j'.$parent.'_'.($bottomChildCount+3);
            $d['text'] = 'Delete';
            array_push($responseArr, $d);
        } else {
            $responseArr = $this->menuDataLoop($menuList);
        }

        return $responseArr;
    }

    /*
     * update the menu order
     * */

    public function updateOrder(Request $request)
    {
        $data = (Object)[];
        try {
            $value = json_decode($request->getContent(), true);
            $roleID = Auth::user()->user_role;
            if ($roleID == 1) {
                $result = $this->sortAndUpdateMenu(0, $value);
                $updatePerm = $this->setPermInstance->updatePermission();
                if ($result && $updatePerm) {
                    $data->success = TRUE;
                    $data->message = $this->responseMsgInstance->menu_order_success_msg;
                }
            } else {
                $data->success = false;
                $data->message = $this->responseMsgInstance->authentication_denied_msg;
            }
        } catch (Exception $ex) {
            $data->success = false;
            $data->message = $this->responseMsgInstance->menu_order_fail_msg;
            Log::error($ex->getMessage());
        }

        return json_encode($data);
    }

    private function sortAndUpdateMenu($par, $value)
    {
        try {
            for ($i = 0; $i < count($value); $i++) {
                $update = ['parent' => $par, 'c_order' => $i + 1];
                $id = $value[$i]['id'];
                if (array_key_exists('children', $value[$i])) {
                    $child = $value[$i]['children'];
                    $this->sortAndUpdateMenu($id, $child);
                }
                DB::table('menus')->where('id', $id)->update($update);
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
        return true;
    }

}
