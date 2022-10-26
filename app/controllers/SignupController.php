<?php
require_once __DIR__ . '/../models/User.php';


if(isset($_POST["signup"])) {
    $data = array(
        "name" => $_POST["Name"],
        "username" => $_POST["Username"],
        "email" => $_POST["Email"],
        "password" => $_POST["Password"]
    );
    $user = new User();
    $res = $user->signup($data);
    if($res) {
        header("Location: home.php");
    }
    else {
        $message = "SignUp Failed";
        echo "<script type='text/javascript'>alert('$message');</script>";
    }
}
?>