<?php

include('../config/function.php');

if (isset($_POST['saveAdmin'])) {
    $name = validate($_POST['name']);
    $email = validate($_POST['email']);
    $password = validate($_POST['password']);
    $username = validate($_POST['username']);

    if ($name != '' && $email != '' && $password != '' && $username != '') {
        $emailCheck = mysqli_query($conn, "SELECT * FROM admins WHERE email='$email'");
        if ($emailCheck) {
            if (mysqli_num_rows($emailCheck) > 0) {
                redirect('admins-create.php', 'Email Already used by another user.');
            }
        }

        $bcrypt_password = password_hash($password, PASSWORD_BCRYPT);

        $data = [
            'username' => $username,
            'name' => $name,
            'email' => $email,
            'password' => $bcrypt_password
        ];
        $result = insert('admins', $data);
        if ($result) {
            redirect('admins.php', 'Admin Created Successfully');
        } else {
            redirect('admins-create.php', 'Something went wrong');
        }
    } else {
        redirect('admins-create.php', 'Please fill required fields.');
    }
}


if (isset($_POST['updateAdmin'])) {
    $adminId = validate($_POST['adminId']);

    $adminData = getById('admins', $adminId);
    if ($adminData['status'] != 200) {
        redirect('admins-edit.php?id=' . $adminId, 'Please fill required fields.');
    }

    $name = validate($_POST['name']);
    $email = validate($_POST['email']);
    $password = validate($_POST['password']);
    $username = validate($_POST['username']);

    if ($password != '') {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    } else {
        $hashedPassword = $adminData['data']['password'];
    }

    if ($name != '' && $email != '' && $username != '') {
        $data = [
            'username' => $username,
            'name' => $name,
            'email' => $email,
            'password' => $hashedPassword
        ];
        $result = update('admins', $adminId, $data);
        if ($result) {
            redirect('admins-edit.php?id=' . $adminId, 'Admin Updated Successfully');
        } else {
            redirect('admins-edit.php?id=' . $adminId, 'Something went wrong');
        }
    }
    else{
        redirect('admins-edit.php?id=' . $adminId, 'Please fill required fields.');
    }
}

if (isset($_POST['saveSubject'])) {
    $name = validate($_POST['name']);
    $subject_code = validate($_POST['subject_code']);
    $status = isset($_POST['status']) ? 1 : 0;
    $subject_type = validate($_POST['subject_type']);

    if (!isNameUnique('subjects',$name)) {
        redirect('subjects-create.php', 'Subject name already exists');
    } else {
        $data = [
            'name' => $name,
            'subject_code' => $subject_code,
            'subject_type' => $subject_type,
            'status' => $status
        ];
        $result = insert('subjects', $data);
        if ($result) {
            redirect('subjects.php', 'Subject Created Successfully');
        } else {
            redirect('subjects-create.php', 'Something went wrong');
        }
    }
}

if (isset($_POST['updateSubject'])) {
    $subjectId = validate($_POST['subjectId']);
    $name = validate($_POST['name']);
    $subject_code = validate($_POST['subject_code']);
    $status = isset($_POST['status']) ? 1 : 0;
    $subject_type = validate($_POST['subject_type']);

    if (!isNameUnique('subjects',$name, $subjectId)) {
        redirect('subjects-edit.php?id=' . $subjectId, 'Subject name already exists');
    } else {
        $data = [
            'name' => $name,
            'subject_code' => $subject_code,
            'subject_type' => $subject_type,
            'status' => $status
        ];
        $result = update('subjects', $subjectId, $data);
        if ($result) {
            redirect('subjects-edit.php?id=' . $subjectId, 'Subject Updated Successfully');
        } else {
            redirect('subjects-edit.php?id=' . $subjectId, 'Something went wrong');
        }
    }
}

if (isset($_POST['saveStudent'])) {
    $name = validate($_POST['name']);
    $birthday = validate($_POST['birthday']);
    $gender = validate($_POST['gender']);
    $lrn = validate($_POST['lrn']);
    $section = validate($_POST['section']);
    $status = isset($_POST['status']) ? 1 : 0;

    if (!isNameUnique('students',$name)) {
        redirect('students-create.php', 'Student name already exists');
    } else {
        $data = [
            'name' => $name,
            'age' => $birthday,
            'gender' => $gender,
            'lrn' => $lrn,
            'section' => $section,
            'status' => $status
        ];
        $result = insert('students', $data);
        if ($result) {
            redirect('students.php', 'Student Created Successfully');
        } else {
            redirect('students-create.php', 'Something went wrong');
        }
    }
}

if (isset($_POST['updateStudent'])) {
    $studentId = validate($_POST['studentId']);
    $name = validate($_POST['name']);
    $birthday = validate($_POST['birthday']);
    $gender = validate($_POST['gender']);
    $lrn = validate($_POST['lrn']);
    $section = validate($_POST['section']);
    $status = isset($_POST['status']) ? 1 : 0;

    if (!isNameUnique('students',$name, $studentId)) {
        redirect('students-edit.php?id=' . $studentId, 'Student name already exists');
    } else {
        $data = [
            'name' => $name,
            'age' => $birthday,
            'gender' => $gender,
            'lrn' => $lrn,
            'section' => $section,
            'status' => $status
        ];
        $result = update('students', $studentId, $data);
        if ($result) {
            redirect('students-edit.php?id=' . $studentId, 'Student Updated Successfully');
        } else {
            redirect('students-edit.php?id=' . $studentId, 'Something went wrong');
        }
    }
}