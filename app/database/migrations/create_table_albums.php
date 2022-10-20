<?php

require_once __DIR__ . '/../database.php';
require_once __DIR__ . '/../../config/constants.php';

function create_table_albums(){
    $db = new Database();
    $db->prepare('CREATE TABLE IF NOT EXISTS  album(
        album_id INT NOT NULL AUTO_INCREMENT,
        Judul VARCHAR(64) NOT NULL,
        Penyanyi VARCHAR(128) NOT NULL,
        Total_duration INT NOT NULL,
        Image_path VARCHAR(256) NOT NULL,
        Tanggal_terbit DATE NOT NULL,
        Genre VARCHAR(64) NOT NULL,
        PRIMARY KEY(album_id)
    )');

    $db->execute();
}
?>

