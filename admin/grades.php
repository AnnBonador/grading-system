<?php include('includes/header.php') ?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow">
        <div class="card-header">
            <?php if (isset($_GET['name']) && isset($_GET['id'])) : ?>
                <h4 class="mb-0 d-flex justify-content-between align-items-center">
                    <?= htmlspecialchars($_GET['name']) ?>
                    <div>
                        <a href="grades-create.php?id=<?= $_GET['id'] ?>&name=<?= urlencode($_GET['name']) ?>" class="btn btn-primary">Add Student</a>
                        <a href="class-record.php" class="btn btn-primary mr-2">Back</a>
                    </div>
                </h4>
            <?php endif; ?>
        </div>
        <div class="card-body">
            <?php alertMessage(); ?>
            <?php
            $parmValue = checkParamId('id');
            if (!is_numeric($parmValue)) {
                echo '<h5>' . $parmValue . '</h5>';
                return false;
            }
            $current_url = urlencode($_SERVER['REQUEST_URI']);
            $subjects = getGrades('grades', $parmValue);
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
                                <th class="text-center">1st Sem Gen Avg.</th>
                                <th class="text-center">2nd Sem Gen Avg.</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($subjects as  $item) : ?>
                                <tr>
                                    <td><?= $item['id'] ?></td>
                                    <td><?= getName('students', $item['student_id']) ?></td>
                                    <td class="text-center"><?= $item['gen_avg_first'] ?></td>
                                    <td class="text-center"><?= $item['gen_avg_second'] ?></td>
                                    <td>
                                        <a href="grades-edit.php?id=<?= $item['id']; ?>&class-id=<?= urlencode($_GET['id']) ?>&name=<?= urlencode($_GET['name']) ?>" class="btn btn-success btn-sm">Edit</a>
                                        <a href="grades-view.php?id=<?= $item['id']; ?>" class="btn btn-secondary btn-sm" target="_blank">View Grades</a>
                                        <a href="grades-print.php?id=<?= $item['id']; ?>" class="btn btn-primary btn-sm">Print</a>
                                        <a href="grades-delete.php?id=<?= $item['id']; ?>&return_url=<?= $current_url; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this data?')">Delete</a>
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