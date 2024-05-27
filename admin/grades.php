<?php include('includes/header.php') ?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow">
        <div class="card-header">
            <h4 class="mb-0">Student Record
                <a href="subjects-create.php" class="btn btn-primary float-end">Add Grades</a>
            </h4>
        </div>
        <div class="card-body">
            <?php alertMessage(); ?>
            <?php
            $subjects = getAll('students');
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
                                <th>LRN NO.</th>
                                <th>Name</th>
                                <th>Gender</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($subjects as  $item) : ?>
                                <tr>
                                    <td><?= $item['id'] ?></td>
                                    <td><?= $item['lrn'] ?></td>
                                    <td><?= $item['name'] ?></td>
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
                                    <td>
                                        <a href="grades-edit.php?id=<?= $item['id']; ?>" class="btn btn-success btn-sm">Edit</a>
                                        <a href="grades-edit.php?id=<?= $item['id']; ?>" class="btn btn-secondary btn-sm">View</a>
                                        <a href="grades-delete.php?id=<?= $item['id']; ?>" class="btn btn-primary btn-sm">Print</a>
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