<?php
session_start();

require 'dbcon.php';

function validate($inputData)
{

    global $conn;
    $validatedData = mysqli_real_escape_string($conn, $inputData);
    return trim($validatedData);
}

function redirect($url, $status)
{

    $_SESSION['status'] = $status;
    header('Location: ' . $url);
    exit(0);
}

function alertMessage()
{
    if (isset($_SESSION['status'])) {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <h6>' . $_SESSION['status'] . '</h6>
            <button type="button" class="btn btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
        unset($_SESSION['status']);
    }
}

function insert($tableName, $data)
{

    global $conn;

    $table = validate($tableName);

    $columns = array_keys($data);
    $values = array_values($data);

    $finalColumn = implode(',', $columns);
    $finalValues = "'" . implode("', '", $values) . "'";

    $query = "INSERT INTO $table ($finalColumn) VALUES ($finalValues)";
    $result = mysqli_query($conn, $query);
    return $result;
}

function update($tableName, $id, $data)
{

    global $conn;

    $table = validate($tableName);
    $id = validate($id);

    $updateDataString = "";

    foreach ($data as $column => $value) {
        $updateDataString .= $column . '=' . "'$value',";
    }

    $finalUpdateData = substr(trim($updateDataString), 0, -1);

    $query = "UPDATE $table SET $finalUpdateData WHERE id='$id'";
    $result = mysqli_query($conn, $query);
    return $result;
}

function getAll($tableName, $status = NULL)
{

    global $conn;

    $table = validate($tableName);
    $status = validate($status);

    if ($status == 'status') {
        $query = "SELECT * FROM $table WHERE status='0'";
    } else {
        $query = "SELECT * FROM $table";
    }
    return mysqli_query($conn, $query);
}

function getById($tableName, $id)
{

    global $conn;

    $table = validate($tableName);
    $id = validate($id);

    $query = "SELECT * FROM $table WHERE id='$id' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if ($result) {
        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);
            $response = [
                'status' => 200,
                'data' => $row,
                'message' => 'Record Found'
            ];
            return $response;
        } else {
            $response = [
                'status' => 404,
                'message' => 'No Data Found'
            ];
            return $response;
        }
    } else {
        $response = [
            'status' => 500,
            'message' => 'Something Went Wrong'
        ];
        return $response;
    }
}

function delete($tableName, $id)
{
    global $conn;

    $table = validate($tableName);
    $id = validate($id);

    $query = "DELETE FROM $table WHERE ID='$id' LIMIT 1";
    $result = mysqli_query($conn, $query);
    return $result;
}

function checkParamId($type)
{
    if (isset($_GET[$type])) {
        if ($_GET[$type] != '') {
            return $_GET[$type];
        } else {
            return '<h5>No Id Found</h5>';
        }
    } else {
        return '<h5>No Id Given</h5>';
    }
}

function logoutSession()
{
    unset($_SESSION['loggedIn']);
    unset($_SESSION['loggedInUser']);
}

