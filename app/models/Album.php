<?php

require_once __DIR__ . '/../database/database.php';
require_once __DIR__ . '/../config/constants.php';

class Album{
    private $db;
    private $table = DB_ALBUM_TABLE;

    public function __construct(){
        $this->db = new Database();
    }

    public function getAll(){
        $this->db->prepare("SELECT * FROM $this->table");
        return $this->db->getAll();
    }

    public function getByID($id){
        $this->db->prepare("SELECT * FROM $this->table WHERE album_id = :id");
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

    public function get($offset, $limit){
        $this->db->prepare("SELECT * FROM $this->table LIMIT :offset, :limit");
        $this->db->bind(':offset', $offset);
        $this->db->bind(':limit', $limit);
        return $this->db->getAll();
    }

    public function getTemplated($offset, $limit){
        $this->db->prepare("SELECT album_id, Judul, Penyanyi, YEAR(Tanggal_terbit) AS Tahun, Genre, Image_path FROM $this->table ORDER BY last_updated DESC LIMIT :offset, :limit");
        $this->db->bind(':offset', $offset);
        $this->db->bind(':limit', $limit);
        return $this->db->getAll();
    }

    public function getAlbumSortByArtist(){
        $this->db->prepare("SELECT * FROM $this->table ORDER BY Penyanyi");
        return $this->db->getAll();
    }

    public function updateDuration($album_id, $add_duration){
        $this->db->prepare("UPDATE $this->table SET Total_duration = Total_duration + :add_duration WHERE album_id = :album_id");
        $this->db->bind(':add_duration', $add_duration);
        $this->db->bind(':album_id', $album_id);
        $this->db->execute();
    }

    public function addAlbum($albumName, $albumArtist, $albumReleaseDate, $albumGenre, $albumSongs, $thumbnail_path, $album_duration){
        $this->db->prepare("INSERT INTO $this->table (Judul, Penyanyi, Tanggal_terbit, Genre, Total_duration, Image_path) VALUES (:albumName, :albumArtist, :albumReleaseDate, :albumGenre, :album_duration, :thumbnail_path)");
        $this->db->bind(':albumName', $albumName);
        $this->db->bind(':albumArtist', $albumArtist);
        $this->db->bind(':albumReleaseDate', $albumReleaseDate);
        $this->db->bind(':albumGenre', $albumGenre);
        $this->db->bind(':album_duration', $album_duration);
        $this->db->bind(':thumbnail_path', $thumbnail_path);
        return $this->db->execute();
    }

    public function getAlbumID($albumName, $albumArtist, $albumReleaseDate, $albumGenre, $albumSongs, $thumbnail_path, $album_duration){
        $this->db->prepare("SELECT album_id FROM $this->table WHERE Judul = :albumName AND Penyanyi = :albumArtist AND Tanggal_terbit = :albumReleaseDate AND Genre = :albumGenre AND Total_duration = :album_duration AND Image_path = :thumbnail_path");
        $this->db->bind(':albumName', $albumName);
        $this->db->bind(':albumArtist', $albumArtist);
        $this->db->bind(':albumReleaseDate', $albumReleaseDate);
        $this->db->bind(':albumGenre', $albumGenre);
        $this->db->bind(':album_duration', $album_duration);
        $this->db->bind(':thumbnail_path', $thumbnail_path);
        return $this->db->getOne();
    }

    public function setAlbumID($albumName, $albumArtist, $albumReleaseDate, $albumGenre, $albumSongs, $thumbnail_path, $album_duration){
        $this->db->prepare("SELECT album_id FROM $this->table WHERE Judul = :albumName AND Penyanyi = :albumArtist AND Tanggal_terbit = :albumReleaseDate AND Genre = :albumGenre AND Total_duration = :album_duration AND Image_path = :thumbnail_path");
        $this->db->bind(':albumName', $albumName);
        $this->db->bind(':albumArtist', $albumArtist);
        $this->db->bind(':albumReleaseDate', $albumReleaseDate);
        $this->db->bind(':albumGenre', $albumGenre);
        $this->db->bind(':album_duration', $album_duration);
        $this->db->bind(':thumbnail_path', $thumbnail_path);
        return $this->db->getOne();
    }

    public function deleteAlbumbyID($id){
        $this->db->prepare("DELETE FROM $this->table WHERE album_id = :id");
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    public function getPath($id){
        $this->db->prepare("SELECT Image_path FROM $this->table WHERE album_id = :id");
        $this->db->bind(':id', $id);
        return $this->db->getOne();
    }
}

?>