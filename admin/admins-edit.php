<?php include('includes/header.php') ?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow">
        <div class="card-header">
            <h4 class="mb-0">Edit User
                <a href="admins.php" class="btn btn-danger float-end">Back</a>
            </h4>
        </div>
        <div class="card-body">
            <?php alertMessage(); ?>
            <form action="code.php" method="POST">
                <?php
                
                if (isset($_GET['id'])) {
                    if ($_GET['id'] != '') {
                        $adminId = $_GET['id'];
                    } else {
                        echo '<h5>No Id Found</h5>';
                        return false;
                    }
                } else {
                    echo '<h5>No Id given in params</h5>';
                    return false;
                }

                $adminData = getById('admins', $adminId);
                if ($adminData) {
                    if ($adminData['status'] == 200) {
                ?>
                        <input type="hidden" name="adminId" value="<?= $adminData['data']['id']; ?>">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="">Name *</label>
                                <input type="text" name="name" class="form-control" value="<?= $adminData['data']['name']; ?>" required />
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="">Username *</label>
                                <input type="text" name="username" class="form-control" value="<?= $adminData['data']['username']; ?>"required />
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="">Email *</label>
                                <input type="text" name="email" class="form-control" value="<?= $adminData['data']['email']; ?>" required />
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="">Role *</label>
                                <select name="role" class="form-control select2" required>
                                    <option value="">-- Select --</option>
                                    <option value="Admin" <?= $adminData['data']['role'] == 'Admin' ? 'selected' : ''; ?>>Admin</option>
                                    <option value="Teacher" <?= $adminData['data']['role'] == 'Teacher' ? 'selected' : ''; ?>>Teacher</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="">Password *</label>
                                <input type="password" name="password" class="form-control" />
                            </div>
                            <div class="col-md-12 mb-3 text-end">
                                <button type="submit" name="updateAdmin" class="btn btn-primary">Update</button>
                            </div>
                        </div>
                <?php
                    } else {
                        echo '<h5>' . $adminData['message'] . '</h5>';
                    }
                } else {
                    echo 'Something Went Wrong';
                    return false;
                }

                ?>


            </form>
        </div>
    </div>
</div>

<?php include('includes/footer.php') ?>