<?php

include('../config/function.php');

$paraResultId = checkParamId('id');
if (is_numeric($paraResultId)) {

    $studentId = validate($paraResultId);

    $student = getById('students', $studentId);
    
    if ($student['status'] == 200) 
    {
        $response = delete('students', $studentId);

        if ($response) {
            redirect('students.php', 'Student Deleted Successfully');
        } else {
            redirect('students.php', 'Something Went Wrong');
        }
    } else {
        redirect('students.php', $student['message']);
    }
} else {
    redirect('students.php', 'Something Went Wrong');
}
