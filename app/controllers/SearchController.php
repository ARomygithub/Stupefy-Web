<?php
    require_once __DIR__ . '/../models/Song.php';

    function createEntry($song, $i){
        if(!isset($song['Penyanyi'])){
            $song['Penyanyi'] = 'Unknown';
        }
        if(!isset($song['Genre'])){
            $song['Genre'] = '-';
        }


        $entry = '<tbody class="content-entry">'
            .'<tr>'
            . "<td class = 'content-id' rowspan='2'>" . $i . '</td>';
        if($song['Image_path'] == null){
            $song['Image_path'] = '/storage/thumbnail/default-thumbnail.png';
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

    if(isset($_GET["search"])) {
        $searchValue = $_GET["search"];
        $searchBy = "all";
        $order = "ASC";
        $orderby = "Judul";
        $genre = "all";
        $offset = 0;
        $limit = 10;
        if(isset($_GET['searchby'])) {
            $searchBy = $_GET['searchby'];
        }
        if(isset($_GET['order'])) {
            $order = $_GET['order']; 
        }
        if(isset($_GET['orderby'])) {
            $orderby = $_GET['orderby'];
        }
        if(isset($_GET['genre'])) {
            $genre = $_GET['genre'];
        }
        if(isset($_GET['offset'])) {
            $offset = (int)$_GET['offset'];
        }
        if(isset($_GET['limit'])) {
            $limit = (int)$_GET['limit'];
        }
        $song = new Song();
        if($searchBy==="all" && $genre==="all") {
            if($searchValue==="") {
                // echo "tes";
                $songs = $song->getWithOrder($offset, $limit*4, $orderby, $order);
            } else {
                $songs = $song->search($searchValue, $order, $orderby, $offset, $limit*4); //cek 3 page berikutnya jg
            }
        }
        // } else if($searchBy==="all" && $genre!=="all") {
        //     $songs = $song->searchByGenre($searchValue, $genre, $order, $orderby);
        // } else if($searchBy!=="all" && $genre==="all") {
        //     $songs = $song->searchBy($searchValue, $searchBy, $order, $orderby);
        // } else {
        //     $songs = $song->searchByAndGenre($searchValue, $genre, $searchBy, $order, $orderby);
        // }
        $cards = '';
        $count = count($songs);
        for($i=0; $i<min($count,$limit); $i++) {
            $cards .= createEntry($songs[$i], $i+$offset+1);
        }
        $data = [$cards, $count];
        echo json_encode($data);
        // echo json_encode([$song->getWithOrder(0,20,"Judul","ASC"),$count]);
    }
?>