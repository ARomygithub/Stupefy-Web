<?php
    require_once __DIR__ . '/../models/Album.php';
    require_once __DIR__ . '/../models/Song.php';
    function getDetailedSong($id){
        $song = new Song();
        $song = $song->getById($id);

        if(isset($song['album_id'])){
            $album = new Album();
            $album = $album->getById($song['album_id']);
        } else{
            // kalau ga null isi disini
        }
        

        return ['song-title' => $song['Judul'], 
            'song-artist' => $song['Penyanyi'], 
            'release-date' => $song['Tanggal_terbit'], 
            'song-genre' => $song['Genre'], 
            'song-album' => $album['Judul'], 
            'thumbnail' => $song['Image_path'], 
            'song-file' => $song['Audio_path'], 
            'song-duration' => $song['Duration']
        ];
    }

?>