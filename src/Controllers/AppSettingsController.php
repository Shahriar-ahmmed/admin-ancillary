<?php

namespace Ahmmed\AdminAncillary\Controllers;

use Ahmmed\AdminAncillary\CommonLib;
use Ahmmed\AdminAncillary\FormValidation;
use Ahmmed\AdminAncillary\Models\AppSetting;
use Ahmmed\AdminAncillary\ResponseMessage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Mockery\CountValidator\Exception;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class AppSettingsController extends Controller
{
    private $responseMsgInstance = null;
    private $formValInstance = null;
    private $commonLibInstance = null;

    private $rules = [
        'app_name' => 'required',
//        'logo' => 'required',
//        'favicon' => 'required',
    ];

    public function __construct()
    {
        $this->responseMsgInstance = new ResponseMessage();
        $this->formValInstance = new FormValidation();
        $this->commonLibInstance = new CommonLib();
    }


    public function appInfo()
    {
        return view('admin-ancillary.app_settings.app');
    }

    public function appSettingsEdit()
    {
        return view('admin-ancillary.app_settings.edit_app');
    }

    public function appSettingsUpdate($id, Request $request)
    {
        $data = (Object)[];
        try {
            $receiveData = $request->all();
            $data = $this->formValInstance->formValidate($receiveData, $this->rules);
            if ($data->success) {
                $logo=null;
                $favicon=null;
                $name = trim($receiveData['app_name']);
                    if (Input::hasFile('logo')) {
                        $storage_file = Input::file('logo');
                        $storage_limit = 262144;
                        $storage_path = public_path();
                        $upload_data = $this->commonLibInstance->uploadFile($storage_file[0], $storage_path, $storage_limit);
                        if ($upload_data->success) {
                            $logo = $upload_data->fileNames[0];
                        } else {
                            $data = (Object)[];
                            $data->success = false;
                            $data->message = $upload_data->message;
                        }
                    }
                    if (Input::hasFile('favicon')) {
                        $storage_file = Input::file('favicon');
                        $storage_limit = 131072;
                        $storage_path = public_path();
                        $upload_data = $this->commonLibInstance->uploadFile($storage_file[0], $storage_path, $storage_limit);
                        if ($upload_data->success) {
                            $favicon = $upload_data->fileNames[0];
                        } else {
                            $data = (Object)[];
                            $data->success = false;
                            $data->message = $upload_data->message;
                        }
                    }
                    $array = [];
                    if(isset($name)){
                        $array['APP_NAME'] = '"'.$name.'"';
                    }
                    if(isset($logo)){
                        $array['DEFAULT_LOGO'] = $logo;
                    }
                    if(isset($favicon)){
                        $array['DEFAULT_FAVICON'] = $favicon;
                    }
                    $en = $this->changeEnv($array);
                    if($en){
                        $data->success = TRUE;
                        $data->message = $this->responseMsgInstance->update_success_msg;
                    }else{
                        $data->success = false;
                        $data->message = $this->responseMsgInstance->update_failed_msg;
                    }
            }
        } catch (Exception $e) {
            $data->success = false;
            $data->message = $this->responseMsgInstance->exception_msg;
            Log::error($e);
        }
        return view('admin-ancillary.convertToJson', compact('data'));
    }

    /**
     * Change the given values of the current env file.
     * If the given key(s) is/are not found, nothing happens.
     *
     * @param array $data data
     *
     * @return bool
     */
    public function changeEnv($data = array())
    {
        if (count($data) > 0) {

            $env = $this->envToArray('.env');

            foreach ($data as $dataKey => $dataValue) {

                foreach (array_keys($env) as $envKey) {
                    if ($dataKey === $envKey) {
                        $env[$envKey] = $dataValue;
                    }
                }

            }
            return $this->save($env);
        }
        throw new NotFoundHttpException();
    }

    /**
     * Writes the content of a env file to an array.
     *
     * @param file $file file
     *
     * @return array
     */
    protected function envToArray($file)
    {
        $string      = file_get_contents($file);
        $string      = preg_split('/\n+/', $string);
        $returnArray = array();

        foreach ($string as $one) {
            if (preg_match('/^(#\s)/', $one) === 1 || preg_match('/^([\\n\\r]+)/', $one)) {
                continue;
            }
            $entry                  = explode("=", $one, 2);
            $returnArray[$entry[0]] = isset($entry[1]) ? $entry[1] : null;
        }

        return array_filter(
            $returnArray,
            function ($key) {
                return !empty($key);
            },
            ARRAY_FILTER_USE_KEY
        );
    }

    /**
     * Saves the given data to the .env-file
     *
     * @param array $array array
     *
     * @return bool
     */
    protected function save($array)
    {
        if (is_array($array)) {
            $newArray = array();
            $c        = 0;
            foreach ($array as $key => $value) {
                if (preg_match('/\s/', $value) > 0 && (strpos($value, '"') > 0 && strpos($value, '"', -0) > 0)) {
                    $value = '"' . $value . '"';
                }

                $newArray[$c] = $key . "=" . $value;
                $c++;
            }

            $newArray = implode("\n", $newArray);

            file_put_contents(base_path('.env'), $newArray);

            return true;
        }
        return false;
    }
}
