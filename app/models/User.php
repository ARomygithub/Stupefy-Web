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
        $this->db->prepare("SELECT * FROM $this->table WHERE user_id = :id");
        $this->db->bind(':id', $id);
        return $this->db->getOne();
    }

    public function getBacthData($offset, $limit){
        $this->db->prepare("SELECT * FROM $this->table LIMIT :offset, :limit");
        $this->db->bind(':offset', $offset);
        $this->db->bind(':limit', $limit);
        return $this->db->getAll();
    }

    public function get($username, $limit, $isAdmin = false){
        $this->db->prepare("SELECT * FROM $this->table WHERE username = :username AND isAdmin = :isAdmin LIMIT :limit");
        $this->db->bind(':username', $username);
        $this->db->bind(':isAdmin', $isAdmin);
        $this->db->bind(':limit', $limit);
        $user = $this->db->getOne();
        if($user){
            if($isAdmin){
                if($user['isAdmin'] == 1){
                    return $user;
                }
            }else{
                return $user;
            }
        }
        return false;
    }

    public function getByUsername($username) {
        $this->db->prepare("SELECT * FROM $this->table WHERE username = :username");
        $this->db->bind(':username', $username);
        return $this->db->getOne();
    }

    public function getByEmail($email) {
        $this->db->prepare("SELECT * FROM $this->table WHERE email = :email");
        $this->db->bind(':email', $email);
        return $this->db->getOne();
    }

    public function signup($data){
        if(!isset($data['name']) || !isset($data['username']) || !isset($data['email']) || !isset($data['password'])){
            return false;
        }
        $this->db->prepare("INSERT INTO $this->table (name, username, email, password, isAdmin) VALUES (:name, :username, :email, :password, false)");
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':username', $data['username']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':password', PASSWORD_HASH($data['password'], PASSWORD_DEFAULT));
        $id = $this->db->lastInsertId();
        if(!empty($id)){
            return $id;
        } else {
            return false;
        }
    }
}

?>