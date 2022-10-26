<?php
    require_once __DIR__ . '/../app/models/Album.php';

    function echo_card($title = "Album Title", $artist = "Artist", $year = "1970", $genre = "Music", $image_src = "../storage/default-song-thumbnail.png"){
        $html = <<<"EOT"
            <div class="card">
                <div class="image-container">
                    <image src="$image_src" />
                </div>
                <div class="main-info">
                    <div class="album-title">$title</div>
                    <div class="artist">$artist</div>
                </div>
                <div class="year">$year</div>
                <div class="genre">$genre</div>
            </div>
        EOT;

        echo $html;
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Binotify</title>
    <link rel="stylesheet" href="css/album.css" />
</head>
<body>
    <div id="container">
        <h1>Albums</h1>
        <div id="content">
            <?php 
                echo_card("Mantra Hujan", "Kobo Kanaeru", "2022", "VTuber"); 
                echo_card("Mantra Hujan", "Kobo Kanaeru", "2022", "VTuber"); 
            ?>
        </div>
    </div>
</body>
</html>