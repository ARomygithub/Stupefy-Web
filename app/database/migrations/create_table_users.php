<?php

require_once __DIR__ . '/../database.php';
require_once __DIR__ . '/../../config/constants.php';

function create_table_users(){
    $db = new Database();
    $db->prepare('CREATE TABLE IF NOT EXISTS user(
        user_id INT NOT NULL AUTO_INCREMENT,
        email VARCHAR(256) NOT NULL UNIQUE,
        password VARCHAR(256) NOT NULL,
        username VARCHAR(64) NOT NULL,
        name VARCHAR(256) NOT NULL,
        isAdmin BOOLEAN NOT NULL,
        last_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY(user_id)
    )');

    $db->execute();
}

?>