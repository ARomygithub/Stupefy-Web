<?php
    require_once __DIR__ . '/../models/Song.php';


    function createEntry($song, $i){
        $entry = '<tbody class="content-entry">'
            .'<tr>'
            . "<td class = 'content-id' rowspan='2'>" . $i . '</td>';
        if($song['Image_path'] == null){
            $song['Image_path'] = '/storage/default-thumbnail.png';
        }
        $entry .= "<td class = 'content-img-container' rowspan='2'>" . '<img src = ' . $song['Image_path'] . " class='content-img'>" . '</td>'
            . "<td class = 'content-title' >" . $song['Judul'] . '</td>'
            . "<td class = 'content-year' rowspan='2'>" . $song['Tahun'] . '</td>'
            . "<td class = 'content-genre' rowspan='2'>" . $song['Genre'] . '</td>'
            . '</tr> <tr>'
            . "<td class = 'content-artist'>" . $song['Penyanyi'] . '</td>'
            . '</tr> </tbody>';
        return $entry;
    }

    $songs = new Song();
    $songs = $songs->getTemplated(0, 10);
    $cards = '';
    $i = 1;
    foreach ($songs as $song) {
        $cards .= createEntry($song, $i);
        $i++;
    }

    echo json_encode([$cards]);
?>