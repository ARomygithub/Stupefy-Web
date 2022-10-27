<?php
    require_once __DIR__ . '/../models/Album.php';
    require_once __DIR__ . '/../models/Song.php';


    function createEntry($song){
        $entry = '<option value=' . $song['song_id'] .'> ' . $song['Judul']. '</option>';
        return $entry;
    }

    function createCurrentSong($song){
        if(!isset($song['Penyanyi'])){
            $song['Penyanyi'] = 'Unknown';
        }
        if(!isset($song['Genre'])){
            $song['Genre'] = '-';
        }


        $entry = '<tbody class="content-entry"> <tr class="song-table-id" hidden value="' .$song['song_id'] . '"></tr>'
            .'<tr>';
        if($song['Image_path'] == null){
            $song['Image_path'] = '/storage/thumbnail/default-thumbnail.png';
        }
        $entry .= "<td class = 'content-img-container' rowspan='2'>" . '<img src = ' . $song['Image_path'] . " class='content-img'>" . '</td>'
            . "<td class = 'content-title' >" . $song['Judul'] . '</td>'
            . "<td class = 'content-year' rowspan='2'>" . $song['Tahun'] . '</td>'
            . "<td class = 'content-genre' rowspan='2'>" . $song['Genre'] . '</td>'
            . "<td class = 'delete' rowspan='2'> <a href='' onclick='deleteCurrentSong()' class='delete-icon'>" 
            . "<img src = './../../public/img/icons-delete.png' class='delete-icon-image'> </a>" . '</td>'
            . '</tr> <tr>'
            . "<td class = 'content-artist'>" . $song['Penyanyi'] . '</td>'
            . '</tr> </tbody>';
        return $entry;

    }


    $songs = new Song();

    if(isset($_POST["Query"])){
        $artist = $_POST["album-artist"];
        $currentSongs = $_POST["Song"];
        $songID = $_POST["songID"];
            
        $availableSongs = $songs->getAvailableSong($artist, $currentSongs);

        $cardOptions = '';
        foreach ($availableSongs as $song) {
            $cardOptions .= createEntry($song);
        }

        $addedSongbyID = $songs->getCardByID($songID);
        $cardCurrentSong = createCurrentSong($addedSongbyID);

        echo json_encode([$cardOptions, $cardCurrentSong, $addedSongbyID['Penyanyi']]);

    }else{
        $songs = $songs->getAvailableSong('', []);
        $cards = '';
        foreach ($songs as $song) {
            $cards .= createEntry($song);
        }
        echo json_encode([$cards]);
    }
    

?>