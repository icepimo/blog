<?php
session_start();
if (empty($_SESSION["user"])) {
    header("location:unautherized.php");
}

require_once("classes.php");
$user = unserialize($_SESSION["user"]);
echo "welcome       ". $user->name;