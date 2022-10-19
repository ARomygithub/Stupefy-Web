<?php

require_once __DIR__ . '/create_table_users.php';
require_once __DIR__ . '/create_table_albums.php';
require_once __DIR__ . '/create_table_songs.php';

function create_tables(){
    create_table_users();
    create_table_albums();
    create_table_songs();
}

create_tables()

?>