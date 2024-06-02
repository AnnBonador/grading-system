<?php

include('../config/function.php');

$paraResultId = checkParamId('id');
if (is_numeric($paraResultId)) {

    $recordId = validate($paraResultId);

    $record = getById('class_record', $recordId);
    if ($record['status'] == 200) {
        $recordDelete = delete('class_record', $recordId);
        if ($recordDelete) {
            redirect('class-record.php', 'Class Record Deleted Successfully');
        } else {
            redirect('class-record.php', 'Something Went Wrong');
        }
    } else {
        redirect('class-record.php', $record['message']);
    }
} else {
    redirect('class-record.php', 'Something Went Wrong');
}
