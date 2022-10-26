<?php
    require_once __DIR__ . '/../models/Album.php';


    function createEntry($album){
        $entry = '<option value=' . $album['album_id'] .'> ' . $album['Judul']. ' <em> by ' . $album['Penyanyi'] . '</em> </option>';
        return $entry;
    }

    $albums = new Album();
    if(isset($_GET['album'])){
        $albums = $albums->getByID(intval($_GET['album']));
        $cards = $albums['Penyanyi'];
        echo json_encode([$cards]);
    } else{
        $albums = $albums->getAlbumSortByArtist();
        $cards = '';
        foreach ($albums as $album) {
            $cards .= createEntry($album);
        }
        echo json_encode([$cards]);
    }
    
?>