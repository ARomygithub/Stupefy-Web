<?php

require_once __DIR__ . '/../database/database.php';
require_once __DIR__ . '/../config/constants.php';

class User{
    private $db;
    private $table = DB_USER_TABLE;

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

    public function get($username, $is_admin = false, $offset, $limit){
        $this->db->prepare("SELECT * FROM $this->table WHERE username = :username AND is_admin = :is_admin LIMIT :offset, :limit");
        $this->db->bind(':username', $username);
        $this->db->bind(':is_admin', $is_admin);
        $user = $this->db->getOne();
        if($user){
            if($is_admin){
                if($user['is_admin'] == 1){
                    return $user;
                }
            }else{
                return $user;
            }
        }
        return false;
    }
}

?>