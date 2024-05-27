<?php include('includes/header.php') ?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Dashboard</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>
    <div class="row">
        <div class="col-md-3 mb-3">
            <div class="card card-body bg-warning p-3">
                <p class="text-sm mb-0 text-categories">Total Subject</p>
                <h5 class="fw-bold mb-0">
                    <?= getCount('subjects')?>
                </h5>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card card-body bg-success p-3">
                <p class="text-sm mb-0 text-categories">Total Class</p>
                <h5 class="fw-bold mb-0">
                    <?= getCount('classes')?>
                </h5>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card card-body bg-light p-3">
                <p class="text-sm mb-0 text-categories">Total User</p>
                <h5 class="fw-bold mb-0">
                    <?= getCount('admins')?>
                </h5>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card card-body bg-danger p-3">
                <p class="text-sm mb-0 text-categories">Total Students</p>
                <h5 class="fw-bold mb-0">
                    <?= getCount('students')?>
                </h5>
            </div>
        </div>
    </div>

</div>

<?php include('includes/footer.php') ?>