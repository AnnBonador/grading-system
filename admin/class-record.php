<?php include('includes/header.php') ?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow">
        <div class="card-header">
            <h4 class="mb-0">Class Record
                <a href="class-record-create.php" class="btn btn-primary float-end">Add Class Record</a>
            </h4>
        </div>
        <div class="card-body">
    <?php alertMessage(); ?>
    <?php
    $records = getAll('class_record');
    if (!$records) {
        echo '<h4>Something Went Wrong!</h4>';
        return false;
    }
    if (mysqli_num_rows($records) > 0) {
        ?>
        <div class="table-responsive">
            <table class="table table-striped table-bordered" id="record_table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Class</th>
                        <th>Adviser</th>
                        <th>Date Created</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($item = mysqli_fetch_assoc($records)) : ?>
                        <tr>
                            <td><?= $item['id'] ?></td>
                            <td><?= $item['name'] ?></td>
                            <td><?= getName('classes',$item['class_id']) ?></td>
                            <td><?= getName('admins',$item['adviser']) ?></td>
                            <td><?= convertToDateOnly($item['created_at']) ?></td>
                            <td>
                                <a href="class-record-edit.php?id=<?= $item['id']; ?>" class="btn btn-success btn-sm">Edit</a>
                                <a href="grades.php?id=<?= $item['id']; ?>&name=<?= urlencode($item['name']); ?>" class="btn btn-secondary btn-sm">View Students</a>
                                <a href="class-record-delete.php?id=<?= $item['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this data?')">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
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
    $('#record_table').DataTable();
});
</script>