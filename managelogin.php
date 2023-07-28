<?php
session_start();
require_once("classes.php");
if (!empty($_POST["email"]) && !empty($_POST["password"])) {

    $email = $_POST["email"];
    $password = $_POST["password"];
    $user = users::login($email, $password);
    var_dump($user);
    if (empty($user)) {
        header("location:login.php?msg=invalid_email_or_password");
    } else {
        $role = $user->role;
        $_SESSION["user"] = serialize($user);
        if ($role == 'user') {
            header("location:user.php");
        }else{
            header("location:admin.php");
        }
     
    }
} else {
    header("location:login.php?msg=empty_field");
}