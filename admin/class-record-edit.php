<?php include('includes/header.php') ?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow">
        <div class="card-header">
            <h4 class="mb-0">Edit Class Record
                <a href="class-record.php" class="btn btn-primary float-end">Back</a>
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

                $record = getById('class_record', $parmValue);
                if ($record['status'] == 200) {
                ?>
                    <div class="row">
                        <input type="hidden" name="recordId" value="<?= $record['data']['id']; ?>" />
                        <div class="col-md-12 mb-3">
                            <label for="">Name *</label>
                            <input type="text" class="form-control" name="name" value="<?= $record['data']['name']; ?>" required>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="">Class *</label>
                            <select name="class" class="form-control select2" style="width: 100%;" required>
                                <option value="" <?= $record['data']['class_id'] === null ? 'selected' : ''; ?> disabled>-- Select --</option>
                                <?php
                                $classes = getAll('classes');
                                if ($classes && mysqli_num_rows($classes) > 0) {
                                    while ($class = mysqli_fetch_assoc($classes)) {
                                        $selected = $class['id'] == $record['data']['class_id'] ? 'selected' : '';
                                        echo '<option value="' . $class['id'] . '" ' . $selected . '>' . $class['name'] . '</option>';
                                    }
                                } else {
                                    echo '<option value="">No class available</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="">Adviser</label>
                            <select name="adviser" class="form-control select2" style="width: 100%;">
                                <option value="" <?= $record['data']['adviser'] === null ? 'selected' : ''; ?> disabled>-- Select --</option>
                                <?php
                                $teachers = getTeachers('admins');
                                if ($teachers && mysqli_num_rows($teachers) > 0) {
                                    while ($teacher = mysqli_fetch_assoc($teachers)) {
                                        $selected = $teacher['id'] == $record['data']['adviser'] ? 'selected' : '';
                                        echo '<option value="' . $teacher['id'] . '" ' . $selected . '>' . $teacher['name'] . '</option>';
                                    }
                                } else {
                                    echo '<option value="">No teachers available</option>';
                                }
                                ?>
                            </select>
                        </div>

                        <div class="col-md-12 mb-3 text-end">
                            <button type="submit" name="updateClassRecord" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                <?php
                } else {
                    echo '<h5>' . $record['message'] . '</h5>';
                }


                ?>
            </form>
        </div>
    </div>
</div>

<?php include('includes/footer.php') ?>