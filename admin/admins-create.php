<?php include('includes/header.php') ?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow">
        <div class="card-header">
            <h4 class="mb-0">Add Admin
                <a href="admins.php" class="btn btn-primary float-end">Back</a>
            </h4>
        </div>
        <div class="card-body">
            <?php alertMessage(); ?>
            <form action="code.php" method="POST">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="">Name *</label>
                        <input type="text" name="name" class="form-control" required/>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="">Username *</label>
                        <input type="text" name="username" class="form-control" required/>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="">Email *</label>
                        <input type="text" name="email" class="form-control" required/>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="">Password *</label>
                        <input type="password" name="password" class="form-control" required/>
                    </div>
                    <div class="col-md-12 mb-3 text-end">
                        <button type="submit" name="saveAdmin" class="btn btn-primary">Save</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>

<?php include('includes/footer.php') ?>