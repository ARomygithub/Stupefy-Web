<?php
    session_start();

    require_once __DIR__ . '/../app/controllers/AuthController.php';
    require_once __DIR__ . '/../app/controllers/DetailedSongController.php';
    
    $nav = file_get_contents('./html/template/authorized-navbar.html');
    $sidebar = file_get_contents('./html/template/user-sidebar.html');
    
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

        $duration_hour = intdiv($song_information['song-duration'],3600);
        $hours = ($duration_hour === 1) ? ' hour ' : ' hours ';
        $duration_min = intdiv($song_information['song-duration'],60)%60;
        $mins = ($duration_mins === 1) ? ' minute ' : ' minutes ';
        $duration_secs = $song_information['song-duration']%60;
        $secs = ($duration_secs === 1) ? ' second' : ' seconds';
        $body = str_replace('{{ song-title }}', $song_information['song-title'], $body);
        $body = str_replace('{{ song-artist }}', $song_information['song-artist'], $body);
        if(isset($song_information['song-album'])) $body = str_replace('{{ song-album }}', ': ' . $song_information['song-album'], $body);
        else $body = str_replace('{{ song-album }}', '', $body);
        $body = str_replace('{{ song-genre }}', $song_information['song-genre'], $body);
        $body = str_replace('{{ release-date }}', $song_information['release-date'], $body);
        $body = str_replace('{{ song-duration }}', $duration_hour . $hours . $duration_min . $mins . $duration_secs . $secs, $body);
        $body = str_replace('{{ song-file }}', $song_information['song-file'], $body);
        $body = str_replace('{{ thumbnail-image }}', $song_information['thumbnail'], $body);
        $body = str_replace('{{ song-album }}', $song_information['song-album'], $body);
        if(isset($song_information['album-id'])){
            $body = str_replace('{{ album-id }}', $song_information['album-id'], $body);
            $body = str_replace('{{ button-class }}', 'check-album-button', $body);
        }
        else{
            $body = str_replace('{{ album-id }}', -1, $body);
            $body = str_replace('{{ button-class }}', 'check-album-button-disabled', $body);
        }

    }

    $body = str_replace('{{ nav }}', $nav, $body);
    $body = str_replace('{{ sidebar }}', $sidebar, $body);

    echo $body;
    
?>
