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


function deleteSong(){
    if(confirm("Do you really want to delete this song?")) {
        let $id = get_query()['id'];
        let xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() { 
            if (xhr.readyState == 4 && xhr.status == 200) {
                console.log(xhr.responseText);
                let result = JSON.parse(xhr.responseText);
                if(result["status"] === "success"){
                    alert(result["message"]);
                    window.location.href = "/public";
                }
                else{
                    alert("Delete failed");
                }
            }
        }
        url = "/app/controllers/SongController.php?id="+$id;

        xhr.open("DELETE", url, true);
        xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
        xhr.send();
    }
       
}

let songElem = document.getElementsByTagName("audio")[0];
songElem.addEventListener("play", function() {
    let xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if(xhr.readyState == 4 && xhr.status == 200){
            console.log(xhr.responseText);
            response = JSON.parse(xhr.responseText);
            if(response[0] === "play song success"){
                // bolehin play
                // songElem.load();
                // songElem.play();
            } else {
                // stopin play
                songElem.pause();
                songElem.innerHTML = "";
                alert("Total played have exceeded. Please login");
            }
        }
    };
    data = new FormData();
    data.set("play_song",true);
    data.set("song_id",get_query()['id']);
    xhr.open("POST", "/app/controllers/AuthController.php", true);
    xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
    xhr.send(data);
});