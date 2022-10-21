<?php
    function echo_card($title = "Album Title", $artist = "Artist", $year = "1970", $genre = "Music"){
        $html = <<<"EOT"
            <div class="card">
                <div style="background-color: white; aspect-ratio: 1;"></div>
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
            <?php echo_card("Mantra Hujan", "Kobo Kanaeru", "2022", "VTuber"); ?>
            <?php echo_card("Mantra Hujan", "Kobo Kanaeru", "2022", "VTuber"); ?>
            <?php echo_card("Mantra Hujan", "Kobo Kanaeru", "2022", "VTuber"); ?>
            <?php echo_card("Mantra Hujan", "Kobo Kanaeru", "2022", "VTuber"); ?>
            <?php echo_card("Mantra Hujan", "Kobo Kanaeru", "2022", "VTuber"); ?>
            <?php echo_card("Mantra Hujan", "Kobo Kanaeru", "2022", "VTuber"); ?>
        </div>
    </div>
</body>
</html>