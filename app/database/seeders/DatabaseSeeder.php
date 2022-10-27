<?php

require_once __DIR__ . '/../database.php';

function generateRandomString(){
    $res = '';
    $len = random_int(1, 16);
    for($j = 0; $j<$len; $j++){
        if($j === 0){
            $res .= chr(random_int(65, 90));
        } else {
            if($j%2===0){
                $res .= chr(random_int(97, 122));
            }
            else{
                $res .= 'aiueo'[random_int(0, 4)];
            }
        }
    }

    return $res;
}

function seed(){
    $db = new Database();

    $db->prepare('INSERT INTO user(email, password, username, name, isAdmin) VALUES(:email, :password, :username, :name, :isAdmin)');
    $db->bind(':email', 'test' . '@test.com');
    $db->bind(':password', password_hash('test', PASSWORD_DEFAULT));
    $db->bind(':username', 'test');
    $db->bind(':name', 'test');
    $db->bind(':isAdmin', 0);
    $db->execute();


    /*
        Judul VARCHAR(64) NOT NULL,
        Penyanyi VARCHAR(128) NOT NULL,
        Total_duration INT NOT NULL,
        Image_path VARCHAR(256) NOT NULL,
        Tanggal_terbit DATE NOT NULL,
        Genre VARCHAR(64) NOT NULL,

        Judul VARCHAR(64) NOT NULL,
        Penyanyi VARCHAR(128) NOT NULL,
        Tanggal_terbit DATE NOT NULL,
        Genre VARCHAR(64) NOT NULL,
        Duration INT NOT NULL,
        Audio_path VARCHAR(256) NOT NULL,
        Image_path VARCHAR(256),
        album_id INT NOT NULL,
    */
   $db->prepare('INSERT INTO album(Judul, Penyanyi, Total_duration, Image_path, Tanggal_terbit, Genre) VALUES(:Judul, :Penyanyi, :Total_duration, :Image_path, :Tanggal_terbit, :Genre)');
   for($i = 0; $i<100; $i++){
       $db->bind(':Judul', generateRandomString());
       $db->bind(':Penyanyi', generateRandomString());
       $db->bind(':Total_duration', random_int(1, 1000));
       $db->bind(':Image_path', '/storage/thumbnail/default-thumbnail.png');
       $db->bind(':Tanggal_terbit', '2021-01-01');
       $db->bind(':Genre', generateRandomString());
       $db->execute();
   }


    $db->prepare('INSERT INTO song(judul, penyanyi, tanggal_terbit, genre, duration, audio_path, album_id) VALUES(:title, :artist, :tanggal_terbit, :genre, :duration, :audio_path, :album_id)');
    for($i = 0; $i<100; $i++){
        $db->bind(':title', generateRandomString());
        $db->bind(':artist', generateRandomString());
        $db->bind(':tanggal_terbit', '2019-12-12');
        $db->bind(':genre', generateRandomString());
        $db->bind(':duration', random_int(1, 1000));
        $db->bind(':audio_path', '/storage/Believer.mp3');
        $db->bind(':album_id', random_int(1, 100));
        $db->execute();
    }
}

seed();


?>