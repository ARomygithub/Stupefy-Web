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

    public function getByID($id){
        $this->db->prepare("SELECT * FROM $this->table WHERE id = :id");
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
        $this->db->prepare("SELECT * FROM $this->table WHERE album_id = :album_id");
        $this->db->bind(':album_id', $album_id);
        return $this->db->getAll();
    }

    public function get($offset, $limit){
        $this->db->prepare("SELECT * FROM $this->table LIMIT :offset, :limit");
        $this->db->bind(':offset', $offset);
        $this->db->bind(':limit', $limit);
        return $this->db->getOne();
    }

    public function getWithOrder($offset, $limit, $order_by, $order = 'ASC'){
        $this->db->prepare("SELECT * FROM $this->table ORDER BY :order_by :order LIMIT :offset, :limit");
        $this->db->bind(':offset', $offset);
        $this->db->bind(':limit', $limit);
        $this->db->bind(':order_by', $order_by);
        $this->db->bind(':order', $order);

        return $this->db->getAll();
    }

    public function search($keyword, $offset, $limit){
        $this->db->prepare("SELECT * FROM $this->table 
        WHERE (judul LIKE :keyword OR penyanyi LIKE :keyword or CAST(YEAR(tanggal_terbit) AS VARCHAR) LIKE :keyword)
        LIMIT :offset, :limit");
        
        $this->db->bind(':keyword', "%$keyword%");
        $this->db->bind(':offset', $offset);
        $this->db->bind(':limit', $limit);
        return $this->db->getAll();
    }

}

?>