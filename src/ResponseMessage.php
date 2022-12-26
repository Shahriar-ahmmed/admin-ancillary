<?php

namespace Ahmmed\AdminAncillary;


class ResponseMessage
{
    public $success_msg = "Submitted Successfully ";
    public $unsuccess_msg = "Sorry! Submit Failed";
    public $authentication_denied_msg = "You are not authorized to do this action";
    public $exception_msg = "Sorry! Something Wrong";
    public $create_success_msg = "Create Successfully";
    public $create_failed_msg = "Sorry! create Failed";
    public $update_success_msg = "Update Successfully";
    public $update_failed_msg = "Sorry! Update Failed";
    public $edit_success_msg = "Edit Successfully";
    public $edit_failed_msg = "Sorry! Edit Failed";
    public $show_success_msg = "Show Successfully";
    public $show_failed_msg = "Sorry! Show Failed";
    public $delete_success_msg = "Delete successfully";
    public $delete_failed_msg = "Sorry! Delete Failed";
    public $permission_success_msg = "Permission Changed Successfully";
    public $menu_order_success_msg = "Menu Order Changed Successfully";
    public $menu_order_fail_msg = "Menu Order Changed Fails";
    public $order_success_msg = "Order Changed Successfully";
    public $order_fail_msg = "Order Changed Fails";
    public $authentication_accept_msg="User has permission";
    public $undo_delete_success_msg = "Undo Delete successfully";
    public $undo_delete_failed_msg = "Sorry! Undo Delete Failed";
    public $change_password_success_msg="Password Changed Successfully.";
    public $change_password_failed_msg="Password Changed Failed.";
    public $image_size_exceed_limit="Image size exceed limit";
    public $image_invalid_extension="Image invalid extension";
    public $lockscreen_failed_msg="Sorry! lockscreen Failed";
    public $unlockscreen_success_msg="Unlockscreen Successfully";
    public $unlockscreen_failed_msg="Sorry! Password mismatch";
    public $not_found_msg="Sorry! Didn't Found";

}