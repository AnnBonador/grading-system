<?php include('includes/header.php') ?>

<div class="container-fluid px-4">
    <div class="card mt-4">
        <div class="card-header">
            <h4 class="mb-0"><?php getName('class_record', $_GET['class-record-id']); ?>
                <a href="teacher-view.php?subject-id=<?= $_GET['subject-id']; ?>" class="btn btn-primary float-end">Back</a>
            </h4>
        </div>
        <div class="card-body">
            <div id="alert-container"></div>
            <form id="gradesForm">
                <div class="row mt-4">
                    <input type="hidden" name="subject_id" value="<?php echo htmlspecialchars($_GET['subject-id']); ?>">
                    <input type="hidden" name="semester" value="<?php echo htmlspecialchars($_GET['semester']); ?>">
                    <div class="table-responsive">
                        <?php
                        $parmValue = checkParamId('class-record-id');
                        if (!is_numeric($parmValue)) {
                            echo '<h5>' . $parmValue . '</h5>';
                            return false;
                        }
                        $subject_id = $_GET['subject-id'];
                        $semester = $_GET['semester'];
                        $students = getStudentsGrades($parmValue, $subject_id, $semester);
                        if($students){
                        ?>
                        <table class="table table-sm table-bordered" id="tblGrades" style="width:100%">
                            <thead>
                                <tr class="text-center">
                                    <th width="50%">Students</th>
                                    <?php if ($semester == 1) : ?>
                                        <th>Q1</th>
                                        <th>Q2</th>
                                    <?php elseif ($semester == 2) : ?>
                                        <th>Q3</th>
                                        <th>Q4</th>
                                    <?php endif; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($students as $student) : ?>
                                    <tr>
                                        <td>
                                            <input type="hidden" name="record_ids[]" value="<?= $student['grade_id'] ?>">
                                            <?= getName('students', $student['student_id']); ?>
                                        </td>
                                        <td><input type="number" class="form-control text-end" name="quarter_1_grades[<?= $student['grade_id'] ?>]" value="<?= $student['quarter_1_grade'] ?>"></td>
                                        <td><input type="number" class="form-control text-end" name="quarter_2_grades[<?= $student['grade_id'] ?>]" value="<?= $student['quarter_2_grade'] ?>"></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <button type="button" id="submitGradesBtn" class="btn btn-primary float-end">Submit</button>
                        <?php
                } else {
                    echo '<h5>No Students Found</h5>';
                }
                ?>
                    </div>

                </div>
            </form>
        </div>
    </div>

</div>

<?php include('includes/footer.php') ?>
<script>
    $(document).ready(function() {
        $("#submitGradesBtn").click(function() {
            // Construct form data manually
            var formData = new FormData();
            formData.append('updatePerSub', true); // Add updateGrades key-value pair
            formData.append('subject_id', $('input[name="subject_id"]').val());
            formData.append('semester', $('input[name="semester"]').val());

            // Loop through each student's record
            $('input[name="record_ids[]"]').each(function() {
                var record_id = $(this).val();
                formData.append('record_ids[]', record_id);
                formData.append('grades[' + record_id + '][quarter_1]', $('input[name="quarter_1_grades[' + record_id + ']"]').val());
                formData.append('grades[' + record_id + '][quarter_2]', $('input[name="quarter_2_grades[' + record_id + ']"]').val());
            });

            // Send AJAX request
            $.ajax({
                type: "POST",
                url: "code.php",
                data: formData,
                processData: false,
                contentType: false,
                dataType: "json",
                success: function(response) {
                    if (response.success) {
                        showAlert("success", response.message);
                    } else {
                        showAlert("warning", response.message);
                    }
                },
            });
        });
    });
</script>