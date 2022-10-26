<?php
require_once __DIR__ . '/../models/User.php';

if(isset($_GET["username"])) {
    $username = $_GET["username"];
    $user = new User();
    $user = $user->getByUsername($username);
    if($user) {
        $str = json_encode($user);
        $str .= "username not unique";
    } else {
        echo "username unique";
    }
}

if(isset($_GET["email"])) {
    $email = $_GET["email"];
    $user = new User();
    $user = $user->getByEmail($email);
    if($user) {
        $str = json_encode($user);
        $str .= "email not unique";
    } else {
        echo "email unique";
    }
}

if(isset($_POST["signup"])) {
    $data = array(
        "name" => $_POST["name"],
        "username" => $_POST["username"],
        "email" => $_POST["email"],
        "password" => $_POST["password"]
    );
    $user = new User();
    $res = $user->signup($data);
    if($res) {
        // header("Location: home.php");
        // $str = json_encode($res);
        // $str .= 
        echo "signup success";
    }
    else {
        $message = "SignUp Failed";
        echo "<script type='text/javascript'>alert('$message');</script>";
    }
}
?>