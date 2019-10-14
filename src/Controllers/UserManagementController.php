<?php

namespace Ahmmed\AdminAncillary\Controllers;


use Ahmmed\AdminAncillary\FormValidation;
use Ahmmed\AdminAncillary\ResponseMessage;
use App\User;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request as HTTPREQUEST;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Mockery\CountValidator\Exception;


class UserManagementController extends Controller
{

    private $responseMsgInstance = null;
    private $formValInstance = null;

    public function __construct()
    {
//        $this->middleware('auth');
        $this->responseMsgInstance = new ResponseMessage();
        $this->formValInstance = new FormValidation();
    }

    protected $rules = [
        'name' => 'required',
        'email' => 'required|unique:users',
        'password' => 'required|min:6',
    ];

    public function index()
    {
        return view('admin-ancillary.usermanagement.index');
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

            $userlist = DB::table('users')
                ->join('roles', 'roles.id', '=', 'users.user_role')
                ->select('users.*', 'roles.role')
                ->where('users.id', '!=', Auth::user()->id)
                ->where('users.user_role', '>', Auth::user()->user_role)
                ->orderBy('users.id', 'desc')
                ->get();
//        dd($userlist);
            foreach ($userlist as $sl => $user) {

                $rows[] = array(
                    $user->name,
                    $user->email,
                    $user->role,
//                    '<a onclick="javascript:sendMail(\'sendmail\',' . $user->id . ');"><i class="fa fa-envelope"></i></a>',
                    '<a data-toggle="modal" data-target="#form_modal" onclick="javascript:editFormInitializer(\'users\',' . $user->id . ',\'form_modal\', \'null\',\'null\');"><i class="fa fa-pencil-square-o"></i></a>',
                    '<a onclick="javascript:deleteItemExecution(\'users\',' . $user->id . ', \'PageLoader\',\'title\',\'action\');"><i class="fa fa-trash-o"></i></a>'
                );
            }
            $data->columns = array(
                array("title" => "Full Name", "class" => "text-center"),
                array("title" => "Email", "class" => "text-center"),
                array("title" => "Role", "class" => "text-center"),
//                array("title" => "Send Password to Mail", "class" => "text-center"),
                array("title" => "Edit", "class" => "text-center noExport"),
                array("title" => "Delete", "class" => "text-center noExport")
            );
            $data->rows = $rows;
            $data->createAction = '<a class="btn btn-danger btn-metro" data-toggle="modal"    data-target="#form_modal" href="#" onclick="javascript:createFormInitializer(\'users\',\'form_modal\', \'null\', \'null\');"><i class="fa fa-plus"></i> Add User</a>';
            $data->title = '<b>User Management</b>';
            $data->success = true;
        } catch (\Exception $e) {
            $data->success = false;
            $data->message = $this->responseMsgInstance->exception_msg;
            Log::error($e);
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
        //print_r(Session::get('user'));
        try {

            if (Auth::check())
                $userId = Auth::user()->id;
            $item = new User();
            $roles = DB::select('SELECT roles.id, roles.role FROM roles WHERE roles.id > (SELECT users.user_role FROM users WHERE users.id = ?) AND roles.is_admin = "yes"', [$userId]);
            $dataString = view('admin-ancillary.usermanagement.create', compact('userId', 'roles', 'item'));
            $data->success = true;
            $data->b_template = (string)$dataString;
        } catch (\Exception $e) {
            $data->success = false;
            $data->message = $this->responseMsgInstance->exception_msg;
            Log::error($e);
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
                $receiveData['password'] = bcrypt($receiveData['password']);
                if (User::create($receiveData)) {
                    $data->success = TRUE;
                    $data->message = $this->responseMsgInstance->create_success_msg;
                } else {
                    $data->success = false;
                    $data->message = $this->responseMsgInstance->create_failed_msg;
                }
            }
        } catch (\Exception $e) {
            $data->success = false;
            $data->message = $this->responseMsgInstance->exception_msg;
            Log::error($e);
        }

        return view('admin-ancillary.convertToJson', compact('data'));
    }

    /**
     * Edit View Page Call
     */
    public function edit($id)
    {
        $userDetails = [[]];
        $data = (Object)[];
        try {
            $item = User::find($id);
            if ($item) {
                if (Auth::check())
                    $userId = Auth::user()->id;
                $roles = DB::select('SELECT roles.id, roles.role FROM roles WHERE roles.id > (SELECT users.user_role FROM users WHERE users.id = ?) AND roles.is_admin = "yes"', [$userId]);
                $dataString = view('admin-ancillary.usermanagement.edit', compact('userId', 'roles', 'id', 'item'));
                $data->b_template = (string)$dataString;
                $data->success = true;
                $data->title = 'Change User Information';
                $data->viewAction = '<a class="btn btn-wide btn-primary" href="#" onclick="javascript:listInitializer(\'users\',{key: \'Edit\', route: \'users\'},\'PageLoader\', \'title\', \'action\');"><i class="glyphicon glyphicon-list-alt"></i> Show List</a>';

            } else {
                $data->success = false;
                $data->message = $this->responseMsgInstance->edit_failed_msg;
            }
        } catch (\Exception $e) {
            $data->success = false;
            $data->message = $this->responseMsgInstance->exception_msg;
            Log::error($e);
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
            $user = User::find($id);
            $receiveData = $request->all();
            if ($user) {
                $data = $this->formValInstance->formValidate($receiveData, [
                    'name' => 'required',
                    'email' => [
                        'required',
                        Rule::unique('users')->ignore($user->id)],
                ]);
                if ($data->success == 'true') {
                    if (isset($receiveData['password']))
                        $receiveData['password'] = bcrypt($receiveData['password']);
                    else
                        $receiveData['password'] = $user->password;
                    try {
                        $user->fill($receiveData)->update();
                        $data->success = TRUE;
                        $data->message = $this->responseMsgInstance->update_success_msg;
                    } catch (\Exception $ex) {
                        $data->success = FALSE;
                        $data->message = $this->responseMsgInstance->exception_msg;
                        Log::error($ex);
                    }
                }
            }
        } catch (\Exception $e) {
            $data->success = false;
            $data->message = $this->responseMsgInstance->exception_msg;
            Log::error($e);
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
            $user = User::find($id);
            if ($user) {
                try {
                    $user->delete();
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
            $data->success = false;
            $data->message = $this->responseMsgInstance->exception_msg;
            Log::error($e);
        }
        return view('admin-ancillary.convertToJson', compact('data'));

    }

    public function status($id)
    {
        $data = (Object)[];
        try {
            if (Auth::check()) {
                $user = User::find($id);
                if ($user) {
                    try {
                        if ($user->verified == 'yes') {
                            $user->verified = 'no';
                        } else {
                            $user->verified = 'yes';
                        }

                        $user->updated_by = Auth::user()->id;
                        $user->update();
                        $data->success = TRUE;
                        $data->message = $this->responseMsgInstance->update_success_msg;
                    } catch (Exception $ex) {
                        $data->success = FALSE;
                        $data->message = $this->responseMsgInstance->exception_msg;
                        Log::error($ex->getMessage());
                    }
                } else {
                    $data->success = FALSE;
                    $data->message = $this->responseMsgInstance->update_failed_msg;
                }
            } else {
                $data->success = FALSE;
                $data->message = $this->responseMsgInstance->authentication_denied_msg;
            }
        } catch (\Exception $e) {
            $data->success = false;
            $data->message = $this->responseMsgInstance->exception_msg;
            Log::error($e->getMessage());
        }
        return view('admin-ancillary.convertToJson', compact('data'));
    }


}