function executeQuery($query, $params = [])
{
    global $conn;
    $stmt = $conn->prepare($query);
    if (!empty($params)) {
        $types = str_repeat('s', count($params));
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

function isNameUnique($table, $name, $excludeId = null)
{
    $query = "SELECT COUNT(*) as count FROM $table WHERE name = ?";
    $params = [$name];
    if ($excludeId) {
        $query .= " AND id != ?";
        $params[] = $excludeId;
    }
    $result = executeQuery($query, $params);
    return $result['count'] == 0;
}

function isStudentIdUniqueForRecord($table, $student_id, $record_id, $excludeId = null)
{
    // Construct the SQL query
    $query = "SELECT COUNT(*) as count FROM $table WHERE student_id = ? AND record_id = ?";
    $params = [$student_id, $record_id];

    if ($excludeId) {
        $query .= " AND id != ?";
        $params[] = $excludeId;
    }

    $result = executeQuery($query, $params);
    return $result['count'] == 0;
}


function calculateAge($birthDate)
{
    // Create a DateTime object from the birth date
    $birthDate = new DateTime($birthDate);
    $currentDate = new DateTime();
    $age = $currentDate->diff($birthDate);
    return $age->y;
}

function convertToDateOnly($datetime)
{
    // Create a DateTime object from the datetime string
    $date = new DateTime($datetime);

    // Format the DateTime object to only display the date
    return $date->format('Y-m-d');
}

function getTeachers($tableName)
{

    global $conn;

    $table = validate($tableName);

    $query = "SELECT * FROM $table WHERE role = 'Teacher'";

    return mysqli_query($conn, $query);
}

function getCount($tableName)
{
    global $conn;
    $table = validate($tableName);
    $query = "SELECT * FROM $table";
    $query_run = mysqli_query($conn, $query);
    if ($query_run) {
        $totalCount = mysqli_num_rows($query_run);
        return $totalCount;
    } else {
        return 'Something Went Wrong!';
    }
}

function getName($table, $id)
{
    global $conn;

    $query = "SELECT name FROM $table WHERE id='$id'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);

    if ($row) {
        echo $row['name'];
    } else {
        // Handle case where no rows were returned
        echo "No data found";
    }
}
function generateTable($class_id)
{
    global $conn;
    $tableRowsSemester1 = '';
    $tableRowsSemester2 = '';

    $query = "SELECT * FROM classes WHERE id='$class_id'";
    $result = mysqli_query($conn, $query);

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
                $tableRows .= '<td><input type="hidden" name="subject_id[]" value="' . $subjectId . '"/>' . $subjectName . '</td>';
                $tableRows .= '<td><input type="number" class="form-control text-end" name="quarter1_' . $subjectId . '" /></td>';
                $tableRows .= '<td><input type="number" class="form-control text-end" name="quarter2_' . $subjectId . '"/></td>';
                $tableRows .= '<td></td>';
                $tableRows .= '</tr>';
            }

            // Based on semester number, assign table rows to respective variables
            if ($semesterNumber == 1) {
                $tableRowsSemester1 = $tableRows;
            } elseif ($semesterNumber == 2) {
                $tableRowsSemester2 = $tableRows;
            }
        }
    }

    // Return an associative array containing table rows for each semester
    return array('semester1' => $tableRowsSemester1, 'semester2' => $tableRowsSemester2);
}

function retrieveTable($class_id, $grades_json)
{
    global $conn;
    $tableRowsSemester1 = '';
    $tableRowsSemester2 = '';

    $query = "SELECT * FROM classes WHERE id='$class_id'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $classData = mysqli_fetch_assoc($result);
        $subjectsData = json_decode($classData['subjects'], true);
        $grades = json_decode($grades_json, true); // Decode grades JSON string

        foreach ($subjectsData as $semester) {
            $semesterNumber = $semester['semester'];
            $tableRows = '';

            foreach ($semester['subjects'] as $subject) {
                $subjectId = $subject['subject_id'];

                $subjectQuery = "SELECT name FROM subjects WHERE id='$subjectId'";
                $subjectResult = mysqli_query($conn, $subjectQuery);
                $subjectRow = mysqli_fetch_assoc($subjectResult);
                $subjectName = $subjectRow['name'];

                // Find the grades for the current subject
                $quarter1_grade = '';
                $quarter2_grade = '';
                $final_grade = '';

                // Check if grades data is available for the current semester
                if (isset($grades['semester' . $semesterNumber]) && is_array($grades['semester' . $semesterNumber])) {
                    // Search for grades data in $grades
                    foreach ($grades['semester' . $semesterNumber] as $grade) {
                        if ($grade['subject_id'] == $subjectId) {
                            $quarter1_grade = $grade['quarter_1_grade'];
                            $quarter2_grade = $grade['quarter_2_grade'];
                            $final_grade = isset($grade['final_grade']) ? $grade['final_grade'] : '';
                            break; // Stop searching once found
                        }
                    }
                }

                // Populate table rows with grades
                $tableRows .= '<tr>';
                $tableRows .= '<td><input type="hidden" name="subject_id[]" value="' . $subjectId . '"/>' . $subjectName . '</td>';
                $tableRows .= '<td><input type="number" class="form-control text-end" name="quarter1_' . $subjectId . '" value="' . $quarter1_grade . '" /></td>';
                $tableRows .= '<td><input type="number" class="form-control text-end" name="quarter2_' . $subjectId . '" value="' . $quarter2_grade . '" /></td>';
                $tableRows .= '<td>' . $final_grade . '</td>';
                $tableRows .= '</tr>';
            }

            // Based on semester number, assign table rows to respective variables
            if ($semesterNumber == 1) {
                $tableRowsSemester1 = $tableRows;
            } elseif ($semesterNumber == 2) {
                $tableRowsSemester2 = $tableRows;
            }
        }
    }

    // Return an associative array containing table rows for each semester
    return array('semester1' => $tableRowsSemester1, 'semester2' => $tableRowsSemester2);
}

