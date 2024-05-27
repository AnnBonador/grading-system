<?php include('includes/header.php') ?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow">
        <div class="card-header">
            <h4 class="mb-0">Edit Class
                <a href="classes.php" class="btn btn-primary float-end">Back</a>
            </h4>
        </div>
        <div class="card-body">
            <?php alertMessage(); ?>
            <div id="alert-container"></div>
            <form id="updateClassForm">
                <?php
                $parmValue = checkParamId('id');
                if (!is_numeric($parmValue)) {
                    echo '<h5>' . $parmValue . '</h5>';
                    return false;
                }

                $class = getById('classes', $parmValue);
                if ($class['status'] == 200) {
                    $classData = $class['data'];
                    $classDetails = json_decode($classData['subjects'], true);
                ?>
                    <input type="hidden" name="classId" value="<?= $classData['id']; ?>" />
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="">Class Name *</label>
                            <input type="text" name="name" value="<?= $classData['name']; ?>" class="form-control" required />
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="">Academic Year *</label>
                            <select name="academic_year" class="form-control select2" required>
                                <option value="">-- Select --</option>
                                <option value="2023-2024" <?= $classData['academic_year'] == '2023-2024' ? 'selected' : ''; ?>>2023-2024</option>
                                <option value="2024-2025" <?= $classData['academic_year'] == '2024-2025' ? 'selected' : ''; ?>>2024-2025</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-4">
                            <div class="table-responsive">
                                <h5>First Semester</h5>
                                <table class="table table-bordered" id="firstSemesterTable">
                                    <thead>
                                        <tr>
                                            <th>Subject *</th>
                                            <th>Assigned Teacher</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (isset($classDetails[0]['subjects'])) : ?>
                                            <?php foreach ($classDetails[0]['subjects'] as $subject) : ?>
                                                <tr>
                                                    <td>
                                                        <select name="subjects[first_semester][]" class="form-control select2" style="width: 100%;" required>
                                                            <?php
                                                            $subjects = getAll('subjects');
                                                            if ($subjects && mysqli_num_rows($subjects) > 0) {
                                                                while ($subj = mysqli_fetch_assoc($subjects)) {
                                                                    $selected = $subj['id'] == $subject['subject_id'] ? 'selected' : '';
                                                                    echo '<option value="' . $subj['id'] . '" ' . $selected . '>' . $subj['name'] . '</option>';
                                                                }
                                                            } else {
                                                                echo '<option value="">No subjects available</option>';
                                                            }
                                                            ?>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select name="teachers[first_semester][]" class="form-control select2" style="width: 100%;">
                                                            <option value="" <?= $subject['teacher_id'] === null ? 'selected' : ''; ?> disabled>-- Select --</option>
                                                            <?php
                                                            $teachers = getTeachers('admins');
                                                            if ($teachers && mysqli_num_rows($teachers) > 0) {
                                                                while ($teacher = mysqli_fetch_assoc($teachers)) {
                                                                    $selected = $teacher['id'] == $subject['teacher_id'] ? 'selected' : '';
                                                                    echo '<option value="' . $teacher['id'] . '" ' . $selected . '>' . $teacher['name'] . '</option>';
                                                                }
                                                            } else {
                                                                echo '<option value="">No teachers available</option>';
                                                            }
                                                            ?>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-danger removeRow">Remove</button>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                                <button type="button" class="btn btn-success" id="addFirstSemesterRow">Add Row</button>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <h5>Second Semester</h5>
                                <table class="table table-bordered" id="secondSemesterTable">
                                    <thead>
                                        <tr>
                                            <th>Subject *</th>
                                            <th>Assigned Teacher</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (isset($classDetails[1]['subjects'])) : ?>
                                            <?php foreach ($classDetails[1]['subjects'] as $subject) : ?>
                                                <tr>
                                                    <td>
                                                        <select name="subjects[second_semester][]" class="form-control select2" style="width: 100%;" required>
                                                            <?php
                                                            $subjects = getAll('subjects');
                                                            if ($subjects && mysqli_num_rows($subjects) > 0) {
                                                                while ($subj = mysqli_fetch_assoc($subjects)) {
                                                                    $selected = $subj['id'] == $subject['subject_id'] ? 'selected' : '';
                                                                    echo '<option value="' . $subj['id'] . '" ' . $selected . '>' . $subj['name'] . '</option>';
                                                                }
                                                            } else {
                                                                echo '<option value="">No subjects available</option>';
                                                            }
                                                            ?>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select name="teachers[second_semester][]" class="form-control select2" style="width: 100%;">
                                                        <option value="" <?= $subject['teacher_id'] === null ? 'selected' : ''; ?> disabled>-- Select --</option>
                                                            <?php
                                                            $teachers = getTeachers('admins');
                                                            if ($teachers && mysqli_num_rows($teachers) > 0) {
                                                                while ($teacher = mysqli_fetch_assoc($teachers)) {
                                                                    $selected = $teacher['id'] == $subject['teacher_id'] ? 'selected' : '';
                                                                    echo '<option value="' . $teacher['id'] . '" ' . $selected . '>' . $teacher['name'] . '</option>';
                                                                }
                                                            } else {
                                                                echo '<option value="">No teachers available</option>';
                                                            }
                                                            ?>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-danger removeRow">Remove</button>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                                <button type="button" class="btn btn-success" id="addSecondSemesterRow">Add Row</button>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3 text-end">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </div>

                <?php
                } else {
                    echo '<h5>' . $class['message'] . '</h5>';
                }
                ?>
            </form>
        </div>
    </div>
</div>


<?php include('includes/footer.php') ?>
<script src="assets/js/classes/index.js"></script>
<script>
    function addRow(tableBody, semester) {
    var newRow = `
    <tr>
        <td>
            <select name="subjects[${semester}][]" class="form-control select2" style="width: 100%;" required>
                <option value="" selected disabled>-- Select --</option>
                <?php
                $subjects = getAll('subjects');
                if ($subjects && mysqli_num_rows($subjects) > 0) {
                    while ($subject = mysqli_fetch_assoc($subjects)) {
                        echo '<option value="' . $subject['id'] . '">' . $subject['name'] . '</option>';
                    }
                } else {
                    echo '<option value="">No subjects available</option>';
                }
                ?>
            </select>
        </td>
        <td>
            <select name="teachers[${semester}][]" class="form-control select2" style="width: 100%;">
                <option value="" selected disabled>-- Select --</option>
                <?php
                $teachers = getTeachers('admins');
                if ($teachers && mysqli_num_rows($teachers) > 0) {
                    while ($teacher = mysqli_fetch_assoc($teachers)) {
                        echo '<option value="' . $teacher['id'] . '">' . $teacher['name'] . '</option>';
                    }
                } else {
                    echo '<option value="">No teachers available</option>';
                }
                ?>
            </select>
        </td>
        <td>
            <button type="button" class="btn btn-danger removeRow">Remove</button>
        </td>
    </tr>
`;
    $(tableBody).append(newRow);
    initializeSelect2WithClose(".select2"); // Re-initialize Select2 for new rows with close button
}
</script>



