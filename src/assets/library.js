/**
 * Created by Shahriar Ahmmed on 21-Sep-18.
 */
/**
 * Get field value
 */
function fetchValueFromField(selector_name) {
    var ret_val;
    if ($(selector_name).length) {
        ret_val = $(selector_name).val();
    } else ret_val = "";
    return ret_val;
}

/*
 *
 * */

function groupOrderUpdateExecution(dataInfo) {
    dataInfo = typeof dataInfo !== 'undefined' ? dataInfo : null;
    if (dataInfo.length > 4) {
        var dataSet = [[]];
        dataSet = syncAjaxCaller(public_path + '/Update/groupOrder', dataInfo);
        if (dataSet.success) {
            customAlert(dataSet.message, dataSet.success);
        }
        else {
            customAlert(dataSet.message, dataSet.success);
        }
    }
}

/**
 * Show/Hide specific boundary(ies)
 */
function showHideAction(show_id, hide_id) {
    hide_id = typeof hide_id !== 'undefined' ? hide_id : null;
    if (show_id != null) $(show_id).show();
    if (hide_id != null) $(hide_id).hide();
}

/**
 * Reload Specific Sytem
 */
function reload_system(callback_url) {
    var rs = confirm("Are you sure you want to reload?");
    if (rs) {
        $.post(callback_url + ".php", null, function (response) {
            alert(err_msg6);
        });
    }
}

/**
 * Restore fields value
 */
function restore_fields(callback_script, condition_arr) {
    var remote;
    var data = "";
    if (condition_arr != null) {
        $.each(condition_arr, function (i, id) {
            data += id + "=" + get_value("#" + id) + "&";
        });
    }

    $.ajax({
        type: "POST",
        url: callback_script + ".php",
        data: data,
        async: false,
        success: function (res) {
            remote = res;
        }
    });

    return remote;
}

/**
 * Replace All Related Fields
 */
String.prototype.replaceAll = function (str1, str2, ignore) {
    return this.replace(new RegExp(str1.replace(/([\/\,\!\\\^\$\{\}\[\]\(\)\.\*\+\?\|\<\>\-\&])/g, "\\$&"), (ignore ? "gi" : "g")), (typeof(str2) == "string") ? str2.replace(/\$/g, "$$$$") : str2);
}

/**
 * Use same value of a field
 * in multiple fields(if necessary)
 * with replacing some substring of field value(string)
 */
function reassign_value(source_host, destination_host, separator, replace_with) {
    var HOST = $.trim($(source_host).val());

    if (HOST != "") {
        $(destination_host).val(HOST.replaceAll(separator, replace_with));
    }
}

/**
 * Load JSON Data for <select>
 * var res = load_list("modules/ch/get.php",condition_arr);
 *  $("#selector_id").html( res );
 */
function load_list(callback_script, condition_arr) {
    var return_val_arr = restore_fields(callback_script, condition_arr);
    var obj = jQuery.parseJSON(return_val_arr);
    var str_data = "";
    $.each(obj, function (key, value) {
        str_data += "<option value='" + key + "'>" + value + "</option>";
    });

    return str_data;
}

/**
 * Delete operation called from view page
 */
function delete_operation(callback_script, action_id, id) {
    var data = "action=delete&action_id=" + action_id;

    $.post(callback_script + ".php", data, function (response) {
        if (response == 0) {
            alert("Deleted successfully");
            $("#" + id).parent("td").parent("tr").css("display", "none");
        } else {
            alert("Deletion failed");
        }
    });
}



/**
 * Upload a file
 * Parameter list and meaning
 * php_script_url : where data will be posted,
 * file_id : id of the file input tag
 * supported_file_type : An allowed extension Array. all value should be LOWER case
 * progress_id : progress_id is the id of parent div tag of one child div tag to show the progress of file upload
 */
