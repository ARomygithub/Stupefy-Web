<?php

require_once __DIR__ . '/../database/database.php';
require_once __DIR__ . '/../config/constants.php';

class Song{
    private $db;
    private $table = DB_SONG_TABLE;

    public function __construct(){
        $this->db = new Database();
    }

    public function getAll(){
        $this->db->prepare("SELECT * FROM $this->table");
        return $this->db->getAll();
    }

    public function getAllGenre() {
        $this->db->prepare("SELECT DISTINCT Genre FROM $this->table WHERE Genre IS NOT NULL ORDER BY Genre");
        return $this->db->getAll();
    }

    public function getByID($id){
        $this->db->prepare("SELECT * FROM $this->table WHERE song_id = :id");
        $this->db->bind(':id', $id);
        return $this->db->getOne();
    }

    public function getCardByID($id){
        $this->db->prepare("SELECT song_id, Judul, Penyanyi, YEAR(Tanggal_terbit) AS Tahun, Genre, Image_path FROM $this->table WHERE song_id = :id");
        $this->db->bind(':id', $id);
        return $this->db->getOne();
    }

    public function getByGenre($genre, $offset, $limit){
        $this->db->prepare("SELECT * FROM $this->table WHERE genre = :genre LIMIT :offset, :limit");
        $this->db->bind(':genre', $genre);
        $this->db->bind(':offset', $offset);
        $this->db->bind(':limit', $limit);
        return $this->db->getAll();
    }

    public function getByAlbumID($album_id){
        $this->db->prepare("SELECT song_id, Judul, Penyanyi, YEAR(Tanggal_terbit) AS Tahun, Genre, Image_path FROM $this->table WHERE album_id = :album_id");
        $this->db->bind(':album_id', $album_id);
        return $this->db->getAll();
    }

    public function get($offset, $limit){
        $this->db->prepare("SELECT * FROM $this->table LIMIT :offset, :limit");
        $this->db->bind(':offset', $offset);
        $this->db->bind(':limit', $limit);
        return $this->db->getAll();
    }

    public function getTemplated($offset, $limit){
        $this->db->prepare("SELECT song_id, Judul, Penyanyi, YEAR(Tanggal_terbit) AS Tahun, Genre, Image_path FROM $this->table ORDER BY last_updated DESC LIMIT :offset, :limit");
        $this->db->bind(':offset', $offset);
        $this->db->bind(':limit', $limit);
        return $this->db->getAll();
    }

    public function getWithOrder($offset, $limit, $order_by, $order = 'ASC'){
        $this->db->prepare("SELECT song_id, Judul, Penyanyi, YEAR(Tanggal_terbit) AS Tahun, Genre, Image_path FROM {$this->table} ORDER BY $order_by $order LIMIT :offset, :limit");
        // $this->db->bind(':order_by', $order_by);
        // $this->db->bind(':order', $order);
        $this->db->bind(':offset', $offset);
        $this->db->bind(':limit', $limit);
        // $this->db->bind(':order_by', 'Judul');
        // // $this->db->bind(':order', "ASC");
        // $this->db->bind(':offset', 0);
        // $this->db->bind(':limit', 20);        

        return $this->db->getAll();
    }

    public function getWithOrderAndGenre($genre, $order, $orderby, $offset, $limit) {
        $this->db->prepare("SELECT song_id, Judul, Penyanyi, YEAR(Tanggal_terbit) AS Tahun, Genre, Image_path FROM {$this->table} WHERE genre = :genre ORDER BY $orderby $order LIMIT :offset, :limit");
        $this->db->bind(':genre', $genre);
        $this->db->bind(':offset', $offset);
        $this->db->bind(':limit', $limit);
        return $this->db->getAll();
    }

