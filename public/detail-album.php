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
    $sidebar = file_get_contents('./html/template/user-sidebar.html');
    
    $body = file_get_contents('./html/detail-album.html');
    
    $user = getUserInformation();

    if(isset($user)){
        $role = 'User';
        if($user['isAdmin'] === 1){
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