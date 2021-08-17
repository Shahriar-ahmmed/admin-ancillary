<?php

namespace Ahmmed\AdminAncillary;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class FormValidation extends Controller
{
//        for form validation here receive request input and rules. this method checking
//          validation and return true or false using data object. if false then return error message
    public function formValidate($request, $rules)
    {
        $data = (Object)[];
        $validator = Validator::make($request, $rules);
        if ($validator->fails()) {
            $data->success = false;
            $data->errors = $validator->getMessageBag()->toArray();
        }else{
            $data->success = true;
        }
        return $data;
    }
}
