<?php include('includes/header.php') ?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow">
        <div class="card-header">
            <h4 class="mb-0">Rose Ann Bonador
                <a href="grades.php" class="btn btn-primary float-end">Back</a>
            </h4>
        </div>
        <div class="card-body">
            <?php alertMessage(); ?>
            <form action="code.php" method="POST">
                <?php
                $parmValue = checkParamId('id');
                if (!is_numeric($parmValue)) {
                    echo '<h5>' . $parmValue . '</h5>';
                    return false;
                }

                $student = getById('students', $parmValue);
                if ($student['status'] == 200) {

                ?>
                    <input type="hidden" name="studentId" value="<?= $student['data']['id']; ?>" />
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="">Section *</label>
                            <select id="section_id" name="section" class="form-control select2" style="width: 100%;">
                                <option value="" selected disabled>-- Select --</option>
                                <?php
                                $subjects = getAll('classes');
                                if ($subjects && mysqli_num_rows($subjects) > 0) {
                                    while ($subject = mysqli_fetch_assoc($subjects)) {
                                        echo '<option value="' . $subject['id'] . '">' . $subject['name'] . '</option>';
                                    }
                                } else {
                                    echo '<option value="">No subjects available</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <!-- Display separate tables for each semester -->
                            <h5>First Semester</h5>
                            <table id="semester1-table" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th width="70%">Subject</th>
                                        <th class="text-center" width="15%">Q1</th>
                                        <th class="text-center" width="15%">Q2</th>
                                        <th width="15%">Final</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>

                            <h5>Second Semester</h5>
                            <table id="semester2-table" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th width="70%">Subject</th>
                                        <th class="text-center" width="15%">Q3</th>
                                        <th class="text-center" width="15%">Q4</th>
                                        <th width="15%">Final</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>

                        <div class="col-md-12 mb-3 text-end">
                            <button type="submit" name="updateStudent" class="btn btn-primary">Update</button>
                        </div>
                    </div>
                <?php
                } else {
                    echo '<h5>' . $student['message'] . '</h5>';
                }
                ?>
            </form>
        </div>
    </div>
</div>

<?php include('includes/footer.php') ?>
<script>
    $(document).ready(function() {
        $('#section_id').change(function() {
            var sectionId = $(this).val();
            $.ajax({
                url: 'code.php',
                type: 'POST',
                data: {
                    sectionId: sectionId
                },
                success: function(response) {
                    // Split the response into semester 1 and semester 2 data
                    var data = JSON.parse(response);
                    $('#semester1-table tbody').html(data.semester1);
                    $('#semester2-table tbody').html(data.semester2);
                }
            });
        });
    });
</script>