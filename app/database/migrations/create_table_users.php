<?php

require_once __DIR__ . '/../database.php';
require_once __DIR__ . '/../../config/constants.php';

function create_table_users(){
    $db = new Database();
    $db->prepare('CREATE TABLE IF NOT EXISTS user(
        user_id INT NOT NULL AUTO_INCREMENT,
        email VARCHAR(256) NOT NULL,
        password VARCHAR(256) NOT NULL,
        username VARCHAR(64) NOT NULL,
        isAdmin BOOLEAN NOT NULL,
        PRIMARY KEY(user_id)
    )');

    $db->execute();
}

?>