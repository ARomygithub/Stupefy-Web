<?php
    function echo_card($title = "Album Title", $artist = "Artist", $year = "1970", $genre = "Music", $image_src = "../storage/default-song-thumbnail.png"){
        $html = <<<"EOT"
            <div class="card">
                <div class="image-container">
                    <image src="$image_src" />
                </div>
                <div class="main-info">
                    <div class="album-title">$title</div>
                    <div class="artist">$artist</div>
                </div>
                <div class="year">$year</div>
                <div class="genre">$genre</div>
            </div>
        EOT;

        echo $html;
    }

    session_start();

    require_once __DIR__ . '/../app/controllers/AuthController.php';
    require_once __DIR__ . '/../app/controllers/DetailedAlbumController.php';
    
    $nav = file_get_contents('./html/template/authorized-navbar.html');
    $sidebar = file_get_contents('./html/template/user-sidebar.html');
    
    $body = file_get_contents('./html/detail-album.html');
    
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
        
        $duration_hour = intdiv($album_information['duration'],3600);
        $hours = ($duration_hour === 1) ? ' hour ' : ' hours ';
        $duration_min = intdiv($album_information['duration'],60)%60;
        $mins = ($duration_mins === 1) ? ' minute ' : ' minutes ';
        $duration_secs = $album_information['duration']%60;
        $secs = ($duration_secs === 1) ? ' second' : ' seconds';
        $body = str_replace('{{ album-thumbnail }}', $album_information['thumbnail'], $body);
        $body = str_replace('{{ album-title }}', $album_information['album-title'], $body);
        $body = str_replace('{{ album-artist }}', $album_information['album-artist'], $body);
        $body = str_replace('{{ duration }}', $duration_hour . $hours . $duration_min . $mins . $duration_secs . $secs, $body);
    }

    $body = str_replace('{{ nav }}', $nav, $body);
    $body = str_replace('{{ sidebar }}', $sidebar, $body);
    
    echo $body;
    
    
?>