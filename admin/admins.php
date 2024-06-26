<?php include('includes/header.php') ?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow">
        <div class="card-header">
            <h4 class="mb-0">Users
                <a href="admins-create.php" class="btn btn-primary float-end">Add User</a>
            </h4>
        </div>
        <div class="card-body">
            <?php alertMessage(); ?>
            <?php
            $admins = getAll('admins');
            if (!$admins) {
                echo '<h4>Something Went Wrong!</h4>';
                return false;
            }
            if (mysqli_num_rows($admins) > 0) {

            ?>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered" id="admins_table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Username</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Date Created</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($admins as  $admin) : ?>
                                <tr>
                                    <td><?= $admin['id'] ?></td>
                                    <td><?= $admin['username'] ?></td>
                                    <td><?= $admin['name'] ?></td>
                                    <td><?= $admin['email'] ?></td>
                                    <td><?= $admin['role'] ?></td>
                                    <td><?= convertToDateOnly($admin['created_at']) ?></td>
                                    <td>
                                        <a href="admins-edit.php?id=<?= $admin['id']; ?>" class="btn btn-success btn-sm">Edit</a>
                                        <a href="admins-delete.php?id=<?= $admin['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this data?')">Delete</a>
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
    $('#admins_table').DataTable();
});
</script>