<?php include('includes/header.php') ?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow">
        <div class="card-header">
            <h4 class="mb-0">Add Student
                <a href="students.php" class="btn btn-primary float-end">Back</a>
            </h4>
        </div>
        <div class="card-body">
            <?php alertMessage(); ?>
            <form action="code.php" method="POST">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="">Student Name *</label>
                        <input type="text" name="name" class="form-control" required />
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="">Date of Birth *</label>
                        <input type="date" name="birthday" class="form-control" required />
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="">Gender *</label>
                        <div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="gender" id="genderMale" value="m" required>
                                <label class="form-check-label" for="genderMale">Male</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="gender" id="genderFemale" value="f" required>
                                <label class="form-check-label" for="genderFemale">Female</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="">LRN *</label>
                        <input type="number" name="lrn" class="form-control" required />
                    </div>
                    <div class="col-md-12 mb-3 text-end">
                        <button type="submit" name="saveStudent" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include('includes/footer.php') ?>
