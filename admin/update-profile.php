<?php include('includes/header.php') ?>

<div class="container-fluid px-4">
    <div class="card mt-4">
        <div class="card-header">
            <h4>Edit Profile</h4>
        </div>
        <div class="card-body">
            <?php alertMessage(); ?>
            <form action="code.php" method="POST">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="">Username</label>
                        <input type="text" class="form-control" value="<?= $_SESSION['loggedInUser']['username']; ?>"disabled>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="">Name *</label>
                        <input type="text" name="name" class="form-control" value="<?= $_SESSION['loggedInUser']['name']; ?>" required />
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="">Email *</label>
                        <input type="text" name="email" class="form-control" value="<?= $_SESSION['loggedInUser']['email']; ?>" required />
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="">Password</label>
                        <input type="password" name="password" class="form-control" />
                    </div>
                </div>
                <div class="col-md-12 mb-3 text-end">
                    <button type="submit" name="updateProfile" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>

</div>

<?php include('includes/footer.php') ?>