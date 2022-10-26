<?php
    require_once __DIR__ . '/../models/Album.php';
    require_once __DIR__ . '/../models/Song.php';


    function createEntry($album){
        $entry = '<option value=' . $album['album_id'] .'> ' . $album['Judul']. ' <em> by ' . $album['Penyanyi'] . '</em> </option>';
        return $entry;
    }

    $albums = new Album();
    if(isset($_GET['album'])){
        $albums = $albums->getByID(intval($_GET['album']));
        $cards = $albums['Penyanyi'];
        echo json_encode([$cards]);
    } else if(isset($_POST['add-song-form'])){
        $thumbnail_directory = "./../../storage/thumbnail//";
        $song_file_directory = "./../../storage//";

        $thumbnail_path = $thumbnail_directory . $_FILES['thumbnail-image']['name']; 
        
        $song_file_path = $song_file_directory . $_FILES['song-file']['name'];


        $i=1;
        while(file_exists($song_file_path)){
            $song_file_path = $song_file_directory . $_FILES['song-file']['name']."($i)";
            $i++;
        }

        $error = false;

        if( $_FILES['thumbnail-image']['name'] != "" ) {
            $i=1;
            while(file_exists($thumbnail_path)){
                $thumbnail_path = $thumbnail_directory . $_FILES['thumbnail-image']['name']."($i)";
                $i++;
            }

            if(!move_uploaded_file($_FILES['thumbnail-image']['tmp_name'], $thumbnail_path)){
                echo json_encode(['status' => 'thumbnail-error', 'message' => 'Failed to upload thumbnail image']);
                $error = true;
            }
        } else{
            $thumbnail_path = $thumbnail_directory . 'default-thumbnail.png';    
        }

        if(!$error&& !move_uploaded_file($_FILES['song-file']['tmp_name'], $song_file_path)){
            echo json_encode(['status' => 'song-file-error', 'message' => 'Failed to upload song file']);
            $error = true;
        }

        if(!$error){
            $song = new Song();
            $Judul = $_POST['song-title'];
            $Penyanyi = $_POST['song-artist'] or NULL;
            $Album = $_POST['song-album'];
            if($Album === '-1'){
                $Album = NULL;
            }
            $Thumbnail = $thumbnail_path;
            $Lagu = $song_file_path;
            $Raw_durasi = $_POST['duration'];
            $Durasi = Floor($Raw_durasi);
    
            $Genre = $_POST['song-genre'] or NULL;
            $Raw_tanggal_terbit = $_POST['release-date'];
            $Tanggal_terbit = date('Y-m-d', strtotime($Raw_tanggal_terbit));
            
            $song->createSong($Judul, $Penyanyi, $Tanggal_terbit, $Genre, $Thumbnail, $Album, $Lagu, $Durasi);
    
            if(isset($Album)){
                $albums->updateDuration($Album, $Durasi);
            }
            
            echo json_encode(['status' => 'success', 'message' => 'Song added successfully']);
        }
    } 
    else{
        $albums = $albums->getAlbumSortByArtist();
        $cards = '';
        foreach ($albums as $album) {
            $cards .= createEntry($album);
        }
        echo json_encode([$cards]);
    }
    