function getGrades($tableName, $id)
{

    global $conn;

    $table = validate($tableName);

    $query = "SELECT * FROM $table WHERE record_id='$id'";

    return mysqli_query($conn, $query);
}

function viewTeacherSubjects() {
    global $conn;

    $loggedInUserId = $_SESSION['loggedInUser']['user_id'];
    $sql = "SELECT id, name, academic_year, subjects FROM classes";
    $result = mysqli_query($conn, $sql);

    // Check if any classes were found
    $assignedSubjects = [];
    $subjectIds = [];
    if (mysqli_num_rows($result) > 0) {
        // Process each class
        while ($row = mysqli_fetch_assoc($result)) {
            // Decode the JSON subjects data
            $subjectsData = json_decode($row['subjects'], true);

            // Loop through the semesters and subjects
            foreach ($subjectsData as $semester) {
                foreach ($semester['subjects'] as $subject) {
                    // Check if the teacher ID matches the logged-in user ID
                    if ($subject['teacher_id'] == $loggedInUserId) {
                        // Check for distinct subject_id
                        if (!in_array($subject['subject_id'], $subjectIds)) {
                            $subjectIds[] = $subject['subject_id'];
                            $assignedSubjects[] = [
                                'class_id' => $row['id'],
                                'class_name' => $row['name'],
                                'academic_year' => $row['academic_year'],
                                'semester' => $semester['semester'],
                                'subject_id' => $subject['subject_id']
                            ];
                        }
                    }
                }
            }
        }
    }

    return $assignedSubjects;
}

function getSectionsForSubject($subject_id, $user_id) {
    global $conn;
    // Initialize an empty array to store sections
    $sections = [];

    // Fetch classes associated with the subject_id and where the logged-in user is the teacher
    $sql = "SELECT classes.id AS class_id, class_record.id AS record_id, class_record.name AS class_name, classes.academic_year, classes.subjects 
            FROM classes 
            INNER JOIN class_record ON classes.id = class_record.class_id";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        // Process each class
        while ($row = mysqli_fetch_assoc($result)) {
            // Check if the user is assigned to the subject in this class
            $subjectsData = json_decode($row['subjects'], true);
            foreach ($subjectsData as $semester) {
                foreach ($semester['subjects'] as $subject) {
                    if ($subject['subject_id'] == $subject_id && $subject['teacher_id'] == $user_id) {
                        $sections[] = [
                            'record_id' => $row['record_id'],
                            'class_id' => $row['class_id'],
                            'class_name' => $row['class_name'],
                            'academic_year' => $row['academic_year'],
                            'semester' => $semester['semester']
                        ];
                    }
                }
            }
        }
    }

    return $sections;
}


function getStudentsGrades($record_id, $subject_id, $semester) {
    global $conn;
    // Initialize an empty array to store students' grades
    $students = [];

    // Prepare and execute SQL query to fetch students' grades
    $sql = "SELECT student_id, id, grades FROM grades WHERE record_id = $record_id";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        // Process each row of the result set
        while ($row = mysqli_fetch_assoc($result)) {
            // Decode the JSON column
            $grades = json_decode($row['grades'], true);

            // Find the correct subject and semester in the JSON data
            $quarter_1_grade = '';
            $quarter_2_grade = '';
            if (isset($grades['semester' . $semester])) {
                foreach ($grades['semester' . $semester] as $subject_grades) {
                    if ($subject_grades['subject_id'] == $subject_id) {
                        $quarter_1_grade = $subject_grades['quarter_1_grade'];
                        $quarter_2_grade = $subject_grades['quarter_2_grade'];
                        break;
                    }
                }
            }

            $students[] = [
                'grade_id' => $row['id'],
                'student_id' => $row['student_id'],
                'quarter_1_grade' => $quarter_1_grade,
                'quarter_2_grade' => $quarter_2_grade,
            ];
        }
    }

    return $students;
}

