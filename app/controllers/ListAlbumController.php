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
            <div class="card" onclick="getDetailedAlbum($id)">
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

    if(isset($_GET["offset"])) {
        $offset = 0;
        $limit = 10;

        if(isset($_GET['offset'])) {
            $offset = (int)$_GET['offset'];
        }
        if(isset($_GET['limit'])) {
            $limit = (int)$_GET['limit'];
        }
        $albums = new Album();
        $albums = $albums->getTemplated($offset, $limit);
        $cards = "";
        $i = 1;
        foreach($albums as $album){
            $cards .= createEntry($album, $i);
            if($i == $limit){
                break;
            }
            $i++;
        }

        echo json_encode([$cards, count($albums)]);
    }
?>