    public function search($keyword, $order, $orderby, $offset, $limit){
        $this->db->prepare("SELECT song_id, Judul, Penyanyi, YEAR(Tanggal_terbit) AS Tahun, Genre, Image_path FROM $this->table WHERE (Judul LIKE :keyword OR penyanyi LIKE :keyword or YEAR(tanggal_terbit) LIKE :keyword) ORDER BY $orderby $order LIMIT :offset, :limit");
        
        $this->db->bind(':keyword', "%$keyword%");
        // $this->db->bind(':orderby', "$orderby");
        // $this->db->bind(':order', "$order");
        $this->db->bind(':offset', $offset);
        $this->db->bind(':limit', $limit);
        return $this->db->getAll();
    }

    public function searchWithGenre($keyword, $genre, $order, $orderby, $offset, $limit) {
        $this->db->prepare("SELECT song_id, Judul, Penyanyi, YEAR(Tanggal_terbit) AS Tahun, Genre, Image_path FROM $this->table WHERE (Judul LIKE :keyword OR penyanyi LIKE :keyword or YEAR(tanggal_terbit) LIKE :keyword) AND genre = :genre ORDER BY $orderby $order LIMIT :offset, :limit");
        
        $this->db->bind(':keyword', "%$keyword%");
        $this->db->bind(':genre', $genre);
        $this->db->bind(':offset', $offset);
        $this->db->bind(':limit', $limit);
        return $this->db->getAll();
    }

    public function createSong($judul, $penyanyi, $tanggal_terbit, $genre, $image_path, $album_id, $song_path, $duration){
        $this->db->prepare("INSERT INTO $this->table (judul, penyanyi, tanggal_terbit, genre, image_path, album_id, audio_path, duration) VALUES (:judul, :penyanyi, :tanggal_terbit, :genre, :image_path, :album_id, :audio_path, :duration)");
        $this->db->bind(':judul', $judul);
        $this->db->bind(':penyanyi', $penyanyi);
        $this->db->bind(':tanggal_terbit', $tanggal_terbit);
        $this->db->bind(':genre', $genre);
        $this->db->bind(':image_path', $image_path);
        $this->db->bind(':album_id', $album_id);
        $this->db->bind(':audio_path', $song_path);
        $this->db->bind(':duration', $duration);

        return $this->db->execute();
    }

    public function getAvailableSong($penyanyi, $array_of_disabled, $album_id=NULL){

        if(!isset($penyanyi)){
            if(count($array_of_disabled) == 0){
                $this->db->prepare("SELECT song_id, Judul, Penyanyi, YEAR(Tanggal_terbit) AS Tahun, Genre, Image_path FROM $this->table WHERE album_id IS NULL");
                return $this->db->getAll();
            }
            else{
                $this->db->prepare("SELECT song_id, Judul, Penyanyi, YEAR(Tanggal_terbit) AS Tahun, Genre, Image_path FROM $this->table WHERE album_id IS NULL AND song_id NOT IN ("
                . implode(',',$array_of_disabled) . ")");
                return $this->db->getAll();
            }    
        }
        else{
            if(count($array_of_disabled) == 0){
                if(isset($album_id)){
                    $this->db->prepare("SELECT song_id, Judul, Penyanyi, YEAR(Tanggal_terbit) AS Tahun, Genre, Image_path FROM $this->table WHERE album_id = :album_id AND penyanyi = :penyanyi");
                    $this->db->bind(':penyanyi', $penyanyi);
                    $this->db->bind(':album_id', $album_id);
                    return $this->db->getAll();
                }
                else{
                    $this->db->prepare("SELECT song_id, Judul, Penyanyi, YEAR(Tanggal_terbit) AS Tahun, Genre, Image_path FROM $this->table WHERE album_id IS NULL AND penyanyi = :penyanyi");
                    $this->db->bind(':penyanyi', $penyanyi);
                    return $this->db->getAll();
                }
            }
            else{
                if(isset($album_id)){
                    $this->db->prepare("SELECT song_id, Judul, Penyanyi, YEAR(Tanggal_terbit) AS Tahun, Genre, Image_path FROM $this->table WHERE album_id = :album_id AND penyanyi = :penyanyi AND song_id NOT IN ("
                    . implode(',',$array_of_disabled) . ")");
                    $this->db->bind(':penyanyi', $penyanyi);
                    $this->db->bind(':album_id', $album_id);
                    return $this->db->getAll();
                }
                else{
                    $this->db->prepare("SELECT song_id, Judul, Penyanyi, YEAR(Tanggal_terbit) AS Tahun, Genre, Image_path FROM $this->table WHERE album_id IS NULL AND penyanyi = :penyanyi AND song_id NOT IN ("
                    . implode(',',$array_of_disabled) . ")");
                    $this->db->bind(':penyanyi', $penyanyi);
                    return $this->db->getAll();
                }
    
                return $this->db->getAll();
            }
        }
        
    }

