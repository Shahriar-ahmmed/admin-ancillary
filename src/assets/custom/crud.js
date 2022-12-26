/**
 * Author : Shahriar Ahmmed
 * Copyright (c) 2016
 */

$.ajaxSetup({
    headers: {'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')}
});

/**
 * Set field value into specific tag with id  #
 */
function setValueIntoField(selector_name, value, selector_type) {
    selector_name = typeof selector_name !== 'undefined' ? selector_name : null;
    value = typeof value !== 'undefined' ? value : "";
    selector_type = typeof selector_type !== 'undefined' ? selector_type : "id";

    if (selector_type == "id") {
        $("#" + selector_name).val(value);
    } else if (selector_type == "radio") {
        $("input[name='" + selector_name + "'][value='" + value + "']").prop('checked', true);
    } else if (selector_type == "htmltag") {
        $(selector_name).html(value);
    } else {
        $(selector_name).val(value);
    }
}
/*
* ajax call with option
* */

function syncAjaxCaller(url, parameters, asyncType, method) {
    url = typeof url !== 'undefined' ? url : null;
    parameters = typeof parameters !== 'undefined' ? parameters : null;
    asyncType = typeof asyncType !== 'undefined' ? asyncType : false;
    method = typeof method !== 'undefined' ? method : 'get';
    if (url == null) {
        Lobibox.alert('warning', {
            msg: "AjaxCaller :: Invalid argument pass"
        });
        return false;
    }
    var return_val;
    $.ajax({
        data: parameters,
        url: url,
        type: method,
        async: asyncType,
        cache: false,
        dataType: "json",
        beforeSend: function () {
            //$(push_id).html("Processing, please wait...");
        },
        success: function (data) {
            return_val = data;
        },
        error: function (request, status, error) {

            return_val = request;
            //$(push_id).html(request.responseText);
        }
    });

    return return_val;
}

/*
 * ajax call for upload  with option
 * */
function uploadAjaxCall(remoteKey, parameter, method) {
    remoteKey = typeof remoteKey !== 'undefined' ? remoteKey : null;
    parameter = typeof parameter !== 'undefined' ? parameter : null;
    method = typeof method !== 'undefined' ? method : 'post';

    var return_val;
    $.ajax({
        type: method,
        url: remoteKey,
        data: parameter, //data to be send to server side script(ie php) in the given above url script
        dataType: "json",
        async: false,
        beforeSend: function (xhr) {
            loaderBarShow();
        },
        success: function (response) {
            loaderBarHide();
            return_val = response;
        },
        cache: false,
        crossDomain: true,
        contentType: false,
        processData: false,
        error: function (request, textStatus, errorMessage) {
            return_val = request;
        }
    });
    return return_val;
}

/*
* datatable initialize with table id and attributes
*/

function datatableInitializer(id) {
    $('#' + id).html('<table class="table table-striped table-bordered table-hover" id="dt_' + id + '" width="100%"><tr><td  align="center"><img src="public/images/bn-loader.gif"></td></tr></table>');

}
/*
* datatable generate with option
* */
function datatableGenerator(id, dataSet, columns) {
    $('#dt_' + id).DataTable({
        "data": dataSet,
        "columns": columns,
        "order": [[0, "asc"]],
        dom: 'lBfrtip',
        "filter": "applied",
        responsive: true,
        // if you  need export button then comment out the button properties
        buttons: [
        	{
        		extend: 'excel',
        		exportOptions: {
        			columns: ':not(.noExport)'
        		}
        	},
        	{
        		extend: 'pdf',
        		exportOptions: {
        			columns: ':not(.noExport)'
        		}
        	},
        	{
        		extend: 'print',
        		exportOptions: {
        			columns: ':not(.noExport)'
        		}
        	},

        ]

    });
    $('.dataTables_scrollHeadInner,.dataTables_scrollHeadInner table').css('width', '100%');
}


/**
 *  checking permission when change menu order
 */
function confirmationBox(functionName,dataInfo,msg){
    msg=typeof msg!=='undefined'?msg:"Are you sure you want to proceed this action?";
    dataInfo=typeof dataInfo!=='undefined'?dataInfo:'';
    Lobibox.confirm({
        msg:msg,
        callback:function($this,type,ev)
        {
            if(type==='yes')
            {
                window[functionName](dataInfo)
            }
        }
    });
}
/**
 * Custom Alert
 */
function customAlert(msg, success) {
    success = typeof success !== 'undefined' ? success : false;
    if (success) msg_format = 'success';
    else msg_format = 'error';
    Lobibox.alert(msg_format, {
        msg: msg
    });
}

