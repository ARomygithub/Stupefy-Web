<?php

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