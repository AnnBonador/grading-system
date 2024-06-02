<?php include('includes/header.php'); 
$loggedInUserId = $_SESSION['loggedInUser']['user_id'];
$loggedInUserRole = $_SESSION['loggedInUser']['role']; // Assuming the role is stored in the session
?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Dashboard</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>
    <div class="row">
        <div class="col-md-12">
        <?php alertMessage(); ?>
        </div>
    </div>

    <?php if ($loggedInUserRole === 'Admin'): // Check if the user is an Admin ?>
        <div class="row">
            <div class="col-md-3 mb-3">
                <div class="card card-body bg-warning p-3">
                    <p class="text-sm mb-0 text-categories">Total Subject</p>
                    <h5 class="fw-bold mb-0">
                        <?= getCount('subjects') ?>
                    </h5>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card card-body bg-success p-3">
                    <p class="text-sm mb-0 text-categories">Total Class</p>
                    <h5 class="fw-bold mb-0">
                        <?= getCount('classes') ?>
                    </h5>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card card-body bg-light p-3">
                    <p class="text-sm mb-0 text-categories">Total User</p>
                    <h5 class="fw-bold mb-0">
                        <?= getCount('admins') ?>
                    </h5>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card card-body bg-danger p-3">
                    <p class="text-sm mb-0 text-categories">Total Students</p>
                    <h5 class="fw-bold mb-0">
                        <?= getCount('students') ?>
                    </h5>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <?php if ($loggedInUserRole === 'Teacher'): // Check if the user is a Teacher ?>
        <div class="row">
            <?php
            $assignedSubjects = viewTeacherSubjects();
            if (!empty($assignedSubjects)): ?>
                <?php foreach ($assignedSubjects as $subject): ?>
                    <div class="col-md-3 mb-3">
                        <div class="card card-body bg-light shadow p-3">
                            <a href="teacher-view.php?subject-id=<?php echo htmlspecialchars($subject['subject_id']); ?>" class="h4 text-sm mb-0 text-categories text-dark text-decoration-none">
                                <?php echo getName('subjects', $subject['subject_id']); ?>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No subjects assigned.</p>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>

<?php include('includes/footer.php') ?>
