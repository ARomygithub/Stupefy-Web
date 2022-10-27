<?php

session_start();

require_once __DIR__ . '/../app/controllers/AuthController.php';
require_once __DIR__ . '/../app/controllers/DetailedAlbumController.php';

$nav = file_get_contents('./html/template/authorized-navbar.html');
$sidebar = file_get_contents('./html/template/user-sidebar.html');

$body = file_get_contents('./html/edit-album.html');

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

if(!isset($_GET['id'])){
    http_response_code(404);
    echo file_get_contents('./html/404.html');
} else{
    $album_information = getDetailedAlbum($_GET['id']);

    $body = str_replace('{{ album-title }}', $album_information['album-title'], $body);
    if(isset($album_information['album-genre'])) {
        $body = str_replace('{{ album-genre }}', $album_information['album-genre'], $body);
    }else{
        $body = str_replace('{{ album-genre }}', '', $body);
    }
    $body = str_replace('{{ album-date }}', $album_information['release-date'], $body);
    $body = str_replace('{{ album-artist }}', $album_information['album-artist'], $body);
}

$body = str_replace('{{ nav }}', $nav, $body);
$body = str_replace('{{ sidebar }}', $sidebar, $body);

echo $body;


?>
