<?php
    function echo_detail_album($title = "Album Title", $artist = "Artist", $total_duration = 0){
        $secs = $total_duration%60;
        $mins = intdiv($total_duration,60)%60;
        $hour = intdiv($total_duration,3600);
        $html = <<<"EOT"
            <div id="detail-album">
                <div style="background-color: white; aspect-ratio: 1; width: 200px; margin: 20px;"></div>
                <div class="main-info">
                    <div class="album-title">$title</div>
                    <div class="artist">$artist</div>
                    <div class="duration">$hour Hours $mins Minutes $secs Seconds</div>
                </div>
            </div>
        EOT;

        echo $html;
    }

    function echo_song($title = "Song Title"){
        $html = <<<"EOT"
            <div class="detail-song">
                <div style="background-color: white; aspect-ratio: 1; height: 50px; margin: 20px;"></div>
                <div class="song-title">$title</div>
            </div>
        EOT;
        
        echo $html;
    }

    session_start();

    require_once __DIR__ . '/../app/controllers/AuthController.php';

    $nav = file_get_contents('./html/template/authorized-navbar.html');
    $sidebar = file_get_contents('./html/template/admin-sidebar.html');

    $body = file_get_contents('./html/detail-album.html');

    if(!isset($_SESSION['user_id']) && $user_role === 'admin'){
        $sidebar = file_get_contents('./html/template/admin-sidebar.html');
        $body = str_replace('{{ nav }}', $nav, $body);
        $body = str_replace('{{ sidebar }}', $sidebar, $body);

        echo $body;
    } else{
        http_response_code(403);
        echo file_get_contents('./html/403.html');
        // die('Forbidden');
    } 
?>