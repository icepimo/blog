<?php
class users{
    public $id;
    public $name;
    public $email;
    // public $role;
    private $password;

    public function __construct($id ,$name,$email,$password) {
        $this->id = $id;
        $this->email = $email;
        $this->password = $password;
        $this->name = $name;
    }


    
    static function signup($name,$email,$password) {
        $name = $_POST["name"];
        $email = $_POST["email"];
        $password = md5( $_POST["password"]);
        $qry = "insert into users (name,password,email) 
        values('$name','$password','$email') ";
        require_once("config.php");
        
        $cn = mysqli_connect(DB_HOST,DB_USER_NAME,DB_USER_PW,DB_NAME);
        // var_dump($cn);
        try {
            $rsult = mysqli_query($cn,$qry);
            //code...
        } catch (\Throwable $th) {
            header("location:signup.php?msg=e_a_t");
            //throw $th;
        }
        var_dump($rsult);
        mysqli_close($cn);
        

    }


    static function login($email,$password) {
        $user = null;
        $email = htmlspecialchars(trim($email));
        $password = trim(md5($password));
        $qry = "select * from users where email = '$email' AND password='$password'";
        require_once("config.php");
        $cn = mysqli_connect(DB_HOST,DB_USER_NAME,DB_USER_PW,DB_NAME);
        $rsult = mysqli_query($cn,$qry);
        if ( $rslt =  mysqli_fetch_assoc($rsult)) {

            var_dump($rslt);
            switch ($rslt['role']) {
                case 'user':
                    $id= $rslt['id'];
                    $name= $rslt['name'];
                    $email= $rslt['email'];
                    $password= $rslt['password'];
                    $user = new user($id,$name,$email,$password);
                    break;
                
                case 'admin':
                    $id= $rslt['id'];
                    $name= $rslt['name'];
                    $email= $rslt['email'];
                    $password= $rslt['password'];
                    $user = new admin($id,$name,$email,$password);
                    break;
            }
        }
        return $user;
    }


}
class user extends users 
{
    public $role = 'user';

    function showAllMyPosts() {
        $qry = " SELECT * FROM posts WHERE user_id='$this->id' ";
        $cn = mysqli_connect(DB_HOST,DB_USER_NAME,DB_USER_PW,DB_NAME);
        $rsult = mysqli_query($cn,$qry);
        $data =  mysqli_fetch_assoc($rsult);
        mysqli_close($cn);

        return $data;

    }
    function showPost($id) {

        $qry = " SELECT * FROM posts WHERE id='$id' ";
        $cn = mysqli_connect(DB_HOST,DB_USER_NAME,DB_USER_PW,DB_NAME);
        $rsult = mysqli_query($cn,$qry);
        $data =  mysqli_fetch_assoc($rsult);
        mysqli_close($cn);

        return $data;
        
    }
    // function addPost($content,$title,$image,$user_id) {
    //     require_once("config.php");
    //     $qry = "INSERT INTO `posts` (`content`, `title`,`users_id`, `image`) VALUES ( '$content', '$title', '$user_id', '$image')";
    
    //     $cn = mysqli_connect(DB_HOST,DB_USER_NAME,DB_USER_PW,DB_NAME);
    //     $rsult = mysqli_query($cn,$qry);
    //     mysqli_close($cn);
    //     return $rsult;
        
    // }

    public function addPost($title,$body,$file_name,$user_id)
    {
        $qry="INSERT INTO `posts` (`title`,`content`,`image`,`users_id`) VALUES ('$title','$body','$file_name',$user_id)";
        require_once("config.php");
        $cn = mysqli_connect(DB_HOST,DB_USER_NAME,DB_USER_PW,DB_NAME);
        $rslt = mysqli_query($cn,$qry);
        mysqli_close($cn);
        return $rslt;
    }
    function deletePost($id) {
        $qry = "DELETE FROM posts WHERE id = $id";
        $cn = mysqli_connect(DB_HOST,DB_USER_NAME,DB_USER_PW,DB_NAME);
        $rsult = mysqli_query($cn,$qry);
        mysqli_close($cn);
        return $rsult;
    }
    function editPost($content,$id) {
        $qry = "UPDATE POSTS SET content = '$content' WHERE id = $id";
        $cn = mysqli_connect(DB_HOST,DB_USER_NAME,DB_USER_PW,DB_NAME);
        $rsult = mysqli_query($cn,$qry);
        mysqli_close($cn);
        return $rsult;
    }

    // function addComment(){
    //     $qry = "insert into 
    //     comments(content,post_id,user_id) values('xxx',2,1)";
    //     $cn = mysqli_connect(DB_HOST,DB_USER_NAME,DB_USER_PW,DB_NAME);
    //     $rsult = mysqli_query($cn,$qry);
    //     mysqli_close($cn);
    //     return $rsult;
    // }
    function deleteComment(){
        
    }
}
class admin extends users 
{
    public $role = 'admin';
    
}