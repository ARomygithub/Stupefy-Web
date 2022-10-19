<?php

require_once __DIR__ . '/../database/database.php';
require_once __DIR__ . '/../config/constants.php';

class Song{
    private $db;
    private $table = DB_SONG_TABLE;

    public function __construct(){
        $this->db = new Database();
    }

}

?>