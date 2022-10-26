<?php

define('DB_HOST', getenv('DB_HOST'));
define('DB_PORT', getenv('DB_PORT'));
define('DB_NAME', getenv('MYSQL_DATABASE'));
define('DB_USER', getenv('MYSQL_USER'));
define('DB_PASSWORD', getenv('MYSQL_PASSWORD'));
define('DB_ALBUM_TABLE', 'album');
define('DB_USER_TABLE', 'user');
define('DB_SONG_TABLE', 'song');
define('COOKIE_AUTH_EXPIRE', 86400);
define('COOKIE_AUTH_SECRET', 'menggokil');
?>