/**
 * fetch Data List into datatable
 */
function listInitializer(remoteKey, pushLocationId, titleId, ViewAction,pagination) {
    remoteKey = typeof remoteKey !== 'undefined' ? remoteKey : "Linfo";
    pushLocationId = typeof pushLocationId !== 'undefined' ? pushLocationId : "Linfo";
    titleId = typeof titleId !== 'undefined' ? titleId : null;
    ViewAction = typeof ViewAction !== 'undefined' ? ViewAction : null;
    pagination = typeof pagination !== 'undefined' ? pagination : null;

    var dataSet = [[]];
    datatableInitializer(pushLocationId);
    dataSet = syncAjaxCaller(public_path + '/admin/retrieve/' + remoteKey, null, false, 'get');

    if (dataSet.success) {
        if(pagination !=null)
            setValueIntoField("#"+pagination,dataSet.pagination,"htmltag")
        if (ViewAction != null) {
            setValueIntoField("#" + ViewAction, dataSet.createAction, "htmltag");
            if (titleId != null) setValueIntoField("#" + titleId, dataSet.title, "htmltag");
        } else {
            if (titleId != null) setValueIntoField("#" + titleId, dataSet.title, "htmltag");
        }
        datatableGenerator(pushLocationId, dataSet.rows, dataSet.columns);
    }
    else {
        customAlert(dataSet.message, dataSet.success);
    }
}

/**
 * Create Form Initializer
 */
function createFormInitializer(remoteKey, pushLocationId, titleId, ViewAction) {
    pushLocationId = typeof pushLocationId !== 'undefined' ? pushLocationId : "Linfo";
    titleId = typeof titleId !== 'undefined' ? titleId : null;
    ViewAction = typeof ViewAction !== 'undefined' ? ViewAction : null;
    var dataSet = [[]];
    dataSet = syncAjaxCaller(public_path + '/admin/' + remoteKey + '/create', null, false, 'get');
    if (dataSet.success) {
        setValueIntoField("#" + pushLocationId, dataSet.b_template, "htmltag");
        if (ViewAction != null) {
            setValueIntoField("#" + ViewAction, dataSet.viewAction, "htmltag");
            if (titleId != null)
                setValueIntoField("#" + titleId, dataSet.title, "htmltag");
        } else {
            if (titleId != null)
                setValueIntoField("#" + titleId, dataSet.title + " " + dataSet.title, "htmltag");
        }
    } else {
        customAlert(dataSet.message, dataSet.success);
    }
}

/**
 * Create Form Submission
 */
function createFormExecution(remoteKey, form, showMessageId, pushLocationId, titleId, showActionBtn, modalId) {
    showMessageId = typeof showMessageId !== 'undefined' ? showMessageId : null;
    pushLocationId = typeof pushLocationId !== 'undefined' ? pushLocationId : null;
    titleId = typeof titleId !== 'undefined' ? titleId : null;
    showActionBtn = typeof showActionBtn !== 'undefined' ? showActionBtn : null;
    modalId = typeof modalId !== 'undefined' ? modalId : null;

    var dataSet = [[]];
    var check = [[]];
    dataSet = syncAjaxCaller(public_path + '/admin/' + remoteKey, $(form).serialize(), false, 'post');
    //setValueIntoField("#"+showMessageId,dataSet.message,"htmltag");
    if (dataSet.success) {
        if (modalId != null) {
            document.getElementById(modalId).click();
        }
        customAlert(dataSet.message, dataSet.success);
        if (pushLocationId != null) {
            listInitializer(remoteKey, pushLocationId, titleId, showActionBtn);
        }
        else {
            window.location.reload(true);
        }
    } else {
        if (dataSet.errors) {
            $('.form-group .text-danger').text('');
            $('.form-group').removeClass('has-error');
            $.each(dataSet.errors, function (index, value) {
                //$('#_' + index).closest('.form-group').addClass('has-error');
                $('#_' + index).text(value);
            });
        }
        else
            customAlert(dataSet.message, dataSet.success);
    }
    return false;
}

/**
 * Edit Form Initializer
 */
