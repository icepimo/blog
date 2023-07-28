<?php
session_start();
$title = $_POST["title"];
$content = $_POST["content"];
require_once("classes.php");
$user = unserialize($_SESSION["user"]);
var_dump($_FILES);
echo "<hr>";
// var_dump($_FILES["image"]["name"]);

$extention = pathinfo($_FILES["image"]["name"],PATHINFO_EXTENSION);
var_dump($extention);
$file_name= "images/posts/".Date("YmdHms").".". $extention;
move_uploaded_file($_FILES["image"]["tmp_name"],$file_name);
$user_id = $user->id;
$rsult =  $user->addPost($content,$title,$file_name,$user_id);

echo "<hr>";
// 
header("location:user.php?msg=done");