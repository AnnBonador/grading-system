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
    $subject_type = validate($_POST['subject_type']);

    if (!isNameUnique('subjects', $name)) {
        redirect('subjects-create.php', 'Subject name already exists');
    } else {
        $data = [
            'name' => $name,
            'subject_code' => $subject_code,
            'subject_type' => $subject_type,
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
    $subject_type = validate($_POST['subject_type']);

    if (!isNameUnique('subjects', $name, $subjectId)) {
        redirect('subjects-edit.php?id=' . $subjectId, 'Subject name already exists');
    } else {
        $data = [
            'name' => $name,
            'subject_code' => $subject_code,
            'subject_type' => $subject_type,
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

    if (!isNameUnique('students', $name)) {
        redirect('students-create.php', 'Student name already exists');
    } else {
        $data = [
            'name' => $name,
            'age' => $birthday,
            'gender' => $gender,
            'lrn' => $lrn,
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

    if (!isNameUnique('students', $name, $studentId)) {
        redirect('students-edit.php?id=' . $studentId, 'Student name already exists');
    } else {
        $data = [
            'name' => $name,
            'age' => $birthday,
            'gender' => $gender,
            'lrn' => $lrn,
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

if (isset($_POST['saveClassRecord'])) {
    $name = validate($_POST['name']);
    $class = validate($_POST['class']);
    $adviser = validate($_POST['adviser']);

    if (!isNameUnique('class_record', $name)) {
        redirect('class-record-create.php', 'Class Record name already exists');
    } else {
        $data = [
            'name' => $name,
            'class_id' => $class,
            'adviser' => $adviser,
        ];
        $result = insert('class_record', $data);
        if ($result) {
            redirect('class-record-create.php', 'Class Record Created Successfully');
        } else {
            redirect('class-record-create.php', 'Something went wrong');
        }
    }
}

if (isset($_POST['updateClassRecord'])) {
    $recordId = $_POST['recordId'];

    $name = validate($_POST['name']);
    $class = validate($_POST['class']);
    $adviser = validate($_POST['adviser']);

    if (!isNameUnique('class_record', $name, $recordId)) {
        redirect('class-record-edit.php?id=' . $recordId, 'Class Record name already exists');
    } else {
        $data = [
            'name' => $name,
            'class_id' => $class,
            'adviser' => $adviser,
        ];
        $result = update('class_record', $recordId, $data);
        if ($result) {
            redirect('class-record-edit.php?id=' . $recordId, 'Class Record Updated Successfully');
        } else {
            redirect('class-record-edit.php?id=' . $recordId, 'Something went wrong');
        }
    }
}

if (isset($_POST['saveGrade'])) {
    // Decode the JSON data received
    $grades = json_decode($_POST['grades'], true);

    // Extract data from the decoded JSON
    $studentId = $grades['studentId'];
    $recordId = $grades['recordId'];
    $semester1Data = $grades['semester1'];
    $semester2Data = $grades['semester2'];
    $genAveFirst = $grades['semester1_final_average'];
    $genAveSecond = $grades['semester2_final_average'];
    if (!isStudentIdUniqueForRecord('grades', $studentId, $recordId)) {
        $response = array("warning" => true, "message" => "Student Already Exists");
    } else {
        $gradesData = json_encode([
            'semester1' => $semester1Data,
            'semester2' => $semester2Data
        ]);

        $data = [
            'student_id' => $studentId,
            'record_id' => $recordId,
            'grades' => $gradesData,
            'gen_avg_first' => $genAveFirst,
            'gen_avg_second' => $genAveSecond
        ];

        $result = insert('grades', $data);

        if ($result) {
            $response = array("success" => true, "message" => "Grades Save Successfully");
        } else {
            $response = array("success" => false, "message" => "Something went wrong");
        }
    }

    echo json_encode($response);
}

if (isset($_POST['updateGrade'])) {

    $grades = json_decode($_POST['grades'], true);

    $gradeId = $grades['gradeId'];

    $studentId = $grades['studentId'];
    $recordId = $grades['recordId'];
    $semester1Data = $grades['semester1'];
    $semester2Data = $grades['semester2'];
    $genAveFirst = $grades['semester1_final_average'];
    $genAveSecond = $grades['semester2_final_average'];
    if (!isStudentIdUniqueForRecord('grades', $studentId, $recordId, $gradeId)) {
        $response = array("warning" => true, "message" => "Student Already Exists");
    } else {
        $gradesData = json_encode([
            'semester1' => $semester1Data,
            'semester2' => $semester2Data
        ]);

        $data = [
            'student_id' => $studentId,
            'record_id' => $recordId,
            'grades' => $gradesData,
            'gen_avg_first' => $genAveFirst,
            'gen_avg_second' => $genAveSecond
        ];

        $result = update('grades', $gradeId, $data);

        if ($result) {
            $response = array("success" => true, "message" => "Grades Updated Successfully");
        } else {
            $response = array("success" => false, "message" => "Something went wrong");
        }
    }

    echo json_encode($response);
}

if (isset($_POST['updatePerSub'])) {
    // Check if all required form fields are present
    if (isset($_POST['subject_id'], $_POST['semester'], $_POST['grades'], $_POST['record_ids'])) {
        $subject_id = $_POST['subject_id'];
        $semester = $_POST['semester'];
        $grades = $_POST['grades'];
        $record_ids = $_POST['record_ids']; // Use record_ids array to identify specific records

        // Loop through record_ids and update grades
        foreach ($record_ids as $record_id) {
            // Get the existing grades JSON for this record_id
            $query = "SELECT grades FROM grades WHERE id = $record_id";
            $result = mysqli_query($conn, $query);

            if ($result && mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $existing_grades_json = $row['grades'];
                mysqli_free_result($result);

                // Decode the existing grades JSON
                $existing_grades = json_decode($existing_grades_json, true);

                // Update the quarter grades for the specific subject ID
                $existing_grades['semester' . $semester] = array_map(function ($subject) use ($subject_id, $grades, $record_id) {
                    if ($subject['subject_id'] == $subject_id) {
                        $subject['quarter_1_grade'] = isset($grades[$record_id]['quarter_1']) ? $grades[$record_id]['quarter_1'] : '';
                        $subject['quarter_2_grade'] = isset($grades[$record_id]['quarter_2']) ? $grades[$record_id]['quarter_2'] : '';
                    }
                    return $subject;
                }, $existing_grades['semester' . $semester]);

                // Encode the updated grades back to JSON
                $updated_grades_json = json_encode($existing_grades);

                // Update the grades in the database
                $query = "UPDATE grades SET grades = '$updated_grades_json' WHERE id = $record_id";
                $result = mysqli_query($conn, $query);

                // Check if the update was successful
                if ($result) {
                    $response = array("success" => true, "message" => "Grades Updated Successfully");
                } else {
                    $response = array("warning" => false, "message" => "Something went wrong");
                }
            } else {
                $response = array("warning" => false, "message" => "No grades found for record ID: $record_id");
            }
        }
    }
    echo json_encode($response);
}

if (isset($_POST['updateProfile'])) {
    $sessionId = validate($_SESSION['loggedInUser']['user_id']);

    $userData = getById('admins', $sessionId);
    if ($userData['status'] != 200) {
        redirect('update-profile.php', 'Please fill required fields.');
    }

    $name = validate($_POST['name']);
    $email = validate($_POST['email']);
    $password = validate($_POST['password']);

    if ($password != '') {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    } else {
        $hashedPassword = $userData['data']['password'];
    }

    if ($name != '' && $email != '') {
        $data = [
            'name' => $name,
            'email' => $email,
            'password' => $hashedPassword
        ];

        $result = update('admins', $sessionId, $data);
        if ($result) {
            // Update session variables with the new data
            $_SESSION['loggedInUser']['name'] = $name;
            $_SESSION['loggedInUser']['email'] = $email;

            redirect('update-profile.php', 'Profile Updated Successfully');
        } else {
            redirect('update-profile.php', 'Something went wrong');
        }
    } else {
        redirect('update-profile.php', 'Please fill required fields.');
    }
}

