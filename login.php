<?php
include ('includes/header.php');
if(isset($_SESSION['loggedIn']))
{
    ?>
    <script>window.location.href = 'index.php';</script>
    <?php
}

?>

    <div class="limiter">
        <div class="container-login100" style="background-image: url('login-assets/images/bg-01.jpg')">
            <div class="wrap-login100 p-t-30 p-b-50">
                <span class="login100-form-title p-b-25"> STEM GATE </span>

                <div style="margin-top: 20px"></div>

                <form action="login-code.php" class="login100-form validate-form p-b-33 p-t-5" method="POST">
                <?php alertMessage(); ?>
                    <div class="wrap-input100 validate-input" data-validate="Enter username">
                        <input class="input100" type="text" name="username" placeholder="Username" required />

                        <span class="focus-input100" data-placeholder="&#xe82a;"></span>
                    </div>

                    <div class="wrap-input100 validate-input" data-validate="Enter password">
                        <input class="input100" type="password" name="password" placeholder="Password" required />
                        <span class="focus-input100" data-placeholder="&#xe80f;"></span>
                    </div>

                    <div class="container-login100-form-btn m-t-32">
                        <button type="submit" name="loginBtn" class="login100-form-btn">Login</button>
                    </div>
                    <div class="container-login100-form-btn m-t-32">
                        <p>Log in as <a href="../sign_in/subject-teacher.html">Teacher</a>
                        </p>

                        <p>
                            Don't have an account yet? Sign up as<a href="../sign_up/admin.html"> Admin</a> or <a href="../sign_up/subject-teacher.html"> Teacher</a>

                    </div>
                    </p>
                </form>
            </div>
        </div>
    </div>
    </div>
</body>

</html>