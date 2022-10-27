window.onload = function(){
    
    let xhr = new XMLHttpRequest();

    xhr.onreadystatechange = function() { 
        if (xhr.readyState == 4 && xhr.status == 200) {
            let contents = document.getElementsByClassName("contents")[0];
            console.log(xhr.responseText);
            let result = JSON.parse(xhr.responseText);
            contents.innerHTML = "<tr> There is no song in this album </tr>";
            if (result[0] !== "") {
                contents.innerHTML = result[0];
            }
        }
    }
    url = "/app/controllers/SongsOfAlbumController.php?id=" + get_query()["id"];

    xhr.open("GET", url, true);
    xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
    xhr.send();
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

generateSong = function(img_src, title){
    let contents = document.getElementsByClassName('contents')[0];
    let detail_song = document.createElement('div');
    let image_song = document.createElement('img');
    let title_song = document.createElement('div');

    detail_song.classList.add('detail-song');
    image_song.classList.add('song-image');
    title_song.classList.add('song-title');

    image_song.setAttribute('src', img_src);
    title_song.appendChild(document.createTextNode(title));
    detail_song.appendChild(image_song);
    detail_song.appendChild(title_song);
    contents.appendChild(detail_song);
}