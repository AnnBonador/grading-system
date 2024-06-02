<?php include('includes/header.php') ?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow">
        <div class="card-header">
            <h4 class="mb-0">Class
                <a href="classes-create.php" class="btn btn-primary float-end">Add Class</a>
            </h4>
        </div>
        <div class="card-body">
            <?php alertMessage(); ?>
            <?php
            $classes = getAll('classes');
            if (!$classes) {
                echo '<h4>Something Went Wrong!</h4>';
                return false;
            }
            if (mysqli_num_rows($classes) > 0) {

            ?>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered" id="classes_table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Class Name</th>
                                <th>Academic Year</th>
                                <th>Date Created</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($classes as  $item) : ?>
                                <tr>
                                    <td><?= $item['id'] ?></td>
                                    <td><?= $item['name'] ?></td>
                                    <td><?= $item['academic_year'] ?></td>
                                    <td><?= convertToDateOnly($item['created_at']) ?></td>
                                    <td>
                                        <a href="classes-edit.php?id=<?= $item['id']; ?>" class="btn btn-success btn-sm">Edit</a>
                                        <a href="classes-delete.php?id=<?= $item['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this data?')">Delete</a>
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
    $('#classes_table').DataTable({
        "order": [[0, "desc"]] 
    });
});
</script>