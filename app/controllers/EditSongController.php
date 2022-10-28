<?php
    require_once __DIR__ . '/../models/Album.php';
    require_once __DIR__ . '/../models/Song.php';

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        if($_POST['Update']){
            $thumbnail_directory = "./../../storage/thumbnail//";
            if($_FILES['thumbnail-image']['name'] != ""){
                $thumbnail_name = str_replace(" ", "_", $_FILES['thumbnail-image']['name']);
                $thumbnail_path = $thumbnail_directory . $thumbnail_name; 
                $i=1;
                while(file_exists($thumbnail_path)){
                    $thumbnail_path = $thumbnail_directory ."($i)".$thumbnail_name;
                    $i++;
                }
                if(!move_uploaded_file(str_replace(' ', '_', $_FILES['thumbnail-image']['tmp_name']), $thumbnail_path)){
                    echo json_encode(['status' => 'thumbnail-error', 'message' => 'Failed to upload thumbnail file']);
                    return;
                }
            } else{
                $thumbnail_path = null;
            }
            
            
            $song = new Song();
            
            $songID = intval($_POST["song-id"]);
            $songName = $_POST["song-title"];
            $songArtist = $_POST["song-artist"];
            $songReleaseDate = date('Y-m-d', strtotime($_POST["release-date"]));
            $songGenre = $_POST["song-genre"] or NULL;
    
            $old_image_path = $song->getByID($songID)['Image_path'];
            if(!isset($thumbnail_path)){
                $thumbnail_path = $old_image_path;
            }
    
            $song->updateSong($songName, $songArtist, $songReleaseDate, $songGenre, $songID, $thumbnail_path);
    
            
    
            echo json_encode(['status' => 'success', 'message' => 'Song updated successfully']);
        }
    }
?>