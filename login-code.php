<?php

require 'config/function.php';

if(isset($_POST['loginBtn']))
{
    $username = validate($_POST['username']);
    $password = validate($_POST['password']);

    if($username != '' && $password !='')
    {
        $query = "SELECT * FROM admins WHERE username='$username' LIMIT 1";
        $result = mysqli_query($conn,$query);
        if($result)
        {
            if(mysqli_num_rows($result) == 1 ){
                $row = mysqli_fetch_assoc($result);
                $hashedPassword = $row['password'];

                if(!password_verify($password,$hashedPassword)){
                    redirect('login.php','Invalid Password');
                }

                $_SESSION['loggedIn'] = true;
                $_SESSION['loggedInUser'] = [
                    'user_id' => $row['id'],
                    'username' => $row['username'],
                    'name' => $row['name'],
                    'email' => $row['email'],
                    'role' => $row['role'],
                ];

                redirect('admin/index.php','Logged In Successfully');

            }else{
                redirect('login.php','Invalid username!');
            }
        }
    }else{
        redirect('login.php','All fields are mandatory!');

    }
}

?>