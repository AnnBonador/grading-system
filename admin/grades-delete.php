<?php
include('../config/function.php');

$paraResultId = isset($_GET['id']) && is_numeric($_GET['id']) ? $_GET['id'] : null;
$return_url = isset($_GET['return_url']) ? urldecode($_GET['return_url']) : 'class-record.php';

if ($paraResultId) {
    $gradeId = validate($paraResultId);
    $grade = getById('grades', $gradeId);
    
    if ($grade['status'] == 200) {
        $gradeDelete = delete('grades', $gradeId);
        if ($gradeDelete) {
            redirect($return_url, 'Class Record Deleted Successfully');
        } else {
            redirect($return_url, 'Something Went Wrong');
        }
    } else {
        redirect($return_url, $grade['message']);
    }
} else {
    redirect($return_url, 'Invalid ID');
}
?>
