<?php

session_start();
if(!isset($_SESSION['total_played'])) {
    $_SESSION['total_played'] = 0;
}

require_once __DIR__ . '/../app/controllers/AuthController.php';

$nav = file_get_contents('./html/template/authorized-navbar.html');
$sidebar = file_get_contents('./html/template/admin-sidebar.html');

$body = file_get_contents('./html/users.html');

$user = getUserInformation();

if(isset($user) && $user['isAdmin']){
    $sidebar = file_get_contents('./html/template/admin-sidebar.html');
    $nav = str_replace('{{ user }}', $user['username'], $nav);
    $nav = str_replace('{{ role }}', 'Admin' , $nav);

    $body = str_replace('{{ nav }}', $nav, $body);
    $body = str_replace('{{ sidebar }}', $sidebar, $body);

    echo $body;
} else{
    http_response_code(403);
    echo file_get_contents('./html/403.html');
} 




?>
