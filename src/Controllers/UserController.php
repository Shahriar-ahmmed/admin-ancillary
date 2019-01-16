<?php

namespace Ahmmed\AdminAncillary\Controllers;

use Ahmmed\AdminAncillary\CommonLib;
use Ahmmed\AdminAncillary\FormValidation;
use Ahmmed\AdminAncillary\ResponseMessage;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use DB;
use Illuminate\Support\Facades\Storage;
use Laracasts\Flash\Flash;
use Mockery\CountValidator\Exception;

class UserController extends Controller {


    private $formValInstance = null;
    private $responseMsgInstance = null;
    private $commonLibInstance = null;

    public function __construct()
    {
        $this->formValInstance = new FormValidation();
        $this->responseMsgInstance = new ResponseMessage();
        $this->commonLibInstance = new CommonLib();
    }

    private function rules()
    {
        return [
            'current_password' => 'required|min:6|max:20',
            'new_password' => 'required|min:6|max:20|different:current_password',
            'confirm_password' => 'same:new_password|required'
        ];
    }

    public function passChange($userId, $curr, $new) {
        $user = User::where('id', $userId)->first();

        if (Hash::check($curr, $user->password)) {
            $item = User::findOrFail($userId);

            $companyInfo = array();
            $companyInfo['password'] = Hash::make($new);
            $item->fill($companyInfo)->update();

            return true;
        }

        return false;
    }



    public function profile($id)
    {
        try {
            $user = User::find($id);
            if(!$user)
            {
                Flash::error($this->responseMsgInstance->authentication_denied_msg);
                return redirect()->back();
            }
        }catch(\Exception $e){
            Flash::error($this->responseMsgInstance->exception_msg);
            Log::error($e->getMessage());
        }
        return view('admin-ancillary.user.profile',compact('user'));
    }

    public function editProfile($id){
        try {
            $user = User::find($id);
            if(!$user)
            {
                Flash::error($this->responseMsgInstance->edit_failed_msg);
                return redirect()->back();
            }
        }catch(\Exception $e){
            Flash::error($this->responseMsgInstance->edit_failed_msg);
            Log::error($e->getMessage());
        }
        return view('admin-ancillary.user.edit_profile',compact('user'));
    }

    public function updateProfile(Request $request,$id){
        $data = (Object) [];
        try {
            $user =  User::find($id);
            if($user) {
                $receiveData = $request->all();
                $data = $this->formValInstance->formValidate($receiveData,
                    ['name' => 'required']
                );
                if($data->success){
                    $user->update($receiveData);
                    $data->success = TRUE;
                    $data->message = $this->responseMsgInstance->update_success_msg;
                }
            }else{
                $data->success = false;
                $data->message = $this->responseMsgInstance->update_failed_msg;
            }
        } catch (Exception $ex) {
            $data->success = FALSE;
            $data->message = $this->responseMsgInstance->exception_msg;
            Log::error($ex->getMessage());
        }

        return response(json_encode($data));
    }
    public function  changePassWord($id){
        try {
            $user = User::find($id);
            if(!$user){
                Flash::error($this->responseMsgInstance->authentication_denied_msg);
                return redirect()->back();
            }
        }catch(\Exception $e){
            Flash::error($this->responseMsgInstance->exception_msg);
            Log::error($e->getMessage());
        }
        return view('admin-ancillary.user.changePass', compact('user'));
    }


    public function UpdatePassword(Request $request, $id)
    {
        $data = (Object)[];
        $check= false;
        try {
            $user = User::find($id);
            if ($user) {
                $data = $this->formValInstance->formValidate($request->all(), $this->rules());
                if($data->success){
                    $check = Hash::check($request->current_password, $user->password);
                    if (!$check) {
                        $data->success = false;
                        $data->errors['current_password'] = 'Your current password is incorrect, please try again.';
                    }else{
                        $user->password = Hash::make($request->new_password);
                        $user->save();
                        $data->success = TRUE;
                        $data->message = $this->responseMsgInstance->change_password_success_msg;
                    }
                }
            }else{
                $data->success = false;
                $data->message = $this->responseMsgInstance->change_password_failed_msg;
            }
        } catch (\Exception $e) {
            $data->success = false;
            $data->message = $this->responseMsgInstance->exception_msg;
            Log::error($e->getMessage());
        }

        return response(json_encode($data));
    }


}
