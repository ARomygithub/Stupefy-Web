<?php
    require_once __DIR__ . '/../models/Album.php';
    
    function createEntry($album){
        if(!isset($album['Penyanyi'])){
            $album['Penyanyi'] = 'Unknown';
        }
        if(!isset($album['Genre'])){
            $album['Genre'] = '-';
        }

        $id = $album['album_id'];
        $html = <<<"EOT"
            <div class="card">
                <div class="image-container">
                    <image src="$album[Image_path]" />
                </div>
                <div class="main-info">
                    <div class="album-title">$album[Judul]</div>
                    <div class="artist">$album[Penyanyi]</div>
                </div>
                <div class="year">$album[Tahun]</div>
                <div class="genre">$album[Genre]</div>
            </div>
        EOT;


        return $html;
    }

    if(isset($_GET['page'])) $page = $_GET['page'];
    else $page = 1; 
    $pagesize = 10;
    $albums = new Album();
    $albums = $albums->getTemplated(($page-1) * $pagesize, $pagesize);
    $cards = '';
    foreach ($albums as $album) {
        $cards .= createEntry($album);
    }

    echo json_encode([$cards]);
?>