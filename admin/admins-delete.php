<?php

include('../config/function.php');

$paraResultId = checkParamId('id');
if (is_numeric($paraResultId)) {

    $adminId = validate($paraResultId);

    $admin = getById('admins', $adminId);
    if ($admin['status'] == 200) {
        $adminDeleteRes = delete('admins', $adminId);
        if ($adminDeleteRes) {
            redirect('admins.php', 'User Deleted Successfully');
        } else {
            redirect('admins.php', 'Something Went Wrong');
        }
    } else {
        redirect('admins.php', $admin['message']);
    }
} else {
    redirect('admins.php', 'Something Went Wrong');
}
