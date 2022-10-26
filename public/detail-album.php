<?php
    function echo_detail_album($title = "Album Title", $artist = "Artist", $total_duration = 0){
        $secs = $total_duration%60;
        $mins = intdiv($total_duration,60)%60;
        $hour = intdiv($total_duration,3600);
        $html = <<<"EOT"
            <div id="detail-album">
                <div style="background-color: white; aspect-ratio: 1; width: 200px; margin: 20px;"></div>
                <div class="main-info">
                    <div class="album-title">$title</div>
                    <div class="artist">$artist</div>
                    <div class="duration">$hour Hours $mins Minutes $secs Seconds</div>
                </div>
            </div>
        EOT;

        echo $html;
    }

    function echo_song($title = "Song Title"){
        $html = <<<"EOT"
            <div class="detail-song">
                <div style="background-color: white; aspect-ratio: 1; height: 50px; margin: 20px;"></div>
                <div class="song-title">$title</div>
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
    <link rel="stylesheet" href="css/detail-album.css" />
</head>
<body>
    <div id="container">
        <?php echo_detail_album("4 phenomena", "Photon Maiden", 3098) ?>
        <?php echo_song("4 Challanges") ?>
        <?php echo_song("4 Challanges") ?>
    </div>
</body>
</html>