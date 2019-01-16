<?php

/**
 * Created by PhpStorm.
 * User: Shahriar Ahmmed
 * Date: 5/18/2016
 * Time: 4:49 PM
 */

namespace Ahmmed\AdminAncillary\Controllers;

use Ahmmed\AdminAncillary\models\Menu;
use App\Http\Controllers\Controller;
use Ahmmed\AdminAncillary\FormValidation;
use Ahmmed\AdminAncillary\ResponseMessage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request as HTTPREQUEST;
use DB;
use Mockery\CountValidator\Exception;

class MenuController extends Controller
{

    private $responseMsgInstance = null;
    private $formValInstance = null;
    private $setPermInstance = null;

    public function __construct()
    {
        $this->responseMsgInstance = new ResponseMessage();
        $this->formValInstance = new FormValidation();
        $this->setPermInstance = new SetPermissionController();
    }

    private $rules = [
        'name' => 'required'
    ];

    public function index()
    {
        return view('admin-ancillary.menu.index');
    }

    /**
     * Retrieve Data
     * From Database And
     * Show With View Page
     */
    public function retrieveData()
    {
        $data = (Object)[];
        $rows = [];
        try {
            $menulist = Menu::orderBy('id','DESC')->get();
            foreach ($menulist as $sl => $menu) {
                $rows[] = array(
                    $sl + 1, // SL
                    $menu->name,
                    $menu->is_active,
                    '<a data-toggle="modal" data-target="#form_modal"  onclick="javascript:editFormInitializer(\'menus\',' . $menu->id . ',\'form_modal\', \'null\',\'null\');"><i class="fa fa-pencil-square-o"></i></a>',
                    '<a onclick="javascript:deleteItemExecution(\'menus\',' .  $menu->id . ',\'PageLoader\',\'title\',\'action\');"><i class="fa fa-trash-o"></a>'
                );
            }
            $data->columns = array(
                array("title" => "SL", "class" => "text-center"),
                array("title" => "Name", "class" => "text-center"),
                array("title" => "Status", "class" => "text-center"),
                array("title" => "Edit", "class" => "text-center noExport"),
                array("title" => "Delete", "class" => "text-center noExport")
            );
            $data->rows = $rows;
            $data->createAction = '<a class="btn btn-danger btn-metro" data-toggle="modal"
                            data-target="#form_modal" href="#" onclick="javascript:createFormInitializer(\'menus\',\'form_modal\', \'null\', \'null\');"><i class="fa fa-plus"></i> Add Menu</a>';
            $data->title = '<b>Menu Info Management</b>';
            $data->success = true;
        } catch (\Exception $e) {
            $data->success = false;
            $data->message = $this->responseMsgInstance->exception_msg;
            Log::error($e->getMessage());
        }
        return view('admin-ancillary.convertToJson', compact('data'));
    }

    /**
     *
     * For calling create form
     */
    public function create()
    {

        $data = (Object)[];
        try {
            if (Auth::check())
                $userId = Auth::user()->id;
            $item = new Menu();
            $dataString = view('admin-ancillary.menu.create', compact('userId', 'item'));
            $data->b_template = (string)$dataString;
            $data->success = true;
            $data->success = true;
        } catch (\Exception $e) {
            $data->success = false;
            $data->message = $this->responseMsgInstance->exception_msg;
            Log::error($e->getMessage());
        }
        return view('admin-ancillary.convertToJson', compact('data'));
    }

