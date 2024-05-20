<?php include('includes/header.php') ?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow">
        <div class="card-header">
            <h4 class="mb-0">Add Subject
                <a href="subjects.php" class="btn btn-primary float-end">Back</a>
            </h4>
        </div>
        <div class="card-body">
            <?php alertMessage(); ?>
            <form action="code.php" method="POST">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="">Subject Name *</label>
                        <input type="text" name="name" class="form-control" required />
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="">Subject Code </label>
                        <input type="text" name="subject_code" class="form-control" />
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="">Subject Type *</label>
                        <select name="subject_type" class="form-control" required>
                            <option value="">-- Select --</option>
                            <!-- Add options here -->
                            <option value="1">Core Subjects</option>
                            <option value="2">Applied and Specialized Subjects</option>
                            <!-- Add more options as needed -->
                        </select>
                    </div>
                    <div class="col-md-12 mb-3">
                        <div class="form-check">
                            <input class="form-check-input" name="status" type="checkbox">
                            <label class="form-check-label">Status (unchecked=visible, checked=hidden)</label>
                        </div>
                    </div>
                    <div class="col-md-12 mb-3 text-end">
                        <button type="submit" name="saveSubject" class="btn btn-primary">Save</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>

<?php include('includes/footer.php') ?>