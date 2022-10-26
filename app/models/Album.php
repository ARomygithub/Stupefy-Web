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
}

?>