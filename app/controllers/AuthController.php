<?php

require_once __DIR__ . './../models/User.php';

function setAuthCookie($id) {
    $cookie_name = "COOKIE_AUTH";
    $exp = time() + COOKIE_AUTH_EXPIRE;
    $cookie_value = $id . "-" . $exp;
    $cookie_value_encoded = base64_encode($cookie_value);
    $cookie_value_hash = hash('sha256', $cookie_value . '-' . COOKIE_AUTH_SECRET); 
    $cookie_value_token = $cookie_value_encoded . '.' . $cookie_value_hash;
    setcookie($cookie_name, $cookie_value_token, $exp, "/");
}

function isValidAuthCookie($cookies) {
    if(!isset($cookies['COOKIE_AUTH'])){
        return false;
    }
    $cookie = $cookies['COOKIE_AUTH'];
    $cookie_parts = explode('.', $cookie);
    if(count($cookie_parts) != 2){
        return false;
    }
    $cookie_value_encoded = $cookie_parts[0];
    $cookie_value_hash = $cookie_parts[1];
    $cookie_value = base64_decode($cookie_value_encoded);
    if($cookie_value_hash !== hash('sha256', $cookie_value . '-' . COOKIE_AUTH_SECRET)){
        return false;
    }
    $cookie_value_parts = explode('-', $cookie_value);
    $id = $cookie_value_parts[0];
    $exp = $cookie_value_parts[1];
    if(empty($id) || time() >$exp) {
        return false;
    }
    return $id;
}

function getUserInformation(){
    $user = new User();
    if(isValidAuthCookie($_COOKIE)){
        $id = isValidAuthCookie($_COOKIE);
        $user = $user->getById($id);
    } else{
        $user = null;
    }

    return $user;
}

function deleteAuthCookie() {
    $cookie_name = "COOKIE_AUTH";
    $cookie_value = "";
    $cookie_value = base64_encode($cookie_value);
    setcookie($cookie_name, $cookie_value, time() - COOKIE_AUTH_EXPIRE, "/");
}

if(isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $user = new User();
    $data = $user->getByUsername($username);
    if($data) {
        if(password_verify($password, $data['password'])) {
            // session_unset();
            // session_destroy();
            // session_start();
            // session_start();
            setAuthCookie($data['user_id']);
            $_SESSION['user_id'] = $data['user_id'];
            // $str = json_encode($data);
            // echo $str; 
            echo "login success";
        } else {
            echo "login failed";
        }
    } else {
        echo "login failed";
    }
}

if(isset($_POST['logout'])) {
    session_start();
    deleteAuthCookie();
    session_destroy();
    echo "logout success";
}

if(isset($_POST['play_song'])) {
    session_start();
    if(isValidAuthCookie($_COOKIE)){
        echo json_encode(["play song success"]);
    } else{
        if(!isset($_SESSION['last_date_played'])) {
            $_SESSION['last_date_played'] = date('Y-m-d');
            $_SESSION['total_played'] = 1;
            echo json_encode(["play song success", $_SESSION['total_played'], $_SESSION['last_date_played']]);
        } else {
            $last_date_played = $_SESSION['last_date_played'];
            $today = date('Y-m-d');
            if($last_date_played === $today) {
                if($_SESSION['total_played'] < 3) {
                    $_SESSION['total_played'] += 1;
                    echo json_encode(["play song success", $_SESSION['total_played'], $_SESSION['last_date_played']]);
                } else {
                    echo json_encode(["play song failed", $_SESSION['total_played'], $_SESSION['last_date_played']]);
                }
            } else {
                $_SESSION['last_date_played'] = $today;
                $_SESSION['total_played'] = 1;
                echo json_encode(["play song success", $_SESSION['total_played'], $_SESSION['last_date_played']]);
            }
        }
    }
}

?>