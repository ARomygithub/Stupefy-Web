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