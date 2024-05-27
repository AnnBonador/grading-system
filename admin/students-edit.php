<?php include('includes/header.php') ?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow">
        <div class="card-header">
            <h4 class="mb-0">Edit Student
                <a href="students.php" class="btn btn-primary float-end">Back</a>
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
                            <label for="">Student Name *</label>
                            <input type="text" name="name" value="<?= $student['data']['name']; ?>" class="form-control" required />
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="">Date of Birth *</label>
                            <input type="date" name="birthday" value="<?= $student['data']['age']; ?>" class="form-control" required />
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="">Gender *</label>
                            <div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gender" id="genderMale" value="m" <?= $student['data']['gender'] == 'm' ? 'checked' : ''; ?> required>
                                    <label class="form-check-label" for="genderMale">Male</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gender" id="genderFemale" value="f" <?= $student['data']['gender'] == 'f' ? 'checked' : ''; ?> required>
                                    <label class="form-check-label" for="genderFemale">Female</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="">LRN *</label>
                            <input type="number" name="lrn" class="form-control" value="<?= $student['data']['lrn']; ?>" required />
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="form-check">
                                <input class="form-check-input" name="status" type="checkbox" <?= $student['data']['status'] == true ? 'checked' : ''; ?>>
                                <label class="form-check-label">Status (unchecked=visible, checked=hidden)</label>
                            </div>
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