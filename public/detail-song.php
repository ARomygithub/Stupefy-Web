<?php
    session_start();

    require_once __DIR__ . '/../app/controllers/AuthController.php';
    require_once __DIR__ . '/../app/controllers/DetailedSongController.php';
    
    $nav = file_get_contents('./html/template/authorized-navbar.html');
    $sidebar = file_get_contents('./html/template/admin-sidebar.html');
    
    $body = file_get_contents('./html/detail-song.html');
    
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
        $song_information = getDetailedSong($_GET['id']);

        $body = str_replace('{{ song-title }}', $song_information['song-title'], $body);
        $body = str_replace('{{ song-artist }}', $song_information['song-artist'], $body);
        $body = str_replace('{{ song-album }}', $song_information['song-album'], $body);
        $body = str_replace('{{ song-genre }}', $song_information['song-genre'], $body);
        $body = str_replace('{{ release-date }}', $song_information['release-date'], $body);
        $body = str_replace('{{ song-duration }}', $song_information['song-duration'], $body);
        $body = str_replace('{{ song-file }}', $song_information['song-file'], $body);
        $body = str_replace('{{ thumbnail-image }}', $song_information['thumbnail'], $body);
        $body = str_replace('{{ song-album }}', $song_information['song-album'], $body);
    }

    $body = str_replace('{{ nav }}', $nav, $body);
    $body = str_replace('{{ sidebar }}', $sidebar, $body);

    echo $body;
    
?>
