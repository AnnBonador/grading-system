<?php include('includes/header.php') ?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow">
        <div class="card-header">
            <h4 class="mb-0">Edit Subject
                <a href="subjects.php" class="btn btn-primary float-end">Back</a>
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

                $subject = getById('subjects', $parmValue);
                if ($subject['status'] == 200) {

                ?>
                    <input type="hidden" name="subjectId" value="<?= $subject['data']['id']; ?>" />
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="">Subject Name *</label>
                            <input type="text" name="name" value="<?= $subject['data']['name']; ?>" class="form-control" required />
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="">Subject Code </label>
                            <input type="text" name="subject_code" value="<?= $subject['data']['subject_code']; ?>" class="form-control" />
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="">Subject Type *</label>
                            <select name="subject_type" class="form-control" required>
                                <option value="">-- Select --</option>
                                <option value="1" <?= $subject['data']['subject_type'] == 1 ? 'selected' : ''; ?>>Core Subjects</option>
                                <option value="2" <?= $subject['data']['subject_type'] == 2 ? 'selected' : ''; ?>>Applied and Specialized Subjects</option>
                            </select>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="form-check">
                                <input class="form-check-input" name="status" type="checkbox" <?= $subject['data']['status'] == true ? 'checked' : ''; ?>>
                                <label class="form-check-label">Status (unchecked=visible, checked=hidden)</label>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3 text-end">
                            <button type="submit" name="updateSubject" class="btn btn-primary">Update</button>
                        </div>
                    </div>
                <?php
                } else {
                    echo '<h5>' . $subject['message'] . '</h5>';
                }
                ?>

            </form>
        </div>
    </div>
</div>

<?php include('includes/footer.php') ?>