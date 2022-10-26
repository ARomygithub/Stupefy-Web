<?php

require_once __DIR__ . '/../database.php';
require_once __DIR__ . '/../../config/constants.php';

function create_table_albums(){
    $db = new Database();
    $db->prepare('CREATE TABLE IF NOT EXISTS  album(
        album_id INT NOT NULL AUTO_INCREMENT,
        Judul VARCHAR(64) NOT NULL,
        Penyanyi VARCHAR(128),
        Total_duration INT NOT NULL,
        Image_path VARCHAR(256),
        Tanggal_terbit DATE NOT NULL,
        Genre VARCHAR(64),
        last_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY(album_id)
    )');

    $db->execute();
}
?>

