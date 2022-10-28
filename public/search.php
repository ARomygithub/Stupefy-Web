<?php

session_start();
if(!isset($_SESSION['total_played'])) {
    $_SESSION['total_played'] = 0;
}

require_once __DIR__ . '/../app/controllers/AuthController.php';

$nav = file_get_contents('./html/template/authorized-navbar.html');
$sidebar = file_get_contents('./html/template/user-sidebar.html');

$body = file_get_contents('./html/search.html');

$user = getUserInformation();

if(isset($user)){
    $role = 'User';
    if($user['isAdmin']){
        $sidebar = file_get_contents('./html/template/admin-sidebar.html');
        $role = 'Admin';
    }
    $nav = str_replace('{{ user }}', $user['username'], $nav);
    $nav = str_replace('{{ role }}', $role , $nav);
} else if(!isset($user)){
    $nav = file_get_contents('./html/template/unauthorized-navbar.html');  
} 

$body = str_replace('{{ nav }}', $nav, $body);
$body = str_replace('{{ sidebar }}', $sidebar, $body);

echo $body;


?>
