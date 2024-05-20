<?php include('includes/header.php') ?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow">
        <div class="card-header">
            <h4 class="mb-0">Subjects
                <a href="subjects-create.php" class="btn btn-primary float-end">Add Subject</a>
            </h4>
        </div>
        <div class="card-body">
            <?php alertMessage(); ?>
            <?php
            $subjects = getAll('subjects');
            if (!$subjects) {
                echo '<h4>Something Went Wrong!</h4>';
                return false;
            }
            if (mysqli_num_rows($subjects) > 0) {

            ?>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered" id="subjects_table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Subject Code</th>
                                <th>Subject Type</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($subjects as  $item) : ?>
                                <tr>
                                    <td><?= $item['id'] ?></td>
                                    <td><?= $item['name'] ?></td>
                                    <td><?= $item['subject_code'] ?></td>
                                    <td>
                                        <?php
                                        if ($item['subject_type'] == 1) {
                                            echo 'Core Subjects';
                                        } elseif ($item['subject_type'] == 2) {
                                            echo 'Applied Subjects';
                                        } elseif ($item['subject_type'] == 3) {
                                            echo 'Specialized Subjects';
                                        } else {
                                            echo 'Unknown';
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        if ($item['status'] == 1) {
                                            echo '<span class="badge bg-success">Inactive</span>';
                                        } else {
                                            echo '<span class="badge bg-primary">Active</span>';
                                        } ?>
                                    </td>
                                    <td>
                                        <a href="subjects-edit.php?id=<?= $item['id']; ?>" class="btn btn-success btn-sm">Edit</a>
                                        <a href="subjects-delete.php?id=<?= $item['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tr>
                        </tbody>
                    </table>
                </div>
            <?php
            } else {
            ?>
                <h4 class="mb-0">No Record found</h4>
            <?php

            }
            ?>
        </div>
    </div>
</div>

<?php include('includes/footer.php') ?>
<script>
$(document).ready(function() {
    $('#subjects_table').DataTable();
});
</script>