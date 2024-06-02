<?php include('includes/header.php') ?>

<div class="container-fluid px-4">
    <div class="card mt-4">
        <div class="card-header">
            <h4 class="mb-0"><?php getName('subjects', $_GET['subject-id']); ?>
                <a href="index.php" class="btn btn-primary float-end">Back</a>
            </h4>
        </div>
        <div class="card-body">
            <div class="row mt-4">
                <?php
                // Get the logged-in user ID
                $user_id = $_SESSION['loggedInUser']['user_id'];
                $name = $_SESSION['loggedInUser']['name'];
                $sections = getSectionsForSubject($_GET['subject-id'], $user_id);
                if (!empty($sections)) : ?>
                    <?php foreach ($sections as $section) : ?>
                        <div class="col-md-3 mb-3">
                            <div class="card card-body bg-light shadow p-3">
                            <a href="teacher-edit.php?class-record-id=<?= htmlspecialchars($section['record_id']); ?>&subject-id=<?= htmlspecialchars($_GET['subject-id']); ?>&semester=<?= htmlspecialchars($section['semester']); ?>" class="h4 text-sm mb-0 text-dark text-decoration-none"><?= htmlspecialchars($section['class_name']); ?></a>

                                <p>Teacher: <?php echo htmlspecialchars($name); ?></p>
                                <p>Semester: <?php echo htmlspecialchars($section['semester']); ?></p>
                                <p class="small fw-bold text-end font-italic">A.Y. <?php echo htmlspecialchars($section['academic_year']); ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else : ?>
                    <p>No sections found for this subject.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

</div>

<?php include('includes/footer.php') ?>