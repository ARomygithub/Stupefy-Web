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

        if($song['Image_path'] == null){
            $song['Image_path'] = '/storage/thumbnail/default-thumbnail.png';
        }

        $tahun = $song['Tahun'];
        $genre = $song['Genre'];
        $judul = $song['Judul'];
        $penyanyi = $song['Penyanyi'];
        $image_path = $song['Image_path'];
        $song_id = $song['song_id'];


        $html = <<<"EOT"
            <tbody class="content-entry" id='song-table-row-$song_id'>
                <tr>
                    <td class = 'content-img-container' rowspan='2'>
                        <img src = $image_path class='content-img'>
                    </td>
                    <td class = 'content-title'>
                        $judul
                    </td>
                    <td class = 'content-year' rowspan='2'>
                        $tahun
                    </td>
                    <td class = 'content-genre' rowspan='2'>
                        $genre
                    </td>
                    <td class = 'content-action' rowspan='2'>
                        <input type="hidden" name="song-table-id" class="song-table-id" value="$song_id">
                        <a class="delete-button" name="delete" onclick = deleteCurrentSong($song_id)>
                            <img src="../../public/img/icons-delete.png" class="delete-icon">
                        </a>
                    </td>
                </tr>
                <tr>
                    <td class = 'content-artist'>
                        $penyanyi
                    </td>
                </tr>
            </tbody>
        EOT;

        return $html;
    }

    $songs = new Song();

    if(isset($_POST["Query"])){
        // $artist = $_POST["album-artist"];
        $currentSongs = $_POST["Song"];
        $songID = $_POST["songID"];
        
        
        $addedSongbyID = $songs->getCardByID($songID);
        $availableSongs = $songs->getAvailableSong($addedSongbyID['Penyanyi'], $currentSongs);
        $cardOptions = '';
        foreach ($availableSongs as $song) {
            $cardOptions .= createEntry($song);
        }
        $cardCurrentSong = createCurrentSong($addedSongbyID);

        echo json_encode([$cardOptions, $cardCurrentSong, $addedSongbyID['Penyanyi']]);
    } else if(isset($_POST["Delete"])){
        
        $currentSongs = $_POST["Song"];
        $id = $_POST["song-id"];

        if($currentSongs[0] == ""){
            $availableSongs = $songs->getAvailableSong("", []);
        }
        else{
            $availableSongs = $songs->getAvailableSong($songs->getArtistByID($id)['penyanyi'], $currentSongs);
        }
        $cardOptions = '';
        foreach ($availableSongs as $song) {
            $cardOptions .= createEntry($song);
        }
        echo json_encode([$cardOptions,  $currentSongs]);
    } else if(isset($_POST["Submit"])){
        $thumbnail_directory = "./../../storage/thumbnail//";
        $thumbnail_name = str_replace(" ", "_", $_FILES['thumbnail-image']['name']);

        $thumbnail_path = $thumbnail_directory . $thumbnail_name;; 

        $i=1;
        while(file_exists($thumbnail_path)){
            $song_file_path = $song_file_directory .$song_file_name."($i)";
            $i++;
        }

        if(!move_uploaded_file(str_replace(' ', '_', $_FILES['song-file']['tmp_name']), $thumbnail_file_path)){
            echo json_encode(['status' => 'thumbnail-error', 'message' => 'Failed to upload thumbnail file']);
        } else{
            $album = new Album();
            
            
            $albumName = $_POST["album-title"];
            $albumArtist = $_POST["album-artist"];
            $albumReleaseDate = date('Y-m-d', strtotime($_POST["release-date"]));
            $albumGenre = $_POST["album-genre"] or NULL;
            $albumSongs = $_POST["Song"];
            $album_duration = $songs->totalCount($albumSongs)['Total_duration'];

            $album->addAlbum($albumName, $albumArtist, $albumReleaseDate, $albumGenre, $albumSongs, $thumbnail_path, $album_duration);
            $songs->updateAlbumID($albumSongs, $album->getAlbumID($albumName, $albumArtist, $albumReleaseDate, $albumGenre, $albumSongs, $thumbnail_path, $album_duration));

            echo json_encode(['status' => 'success', 'message' => 'Album added successfully']);

        }


        


    }
    else{
        $songs = $songs->getAvailableSong('', []);
        $cards = '';
        foreach ($songs as $song) {
            $cards .= createEntry($song);
        }
        echo json_encode([$cards]);
    } 
    

?>