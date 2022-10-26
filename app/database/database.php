<?php

require_once __DIR__ . '/../config/constants.php';
require_once __DIR__ . '/../config/constants.php';

class Database{
    private $host = DB_HOST;
    private $port = DB_PORT;
    private $db_name = DB_NAME;
    private $username = DB_USER;
    private $password = DB_PASSWORD;
    private $conn;
    private $stmt;

    public function __construct(){
        $this->conn = null;

        try{
            $this->conn = new PDO("mysql:host=" . $this->host . ";port=" . $this->port . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e){
            die('Connection Error: ' . $e->getMessage());
        }
    }

    public function prepare($query){
        $this->stmt = $this->conn->prepare($query);
    }

    public function execute(){
        $this->stmt->execute();
    }

    public function bind($param, $value, $type = null){
        if(is_null($type)){
            if(is_int($value)){
                $type = PDO::PARAM_INT;
            }
            else if(is_bool($value)){
                $type = PDO::PARAM_BOOL;
            }
            else if(is_null($value)){
                $type = PDO::PARAM_NULL;
            }
            else{
                $type = PDO::PARAM_STR;
            }
        }

        $this->stmt->bindValue($param, $value, $type);
    }

    
    public function getAll(){
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getOne(){
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function rowCount(){
        return $this->stmt->rowCount();
    }

    public function lastInsertId(){
        $this->execute();
        return $this->conn->lastInsertId();
    }
}

?>