    public function totalCount($albumSongs){
        if(count($albumSongs) == 0){
            return array('total_duration' => 0);
        }
        else{
            $this->db->prepare("SELECT SUM(Duration) AS total_duration FROM $this->table WHERE song_id IN ("
            . implode(',',$albumSongs) . ")");
            return $this->db->getOne();
        }
    }

    public function updateAlbumID($albumSongs, $album_id){
        if(count($albumSongs) == 0){
            return true;
        }
        else{
            $this->db->prepare("UPDATE $this->table SET album_id = :album_id WHERE song_id IN ("
            . implode(',',$albumSongs) . ")");
            $this->db->bind(':album_id', $album_id);
            return $this->db->execute();
        }
    }

    public function getArtistByID($id){
        $this->db->prepare("SELECT penyanyi FROM $this->table WHERE song_id = :id");
        $this->db->bind(':id', $id);
        return $this->db->getOne();
    }

    public function getPath($id){
        $this->db->prepare("SELECT Audio_path, Image_path FROM $this->table WHERE song_id = :id");
        $this->db->bind(':id', $id);
        return $this->db->getOne();
    }

    public function deleteSongbyID($id){
        $this->db->prepare("DELETE FROM $this->table WHERE song_id = :id");
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    public function updateAlbum($albumSongs, $albumID){
        $this->db->prepare("UPDATE $this->table SET album_id = NULL WHERE album_id = :album_id");
        $this->db->bind(':album_id', $albumID);
        if(count($albumSongs) == 0){
            return true;
        }
        else{
            $this->db->prepare("UPDATE $this->table SET album_id = :album_id WHERE song_id IN ("
            . implode(',',$albumSongs) . ")");
            $this->db->bind(':album_id', $albumID);
            return $this->db->execute();
        }
    }

    public function updateSong($songName, $songArtist, $songReleaseDate, $songGenre, $songId, $thumbnail_path){
        if(isset($thumbnail_path)){
            $this->db->prepare("UPDATE $this->table SET Judul = :songName, Penyanyi = :songArtist, Tanggal_terbit = :songReleaseDate, Genre = :songGenre, Image_path = :thumbnail_path WHERE song_id = :id");
            $this->db->bind(':songName', $songName);
            $this->db->bind(':songArtist', $songArtist);
            $this->db->bind(':songReleaseDate', $songReleaseDate);
            $this->db->bind(':songGenre', $songGenre);
            $this->db->bind(':thumbnail_path', $thumbnail_path);
            $this->db->bind(':id', $songId);
    
            return $this->db->execute();
        } else{
            $this->db->prepare("UPDATE $this->table SET Judul = :songName, Penyanyi = :songArtist, Tanggal_terbit = :songReleaseDate, Genre = :songGenre WHERE song_id = :id");
            $this->db->bind(':songName', $songName);
            $this->db->bind(':songArtist', $songArtist);
            $this->db->bind(':songReleaseDate', $songReleaseDate);
            $this->db->bind(':songGenre', $songGenre);
            $this->db->bind(':id', $songId);
    
            return $this->db->execute();
        }
    }
}

?>