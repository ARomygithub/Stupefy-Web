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
    
    $nav = file_get_contents('./html/template/authorized-navbar.html');
    $sidebar = file_get_contents('./html/template/admin-sidebar.html');
    
    $body = file_get_contents('./html/album.html');
    
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