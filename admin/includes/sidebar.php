<?php
$page = substr($_SERVER['SCRIPT_NAME'], strrpos($_SERVER['SCRIPT_NAME'], "/") + 1);
?>

<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading">Core</div>
                <a class="nav-link <?= $page == 'index.php' ? 'active' : ''; ?>" href="index.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>
                <div class="sb-sidenav-menu-heading">Management</div>
                <a class="nav-link 
                <?= $page == 'subjects-create.php' ? 'collapse active' : 'collapsed'; ?>
                <?= $page == 'subjects.php' ? 'collapse active' : 'collapsed'; ?>
                " href="#" data-bs-toggle="collapse" data-bs-target="#collapseSubjects" aria-expanded="false" aria-controls="collapseSubjects">
                    <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                    Subjects
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse 
                <?= $page == 'subjects-create.php' ? 'show' : ''; ?>
                <?= $page == 'subjects.php' ? 'show' : ''; ?>
                " id="collapseSubjects" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link <?= $page == 'subjects-create.php' ? 'active' : ''; ?>" href="subjects-create.php">Add Subject</a>
                        <a class="nav-link <?= $page == 'subjects.php' ? 'active' : ''; ?>" href="subjects.php">View Subjects</a>
                    </nav>
                </div>

                <a class="nav-link 
                <?= $page == 'classes-create.php' ? 'collapse active' : 'collapsed'; ?>
                <?= $page == 'classes.php' ? 'collapse active' : 'collapsed'; ?>
                " href="#" data-bs-toggle="collapse" data-bs-target="#collapseClasses" aria-expanded="false" aria-controls="collapseClasses">
                    <div class="sb-nav-link-icon"><i class="fas fa-layer-group"></i></div>
                    Class
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse 
                <?= $page == 'classes-create.php' ? 'show' : ''; ?>
                <?= $page == 'classes.php' ? 'show' : ''; ?>
                " id="collapseClasses" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link <?= $page == 'classes-create.php' ? 'active' : ''; ?>" href="classes-create.php">Add Class</a>
                        <a class="nav-link <?= $page == 'classes.php' ? 'active' : ''; ?>" href="classes.php">View Classes</a>
                    </nav>
                </div>

                
                <div class="sb-sidenav-menu-heading">Manage Users</div>

                <a class="nav-link 
                <?= $page == 'admins-create.php' ? 'collapse active' : 'collapsed'; ?>
                <?= $page == 'admins.php' ? 'collapse active' : 'collapsed'; ?>
                " href="" data-bs-toggle="collapse" data-bs-target="#collapseAdmins" aria-expanded="false" aria-controls="collapseAdmins">
                    <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                    Users
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse
                <?= $page == 'admins-create.php' ? 'show' : ''; ?>
                <?= $page == 'admins.php' ? 'show' : ''; ?>
                " id="collapseAdmins" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link <?= $page == 'admins-create.php' ? 'active' : ''; ?>" href="admins-create.php">Add User</a>
                        <a class="nav-link <?= $page == 'admins.php' ? 'active' : ''; ?>" href="admins.php">View Users</a>
                    </nav>
                </div>

                <a class="nav-link
                <?= $page == 'students-create.php' ? 'collapse active' : 'collapsed'; ?>
                <?= $page == 'students.php' ? 'collapse active' : 'collapsed'; ?>
                " href="" data-bs-toggle="collapse" data-bs-target="#collapseStudents" aria-expanded="false" aria-controls="collapseStudents">
                    <div class="sb-nav-link-icon"><i class="fas fa-user-graduate"></i></div>
                    Students
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse
                <?= $page == 'students-create.php' ? 'show' : ''; ?>
                <?= $page == 'students.php' ? 'show' : ''; ?>
                " id="collapseStudents" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link <?= $page == 'students-create.php' ? 'active' : ''; ?>" href="students-create.php">Add Student</a>
                        <a class="nav-link <?= $page == 'students.php' ? 'active' : ''; ?>" href="students.php">View Students</a>
                    </nav>
                </div>

                <div class="sb-sidenav-menu-heading">Student Record</div>

                <a class="nav-link 
                <?= $page == 'admins-create.php' ? 'collapse active' : 'collapsed'; ?>
                <?= $page == 'grades.php' ? 'collapse active' : 'collapsed'; ?>
                " href="" data-bs-toggle="collapse" data-bs-target="#collapseGrades" aria-expanded="false" aria-controls="collapseGrades">
                    <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                    Grades
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse
                <?= $page == 'admins-create.php' ? 'show' : ''; ?>
                <?= $page == 'grades.php' ? 'show' : ''; ?>
                " id="collapseGrades" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link <?= $page == 'admins-create.php' ? 'active' : ''; ?>" href="admins-create.php">Add Admin</a>
                        <a class="nav-link <?= $page == 'grades.php' ? 'active' : ''; ?>" href="grades.php">View Grades</a>
                    </nav>
                </div>

            </div>


        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Logged in as:</div>
            Start Bootstrap
        </div>
    </nav>
</div>