<?php

require_once __DIR__ . '/../database/database.php';
require_once __DIR__ . '/../config/constants.php';

class Album{
    private $db;
    private $table = DB_ALBUM_TABLE;

    public function __construct(){
        $this->db = new Database();
    }

}

?>