function editFormInitializer(remoteKey, rowid, pushLocationId, titleId, ViewAction) {
    pushLocationId = typeof pushLocationId !== 'undefined' ? pushLocationId : "Linfo";
    titleId = typeof titleId !== 'undefined' ? titleId : null;
    ViewAction = typeof ViewAction !== 'undefined' ? ViewAction : null;
    var dataSet = [[]];
    dataSet = syncAjaxCaller(public_path + '/admin/' + remoteKey + '/' + rowid + '/edit', null);
    if (dataSet.success) {
        setValueIntoField("#" + pushLocationId, dataSet.b_template, "htmltag");
        if (ViewAction != null) {
            setValueIntoField("#" + ViewAction, dataSet.viewAction, "htmltag");
            if (titleId != null) setValueIntoField("#" + titleId, dataSet.title, "htmltag");
        } else {
            if (titleId != null) setValueIntoField("#" + titleId, dataSet.title + " " + dataSet.viewAction, "htmltag");
        }
    }
    else {
        customAlert(dataSet.message, dataSet.success);
    }
}
/**
 * Edit Form Submission
 */
function updateFormExecution(remoteKey, form, rowid, showMessageId, pushLocationId, titleId, action, modalCloseId) {
    showMessageId = typeof showMessageId !== 'undefined' ? showMessageId : null;
    pushLocationId = typeof pushLocationId !== 'undefined' ? pushLocationId : null;
    titleId = typeof titleId !== 'undefined' ? titleId : null;
    modalCloseId = typeof modalCloseId !== 'undefined' ? modalCloseId : null;
    var dataSet = [[]];
    dataSet = syncAjaxCaller(public_path + '/admin/' + remoteKey + '/' + rowid, $(form).serialize(), false, 'post');
    if (dataSet.success) {
        customAlert(dataSet.message, dataSet.success);
        if (modalCloseId != null) {
            document.getElementById(modalCloseId).click();
        }
        if (pushLocationId != null) {
            listInitializer(remoteKey, pushLocationId, titleId, action);
        } else {
            window.location.reload(true);
        }
    } else {
        if (dataSet.errors instanceof Object) {
            $('.form-group .text-danger').text('');
            $('.form-group').removeClass('has-error');
            $.each(dataSet.errors, function (index, value) {
                //$('#_' + index).closest('.form-group').addClass('has-error');     // comment out if you want to remove error message
                $('#_' + index).text(value);
            });
        }
        else customAlert(dataSet.message, dataSet.success);
    }
    return false;
}

/**
 * Create Form Submission with upload
 */

function createFormExecutionWithUpload(remoteKey, form, fileUploadIdName, pushLocationId, titleId, showActionBtn,modalId) {
    showMessageId = typeof showMessageId !== 'undefined' ? showMessageId : null;
    pushLocationId = typeof pushLocationId !== 'undefined' ? pushLocationId : null;
    titleId = typeof titleId !== 'undefined' ? titleId : null;
    showActionBtn = typeof showActionBtn !== 'undefined' ? showActionBtn : null;
    fileUploadIdName = typeof fileUploadIdName !== 'undefined' ? fileUploadIdName : null;
    modalId = typeof modalId !== 'undefined' ? modalId : null;
    if (fileUploadIdName == null) {
        customAlert("Please mention upload field id name array");
    }
    var dataSet = [[]];
    var formData = new FormData();
    var ins = 0;
    var count = 0;

    $.each(fileUploadIdName, function (paramName, idName) {
        ins = document.getElementById(idName).files.length;
        for (count = 0; count < ins; count++) {
            formData.append(paramName + "[]", document.getElementById(idName).files[count]);
        }

        var dataRaw = $(form).serializeArray();
        $.each(dataRaw, function (index, content) {
            formData.append(content.name, content.value);
        });
    });

    dataSet = uploadAjaxCall(public_path + '/admin/' + remoteKey, formData, 'POST');
    if (dataSet.success) {
        if (modalId != null) {
            document.getElementById(modalId).click();
        }
        customAlert(dataSet.message, dataSet.success);
        if (pushLocationId != null) {
            listInitializer(remoteKey, pushLocationId, titleId, showActionBtn);
        }
    } else {
        if (dataSet.errors instanceof Object) {
            $('.form-group .text-danger').text('');
            $('.form-group').removeClass('has-error');
            $.each(dataSet.errors, function (index, value) {
                $('#_' + index).text(value);
            });
        }
        else
            customAlert(dataSet.message, dataSet.success);
    }
    return false;
}

/**
 * Edit Form Submission with upload
 */
