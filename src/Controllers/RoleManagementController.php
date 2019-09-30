<?php


namespace Ahmmed\AdminAncillary\Controllers;

use Ahmmed\AdminAncillary\FormValidation;
use Ahmmed\AdminAncillary\Models\Role;
use Ahmmed\AdminAncillary\ResponseMessage;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request as HTTPREQUEST;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Mockery\CountValidator\Exception;

class RoleManagementController extends Controller{

    private $responseMsgInstance = null;
    private $formValInstance = null;

    public function __construct() {
        $this->responseMsgInstance = new ResponseMessage();
        $this->formValInstance = new FormValidation();
    }
    private $rules = [
        'role_name' => 'required',
    ];

    public function index() {
        return view('admin-ancillary.role.index');
    }


    /**
     * Retrieve Data
     * From Database And
     * Show With View Page
     */
    public function retrieveData() {
        $data = (Object) [];
        $rows = [];
        try {

            $roleList = Role::OrderBy('id','asc')
                ->where('id','>',Auth::user()->id)
                ->get();
            foreach ($roleList as $sl => $role) {

                $rows[] = array(
                    $role->role,
                    $role->is_active,
                    $role->is_admin,
                    '<a data-toggle="modal" data-target="#form_modal" onclick="javascript:editFormInitializer(\'roles\',' . $role->id . ',\'form_modal\', \'null\',\'null\');"><i class="fa fa-pencil-square-o"></a>',
                    '<a onclick="javascript:deleteItemExecution(\'roles\',' . $role->id . ',\'PageLoader\',\'title\',\'action\');"><i class="fa fa-trash-o"></a>'
                );
            }
            $data->columns = array(
                array("title" => "Role", "class" => "text-center"),
                array("title" => "Status", "class" => "text-center"),
                array("title" => "Admin", "class" => "text-center"),
                array("title" => "Edit", "class" => "text-center noExport"),
                array("title" => "Delete", "class" => "text-center noExport")
            );
            $data->rows = $rows;
            $data->createAction = '<a class="btn btn-danger btn-metro" data-toggle="modal" data-target="#form_modal" href="#" onclick="javascript:createFormInitializer(\'roles\',\'form_modal\',\'null\',\'null\');"><i class="fa fa-plus"> Add roles</a>';
            $data->title = '<b>Role Management</b>';
            $data->success = true;
        }catch(\Exception $e){
            $data->success = FALSE;
            $data->message = $this->responseMsgInstance->exception_msg;
            Log::error($e->getMessage());
        }
        return view('admin-ancillary.convertToJson', compact('data'));
    }

    /**
     *
     * For calling create form
     */
    public function create() {

        $data = (Object) [];
        try {
            if (Auth::check())
                $userId = Auth::user()->id;
            $item = new Role();
            $dataString = view('admin-ancillary.role.create', compact('userId', 'item'));
            $data->b_template = (string)$dataString;
            $data->success = true;
        }catch(\Exception $e){
            $data->success = FALSE;
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
    public function store(HTTPREQUEST $request) {
        $data = (Object) [];
        $receiveData = $request->all();
        try {
            $data = $this->formValInstance->formValidate($receiveData,$this->rules);
            if($data->success == 'true') {
                if (Auth::check())
                    $userId = Auth::user()->id;

                try {
                    $receiveData = $request->all();
                    $role = array();
                    $role['role'] = $receiveData['role_name'];
                    $role['is_active'] = $receiveData['role_status'];
                    $role['is_admin'] = $receiveData['is_admin'];
                    if (Role::create($role)) {
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
        }catch(\Exception $e){
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
            $item = Role::find($id);
            if ($item) {
                if (Auth::check())
                    $userId = Auth::user()->id;
                $dataString = view('admin-ancillary.role.edit', compact('userId', 'item'));
                $data->b_template = (string)$dataString;
                $data->success = true;
            } else {
                $data->success = false;
                $data->message =  $this->responseMsgInstance->edit_failed_msg;
            }
        }catch(\Exception $e){
            $data->success = FALSE;
            $data->message = $this->responseMsgInstance->exception_msg;
            Log::error($e->getMessage());
        }
        return view('admin-ancillary.convertToJson', compact('data'));
    }


    /**
     * Update functionality
     */
    public function update($id, HTTPREQUEST $request) {
        $data = (Object) [];
        $receiveData = $request->all();
        try {
            $data = $this->formValInstance->formValidate($receiveData,$this->rules);
            if($data->success == 'true') {
                $role = Role::find($id);
                $userId = Auth::user()->id;
                try {
                    $roleInfo = array();
                    $roleInfo['role'] = $receiveData['role_name'];
                    $roleInfo['is_active'] = $receiveData['role_status'];
                    $roleInfo['is_admin'] = $receiveData['is_admin'];
                    $role->fill($roleInfo)->update();
                    $data->success = TRUE;
                    $data->message =  $this->responseMsgInstance->update_success_msg;
                } catch (Exception $ex) {
                    $data->success = FALSE;
                    $data->message =  $this->responseMsgInstance->update_failed_msg;
                    Log::error($ex->getMessage());
                }
            }
        }catch(\Exception $e){
            $data->success = FALSE;
            $data->message = $this->responseMsgInstance->exception_msg;
            Log::error($e->getMessage());
        }
        return view('admin-ancillary.convertToJson', compact('data'));
    }

    /*
     * Delete Operation
     */

    public function destroy($id)
    {
        $data = (Object)[];
        try {
            $role = Role::find($id);
            if ($role) {
                try {
                    $role->delete();
                    $data->success = TRUE;
                    $data->message = $this->responseMsgInstance->delete_success_msg;
                } catch (\Exception $ex) {
                    $data->success = FALSE;
                    $data->message = $this->responseMsgInstance->delete_failed_msg;
                    Log::error($ex);
                }
            } else {
                $data->success = FALSE;
                $data->message = $this->responseMsgInstance->delete_failed_msg;
            }
        } catch (\Exception $e) {
            $data->success = FALSE;
            $data->message = $this->responseMsgInstance->exception_msg;
            Log::error($e);
        }
        return view('admin-ancillary.convertToJson', compact('data'));
    }
}
