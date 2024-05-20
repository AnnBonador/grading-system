<?php

include('../config/function.php');

$paraResultId = checkParamId('id');
if (is_numeric($paraResultId)) {

    $subjectId = validate($paraResultId);

    $subject = getById('subjects', $subjectId);
    
    if ($subject['status'] == 200) 
    {
        $response = delete('subjects', $subjectId);

        if ($response) {
            redirect('subjects.php', 'Subject Deleted Successfully');
        } else {
            redirect('subjects.php', 'Something Went Wrong');
        }
    } else {
        redirect('subjects.php', $subject['message']);
    }
} else {
    redirect('subjects.php', 'Something Went Wrong');
}