    /**
     * For executing add content
     * @param HTTPREQUEST $request
     * @return type
     */
    public function store(HTTPREQUEST $request)
    {
        $data = (Object)[];
        try {
            $receiveData = $request->all();
            $data = $this->formValInstance->formValidate($receiveData, $this->rules);
            if ($data->success == 'true') {
                if (Auth::check())
                    $userId = Auth::user()->id;
                try {
                    $receiveData['created_by'] = $userId;
                    if (Menu::create($receiveData)) {
                        $this->setPermInstance->updatePermission();
                        $data->success = TRUE;
                        $data->message = $this->responseMsgInstance->create_success_msg;
                    } else {
                        $data->success = false;
                        $data->message = $this->responseMsgInstance->create_failed_msg;
                    }
                } catch (Exception $ex) {
                    $data->success = FALSE;
                    $data->message = $this->responseMsgInstance->exception_msg;
                    Log::error($ex->getMessage());
                }
            }
        } catch (\Exception $e) {
            $data->success = false;
            $data->message = $this->responseMsgInstance->exception_msg;
            Log::error($e->getMessage());
        }
        return view('admin-ancillary.convertToJson', compact('data'));
    }

    /**
     * Edit View Page Call
     */
    public function edit($id)
    {
        $data = (Object)[];
        try {
            $item = Menu::find($id);
            if ($item) {
                if (Auth::check())
                    $userId = Auth::user()->id;

                $dataString = view('admin-ancillary.menu.edit', compact('userId', 'id', 'item'));
                $data->b_template = (string)$dataString;
                $data->success = true;
                $data->title = 'Change Menu Information';
                $data->viewAction = '<a class="btn btn-wide btn-danger" href="#" onclick="javascript:listInitializer(\'menus\',{key: \'Edit\', route: \'menus\'},\'PageLoader\', \'title\', \'action\');"><i class="glyphicon glyphicon-list-alt"></i> Show List</a>';

            } else {
                $data->success = false;
                $data->message = $this->responseMsgInstance->edit_failed_msg;
            }

        } catch (\Exception $e) {
            $data->success = false;
            $data->message = $this->responseMsgInstance->exception_msg;
            Log::error($e->getMessage());
        }

        return view('admin-ancillary.convertToJson', compact('data'));
    }

    /**
     * Update functionality
     */
    public function update($id, HTTPREQUEST $request)
    {
        $data = (Object)[];
        try {
            $receiveData = $request->all();
            $data = $this->formValInstance->formValidate($receiveData, $this->rules);
            if ($data->success == 'true') {
                $item = Menu::find($id);
                if ($item) {
                    if (Auth::check())
                        $userId = Auth::user()->id;
                    try {
                        $receiveData['updated_by'] = $userId;
                        if ($item->fill($receiveData)->update()) {
                            $this->setPermInstance->updatePermission();
                            $data->success = TRUE;
                            $data->message = $this->responseMsgInstance->update_success_msg;
                        } else {
                            $data->success = false;
                            $data->message = $this->responseMsgInstance->update_failed_msg;
                        }

                    } catch (Exception $ex) {
                        $data->success = FALSE;
                        $data->message = $this->responseMsgInstance->exception_msg;
                        Log::error($ex->getMessage());
                    }
                } else {
                    $data->success = false;
                    $data->message = $this->responseMsgInstance->update_failed_msg;
                }
            }
        } catch (\Exception $e) {
            $data->success = false;
            $data->message = $this->responseMsgInstance->exception_msg;
            Log::error($e->getMessage());
        }
        return view('admin-ancillary.convertToJson', compact('data'));
    }

    public function destroy($id)
    {
        $data = (Object)[];
        try {
            $item = Menu::find($id);
            if ($item) {
                try {
                    $item->delete();
                    $this->setPermInstance->updatePermission();
                    $data->success = TRUE;
                    $data->message = $this->responseMsgInstance->delete_success_msg;
                } catch (Exception $ex) {
                    $data->success = FALSE;
                    $data->message = $this->responseMsgInstance->exception_msg;
                    Log::error($ex->getMessage());
                }
            } else {
                $data->success = FALSE;
                $data->message = $this->responseMsgInstance->delete_failed_msg;
            }
        } catch (\Exception $e) {
            $data->success = false;
            $data->message = $this->responseMsgInstance->exception_msg;
            Log::error($e->getMessage());
        }

        return view('admin-ancillary.convertToJson', compact('data'));
    }

}