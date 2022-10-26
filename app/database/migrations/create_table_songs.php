<?php

require_once __DIR__ . '/../database.php';
require_once __DIR__ . '/../../config/constants.php';

function create_table_songs(){
    $db = new Database();
    $db->prepare('CREATE TABLE IF NOT EXISTS song(
        song_id INT NOT NULL AUTO_INCREMENT,
        Judul VARCHAR(64) NOT NULL,
        Penyanyi VARCHAR(128),
        Tanggal_terbit DATE NOT NULL,
        Genre VARCHAR(64),
        Duration INT NOT NULL,
        Audio_path VARCHAR(256) NOT NULL,
        Image_path VARCHAR(256),
        album_id INT,
        last_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY(song_id),
        FOREIGN KEY(album_id) REFERENCES album(album_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
    )');

    $db->execute();
}

?>