function updateFormExecutionWithUpload(remoteKey, form, rowid, fileUploadIdName, pushLocationId, titleId, showActionBtn, modalId) {
    showMessageId = typeof showMessageId !== 'undefined' ? showMessageId : null;
    pushLocationId = typeof pushLocationId !== 'undefined' ? pushLocationId : null;
    titleId = typeof titleId !== 'undefined' ? titleId : null;
    showActionBtn = typeof showActionBtn !== 'undefined' ? showActionBtn : null;
    fileUploadIdName = typeof fileUploadIdName !== 'undefined' ? fileUploadIdName : null;
    if (fileUploadIdName == null) {
        customAlert("Please mention upload field id name array");
    }
    var dataSet = [[]];
    var formData = new FormData();
    var ins = 0;
    var count = 0;

    $.each(fileUploadIdName, function (paramName, idName) {
        ins = document.getElementById(idName).files.length;
        for (count = 0; count < ins; count++) {
            formData.append(paramName + "[]", document.getElementById(idName).files[count]);
        }

        var dataRaw = $(form).serializeArray();
        $.each(dataRaw, function (index, content) {
            formData.append(content.name, content.value);
        });
    });

    dataSet = uploadAjaxCall(public_path + '/admin/' + remoteKey + '/' + rowid, formData, 'post');
    if (dataSet.success) {
        if (modalId != null)
            document.getElementById(modalId).click();
        customAlert(dataSet.message, dataSet.success);
        if (pushLocationId != null) {
            listInitializer(remoteKey, pushLocationId, titleId, showActionBtn);
        }
    } else {
        if (dataSet.errors instanceof Object) {
            $('.form-group .text-danger').text('');
            $('.form-group').removeClass('has-error');
            $.each(dataSet.errors, function (index, value) {
                $('#_' + index).text(value);
            });
        }
        else
            customAlert(dataSet.message, dataSet.success);
    }
}
/**
 * Delete an from datatable
 */
function deleteItemExecution(remoteKey, rowid, pushLocationId, titleId, action) {
    pushLocationId = typeof pushLocationId !== 'undefined' ? pushLocationId : "Linfo";
    titleId = typeof titleId !== 'undefined' ? titleId : null;
    var check = [[]];
    Lobibox.confirm
    ({
        msg: "Are you sure you want to delete this?",
        callback: function ($this, type, ev) {
            if (type === 'yes') {
                var dataSet = [[]];
                dataSet = syncAjaxCaller(public_path + '/admin/' + remoteKey + '/' + rowid, null, false, 'delete');
                if (dataSet.success) {
                    customAlert(dataSet.message, dataSet.success);
                    if (pushLocationId != null) {
                        listInitializer(remoteKey, pushLocationId, titleId, action);
                    } else {
                        window.location.reload(true);
                    }
                }
            }
        }
    });

    return false;
}
/*
* push specific value into a html tag id
*/
function blogView(remoteKey, dataInfo, pushLocationId) {
    pushLocationId = typeof pushLocationId !== 'undefined' ? pushLocationId : null;
    dataInfo = typeof dataInfo !== 'undefined' ? dataInfo : null;
    var dataSet = [[]];
    datatableInitializer(pushLocationId);
    dataSet = syncAjaxCaller(public_path + '/' + remoteKey, dataInfo);
    if (dataSet.success)
        setValueIntoField("#" + pushLocationId, dataSet.b_template, "htmltag");
    else {
        customAlert(dataSet.message, dataSet.success);
    }
}
/*
* clear a html tag element using id
*/
function clearContent(target_id) {
    $('#' + target_id).html('');
}
/*
 * clear a form element using id
 */
function clearForm(target_id) {
    $('#' + target_id).val('');
}
/*
* show loading animation before ajax call
* */
var LOADER_BAR_DIV_ID = '#loadingBar';
function loaderBarShow() {
    $(LOADER_BAR_DIV_ID).show();
}
/*
 * hide loading animation after ajax call
 * */
function loaderBarHide() {
    $(LOADER_BAR_DIV_ID).hide();
}

/*
* image preview in form with target tag id
*/

function ImagePreview(input, target_id) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#' + target_id)
                .attr('src', e.target.result)
        };
        reader.readAsDataURL(input.files[0]);
    }
}
/*
* for update menu order
* */
function menuUpdateExecution(dataInfo) {
    dataInfo = typeof dataInfo !== 'undefined' ? dataInfo : null;
    var dataSet = [[]];
    dataSet = syncAjaxCaller(public_path + '/admin/menu_order', dataInfo,false,'post');
    if (dataSet.success) {
        customAlert(dataSet.message, dataSet.success);
    }
    else {
        customAlert(dataSet.message, dataSet.success);
    }
}