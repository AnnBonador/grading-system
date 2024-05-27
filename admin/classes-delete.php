<?php

include('../config/function.php');

$paraResultId = checkParamId('id');
if (is_numeric($paraResultId)) {

    $classId = validate($paraResultId);

    $class = getById('classes', $classId);
    
    if ($class['status'] == 200) 
    {
        $response = delete('classes', $classId);

        if ($response) {
            redirect('classes.php', 'Classes Deleted Successfully');
        } else {
            redirect('classes.php', 'Something Went Wrong');
        }
    } else {
        redirect('classes.php', $class['message']);
    }
} else {
    redirect('classes.php', 'Something Went Wrong');
}
