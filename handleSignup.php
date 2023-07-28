<?php
// var_dump($_POST);
if (!empty($_POST["name"]) && !empty($_POST["email"]) && !empty($_POST["password"]) ) {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    require_once("classes.php");
      users::signup($name,$email,$password);
      header("location:login.php");

}else{
    header("location:signup.php?msg=empty_field");
}