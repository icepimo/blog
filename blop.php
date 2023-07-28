<?php
class blog{
  static  function get_posts() {
        require_once("config.php");
        $qry= "SELECT name,content,title,image, p.created_at FROM posts as p
         join users on(users.id = p.users_id) order by created_at DESC";
        // $qry = "select * from posts";
        $cn = mysqli_connect(DB_HOST,DB_USER_NAME,DB_USER_PW,DB_NAME);
        $rsult = mysqli_query($cn,$qry);
        $data =  mysqli_fetch_all($rsult);
        mysqli_close($cn);
        return $data;
    }
}

$data = blog::get_posts();
// var_dump($data);