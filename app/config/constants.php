<?php

define('DB_HOST', 'localhost');
define('DB_NAME', $_ENV('MYSQL_DATABASE'));
define('DB_USER', $_ENV('MYSQL_USER'));
define('DB_PASSWORD', $_ENV('MYSQL_PASSWORD'));
define('DB_ALBUM_TABLE', 'album');
define('DB_USER_TABLE', 'user');
define('DB_SONG_TABLE', 'song');
?>