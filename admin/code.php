<?php

include('../config/function.php');

if (isset($_POST['saveAdmin'])) {
    $name = validate($_POST['name']);
    $email = validate($_POST['email']);
    $role = validate($_POST['role']);
    $password = validate($_POST['password']);
    $username = validate($_POST['username']);

    if ($name != '' && $email != '' && $password != '' && $username != '' && $role != '') {
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
            'role' => $role,
            'email' => $email,
            'password' => $bcrypt_password
        ];
        $result = insert('admins', $data);
        if ($result) {
            redirect('admins.php', 'User Created Successfully');
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
    $role = validate($_POST['role']);
    $password = validate($_POST['password']);
    $username = validate($_POST['username']);

    if ($password != '') {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    } else {
        $hashedPassword = $adminData['data']['password'];
    }

    if ($name != '' && $email != '' && $username != '' && $role != '') {
        $data = [
            'username' => $username,
            'name' => $name,
            'role' => $role,
            'email' => $email,
            'password' => $hashedPassword
        ];
        $result = update('admins', $adminId, $data);
        if ($result) {
            redirect('admins-edit.php?id=' . $adminId, 'User Updated Successfully');
        } else {
            redirect('admins-edit.php?id=' . $adminId, 'Something went wrong');
        }
    } else {
        redirect('admins-edit.php?id=' . $adminId, 'Please fill required fields.');
    }
}

if (isset($_POST['saveSubject'])) {
    $name = validate($_POST['name']);
    $subject_code = validate($_POST['subject_code']);
    $status = isset($_POST['status']) ? 1 : 0;
    $subject_type = validate($_POST['subject_type']);

    if (!isNameUnique('subjects', $name)) {
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

    if (!isNameUnique('subjects', $name, $subjectId)) {
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
    $status = isset($_POST['status']) ? 1 : 0;

    if (!isNameUnique('students', $name)) {
        redirect('students-create.php', 'Student name already exists');
    } else {
        $data = [
            'name' => $name,
            'age' => $birthday,
            'gender' => $gender,
            'lrn' => $lrn,
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
    $status = isset($_POST['status']) ? 1 : 0;

    if (!isNameUnique('students', $name, $studentId)) {
        redirect('students-edit.php?id=' . $studentId, 'Student name already exists');
    } else {
        $data = [
            'name' => $name,
            'age' => $birthday,
            'gender' => $gender,
            'lrn' => $lrn,
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

if (isset($_POST['saveClass'])) {
    $classDataJson = $_POST['classData'];

    $classDataArray = json_decode($classDataJson, true);

    $className = $classDataArray['name'];
    $academicYear = $classDataArray['academic_year'];
    $semesters = $classDataArray['semesters'];

    if (!isNameUnique('classes', $className)) {
        $response = array("success" => false, "message" => "Class name already exists");
    } else {
        $data = [
            'name' => $className,
            'academic_year' => $academicYear,
            'subjects' => json_encode($semesters)
        ];

        $result = insert('classes', $data);

        if ($result) {
            $response = array("success" => true, "message" => "Class Created Successfully");
        } else {
            $response = array("success" => false, "message" => "Something went wrong");
        }
    }
    echo json_encode($response);
}

if (isset($_POST['updateClass'])) {
    $classDataJson = $_POST['classData'];

    $classDataArray = json_decode($classDataJson, true);

    $classId = $classDataArray['classId'];
    $className = $classDataArray['name'];
    $academicYear = $classDataArray['academic_year'];
    $semesters = $classDataArray['semesters'];

    if (!isNameUnique('classes', $className, $classId)) {
        $response = array("success" => false, "message" => "Class name already exists");
    } else {
        $data = [
            'name' => $className,
            'academic_year' => $academicYear,
            'subjects' => json_encode($semesters)
        ];
        $result = update('classes', $classId, $data);
        if ($result) {
            $response = array("success" => true, "message" => "Class Updated Successfully");
        } else {
            $response = array("success" => false, "message" => "Something went wrong");
        }
    }
    echo json_encode($response);
}


if (isset($_POST['sectionId'])) {
    $sectionId = $_POST['sectionId'];

    $query = "SELECT * FROM classes WHERE id='$sectionId'";
    $result = mysqli_query($conn, $query);

    $tableRowsSemester1 = '';
    $tableRowsSemester2 = '';

    if (mysqli_num_rows($result) > 0) {
        $classData = mysqli_fetch_assoc($result);
        $subjectsData = json_decode($classData['subjects'], true);

        foreach ($subjectsData as $semester) {
            $semesterNumber = $semester['semester'];
            $tableRows = '';

            foreach ($semester['subjects'] as $subject) {
                $subjectId = $subject['subject_id'];

                $subjectQuery = "SELECT name FROM subjects WHERE id='$subjectId'";
                $subjectResult = mysqli_query($conn, $subjectQuery);
                $subjectRow = mysqli_fetch_assoc($subjectResult);
                $subjectName = $subjectRow['name'];

                $tableRows .= '<tr>';
                $tableRows .= '<td>' . $subjectName . '</td>';
                $tableRows .= '<td><input type="number" class="form-control text-end" name="quarter1_' . $subjectId . '"/></td>'; 
                $tableRows .= '<td><input type="number" class="form-control text-end" name="quarter2_' . $subjectId . '"/></td>'; 
                $tableRows .= '<td></td>';
                $tableRows .= '</tr>';
            }

            // Include the "General Average" row for displaying final grades
            $generalAverageRow = '<tr>';
            $generalAverageRow .= '<td class="text-end" colspan="3">General Average for the Semester</td>';
            $generalAverageRow .= '<td class="fw-bold text-center"></td>';
            $generalAverageRow .= '</tr>';

            if ($semesterNumber == 1) {
                $tableRowsSemester1 = $tableRows . $generalAverageRow;
            } elseif ($semesterNumber == 2) {
                $tableRowsSemester2 = $tableRows . $generalAverageRow;
            }
        }
    }

    $response = array(
        'semester1' => $tableRowsSemester1,
        'semester2' => $tableRowsSemester2
    );

    echo json_encode($response);
}

if (isset($_POST['saveGrade'])) {
    // Decode the JSON data received
    $grades = json_decode($_POST['grades'], true);

    // Extract data from the decoded JSON
    $studentId = $grades['studentId'];
    $sectionId = $grades['sectionId'];
    $semester1Data = $grades['semester1'];
    $semester2Data = $grades['semester2'];

    // Prepare the JSON data to be stored in the 'grades' column
    $gradesData = json_encode([
        'semester1' => $semester1Data,
        'semester2' => $semester2Data
    ]);

    $data = [
        'student_id' => $studentId,
        'class_id' => $sectionId,
        'grades' => $gradesData
    ];

    $result = insert('grades', $data);

    if ($result) {
        $response = array("success" => true, "message" => "Grades Save Successfully");
    } else {
        $response = array("success" => false, "message" => "Something went wrong");
    }

    echo json_encode($response);
}



