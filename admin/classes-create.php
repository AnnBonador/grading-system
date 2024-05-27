<?php include('includes/header.php') ?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow">
        <div class="card-header">
            <h4 class="mb-0">Add Class
                <a href="classes.php" class="btn btn-primary float-end">Back</a>
            </h4>
        </div>
        <div class="card-body">
            <?php alertMessage(); ?>
            <div id="alert-container"></div>
            <form id="saveClassForm">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="">Class Name *</label>
                        <input type="text" name="name" class="form-control" required />
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="">Academic Year *</label>
                        <select name="academic_year" class="form-control select2" required>
                            <option value="">-- Select --</option>
                            <option value="2023-2024">2023-2024</option>
                            <option value="2024-2025">2024-2025</option>
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
                                <tbody></tbody>
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
                                <tbody></tbody>
                            </table>
                            <button type="button" class="btn btn-success" id="addSecondSemesterRow">Add Row</button>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-3 text-end">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>

<?php include('includes/footer.php') ?>
<script src="assets/js/classes/index.js"></script>
<script>
    $(document).ready(function() {
        addRow('#firstSemesterTable tbody', 'first_semester');
        addRow('#secondSemesterTable tbody', 'second_semester');
    });

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