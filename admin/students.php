<?php include('includes/header.php') ?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow">
        <div class="card-header">
            <h4 class="mb-0">Students
                <a href="students-create.php" class="btn btn-primary float-end">Add Student</a>
            </h4>
        </div>
        <div class="card-body">
            <?php alertMessage(); ?>
            <?php
            $students = getAll('students');
            if (!$students) {
                echo '<h4>Something Went Wrong!</h4>';
                return false;
            }
            if (mysqli_num_rows($students) > 0) {

            ?>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered" id="students_table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Age</th>
                                <th>Gender</th>
                                <th>LRN</th>
                                <th>Date Created</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($students as  $item) : ?>
                                <tr>
                                    <td><?= $item['id'] ?></td>
                                    <td><?= $item['name'] ?></td>
                                    <td><?= calculateAge($item['age']); ?></td>
                                    <td>
                                        <?php
                                        if ($item['gender'] === 'm') {
                                            echo 'Male';
                                        } elseif ($item['gender'] === 'f') {
                                            echo 'Female';
                                        } else {
                                            echo 'Unknown';
                                        }
                                        ?>
                                    </td>
                                    <td><?= $item['lrn'] ?></td>
                                    <td><?= convertToDateOnly($item['created_at']) ?></td>
                                    <td>
                                        <a href="students-edit.php?id=<?= $item['id']; ?>" class="btn btn-success btn-sm">Edit</a>
                                        <a href="students-delete.php?id=<?= $item['id']; ?>" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Are you sure you want to delete this data?')">Delete</a>
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
    $('#students_table').DataTable();
});
</script>