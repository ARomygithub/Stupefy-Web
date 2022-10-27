<?php
    require_once __DIR__ . '/../models/Album.php';
    require_once __DIR__ . '/../models/Song.php';
    function getDetailedAlbum($id){
        $album = new Album();
        $album = $album->getById($id);
        
        return ['album-title' => $album['Judul'], 
            'album-artist' => $album['Penyanyi'], 
            'release-date' => $album['Tanggal_terbit'], 
            'album-genre' => $album['Genre'], 
            'thumbnail' => $album['Image_path'],
            'duration' => $album['Total_duration'],  
        ];
    }

?>