function file_upload(trigger, php_script_url, file_id, value_arr, supported_file_type, required_arr, tbl, callback_script, show_id, hide_id, progress_id) {
    supported_file_type = typeof supported_file_type !== 'undefined' ? supported_file_type : null;
    tbl = typeof tbl !== 'undefined' ? tbl : null;
    callback_script = typeof callback_script !== 'undefined' ? callback_script : null;
    show_id = typeof show_id !== 'undefined' ? show_id : null;
    hide_id = typeof hide_id !== 'undefined' ? hide_id : null;
    required_arr = typeof required_arr !== 'undefined' ? required_arr : null;
    progress_id = typeof progress_id !== 'undefined' ? progress_id : null;

    var progressHandlerFunction = function (e) {
        $("#" + progress_id).css({"width": Math.ceil(e.loaded / e.total) * 100 + '%'});
    };

    var formData = new FormData();
    var fileIn = $("#" + file_id)[0];
    //Has any file been selected yet?
    if (trigger == true && (fileIn.files === undefined || fileIn.files.length == 0)) {
        customAlert("Please select a file");
        return;
    }

    if (required_arr != null) {
        var r_flag = true;
        $.each(required_arr, function (i, id) {
            if (get_value("#" + id) == "") {
                r_flag = false;
            }
        });
        if (r_flag == false) {
            customAlert("Please provide all necessary information");
            return;
        }
    }

    //We will upload only one file in this demo
    var file = fileIn.files[0];
    if (file) {
        // Check Extension
        var filename = file.name;
        var arr = filename.split(".");
        var extension = arr[arr.length - 1].toLowerCase();
        if ($.inArray(extension, supported_file_type) == -1) {
            customAlert("Unsupported file");
            return;
        }


        formData.append("file_name", file.name);
        //formData.append("file_length",file.length);
        formData.append(file_id, file);
    }

    if (value_arr != null) {
        $.each(value_arr, function (key, val) {
            formData.append(key, get_value(val));
        });
    }

    msg = "";
    if (progress_id != null) $("#" + progress_id).show();

    $.ajax({
        type: "POST",
        url: php_script_url,
        data: formData, //data to be send to server side script(ie php) in the given above url script
        xhr: function () {
            var myXhr = $.ajaxSettings.xhr();
            if (myXhr.upload) {
                myXhr.upload.addEventListener('progress', progressHandlerFunction, true);
            } else {
                console.log("Upload progress is not supported.");
            }
            return myXhr;
        },
        async: false,
        success: function (response) {
            if (progress_id != null) {
                $("#" + progress_id).text("uploaded successfully...");
                $("#" + progress_id).fadeOut(1500);
            }

            if (response == 0) {
                alert(err_msg2);

                if (tbl != null) {
                    var filter_arr = [];
                    $.each(value_arr, function (index, val) {
                        filter_arr.push(val.replace('#', ''));
                    });
                    pagination(tbl, filter_arr, callback_script, show_id, hide_id);
                }
            } else {
                alert(err_msg3);
            }

            msg = response;
        },
        cache: false,
        contentType: false,
        processData: false,
        error: function (jqXHR, textStatus, errorMessage) {
            //console.log(textStatus); // Optional
            alert("Upload Failed due to:" + errorMessage);
            if (progress_id != null) $("#" + progress_id).hide();
        }
    });

    return msg;
}

/**
 * Load Select Option
 */
function createDropDown(selectId, callback_script, condition_arr, firstText, firstValue) {
    condition_arr = typeof condition_arr !== 'undefined' ? condition_arr : null;
    firstText = typeof firstText !== 'undefined' ? firstText : null;
    firstValue = typeof firstValue !== 'undefined' ? firstValue : null;

    var $select = $("#" + selectId);
    $select.empty();

    if (firstText != null && firstValue != null) {
        var $sel = $("<option/>");
        $sel.val(firstValue);
        $sel.text(firstText);
        $select.append($sel);
    }
    var return_val_arr = restore_fields(callback_script, condition_arr);
    var obj = jQuery.parseJSON(return_val_arr);
    $.each(obj, function (key, value) {
        var $o = $("<option/>");
        $o.val(key);
        $o.text(value);
        $select.append($o);
    });
}

/**
 * Numeral Check
 */
function numeralsOnly(evt) {
    evt = (evt) ? evt : event;
    var charCode = (evt.charCode) ? evt.charCode : ((evt.keyCode) ? evt.keyCode :
        ((evt.which) ? evt.which : 0));
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        //alert(err_msg7);
        Lobibox.alert('error', {
            msg: err_msg7
        });
        return false;
    }
    return true;
}
function categoryOrderUpdateExecution(dataInfo) {
    dataInfo = typeof dataInfo !== 'undefined' ? dataInfo : null;
    if (dataInfo.length > 4) {
        var dataSet = [[]];
        dataSet = syncAjaxCaller(public_path + '/Update/categoryOrder', dataInfo);
        if (dataSet.success) {
            customAlert(dataSet.message, dataSet.success);
        }
        else {
            customAlert(dataSet.message, dataSet.success);
        }
    }
}

function adminMenuUpdateExecution(dataInfo) {
    dataInfo = typeof dataInfo !== 'undefined' ? dataInfo : null;
    //alert('Working');
    if (dataInfo.length > 4) {
        var dataSet = [[]];
        dataSet = syncAjaxCaller(public_path + '/Update/adminMenuOrder', dataInfo);
        if (dataSet.success) {
            customAlert(dataSet.message, dataSet.success);
        }
        else {
            customAlert(dataSet.message, dataSet.success);
        }
    }
}
/*
 * checking email in ajax request
 */
function checkEmail(field_id, push_msg) {
    push_msg = typeof push_msg !== 'undefined' ? push_msg : null;
    var dataSet = [[]];
    var field_val = $.trim(fetchValueFromField("#" + field_id));

    if (field_val != "") {
        dataSet = syncAjaxCaller(public_path + '/CheckEmail/' + field_val);
        //dataSet = JSON.parse(dataSet);
        //console.log(dataSet);
        //alert( dataSet.success);
        if (push_msg != null && dataSet.success)
            setValueIntoField("#" + push_msg, dataSet.message, "htmltag");
        return dataSet.c_user;
    }
}

//for send mail and show confirmation
function sendMail(remoteKey, dataInfo) {
    dataInfo = typeof dataInfo !== 'undefined' ? dataInfo : null;
    var dataSet = [[]];
    dataSet = syncAjaxCaller(public_path + '/' + remoteKey + '/' + dataInfo, null);
    customAlert(dataSet.message, dataSet.success);
}