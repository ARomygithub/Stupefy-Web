window.onload = function(){
    
}

function getDetailedAlbum($id){
    if($id===-1){
        //do nothing
    }
    else{
        window.location.href = "/public/detail-album.php?id="+$id;
    }
}

function editSong(){
    let $id = get_query()['id'];
    window.location.href = "/public/edit-song.php?id="+$id;
    console.log("/public/edit-song.php?id="+$id);
}

function get_query(){
    var url = location.href;
    var qs = url.substring(url.indexOf('?') + 1).split('&');
    for(var i = 0, result = {}; i < qs.length; i++){
        qs[i] = qs[i].split('=');
        result[qs[i][0]] = qs[i][1];
    }
    return result;
}