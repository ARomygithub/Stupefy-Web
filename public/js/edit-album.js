window.onload = function() {
    toggleSideBar();

    let albumTitle = document.getElementById("album-title");
    let albumArtist = document.getElementById("album-artist");
    let releaseDate = document.getElementById("release-date");
    let albumGenre = document.getElementById("album-genre");
    let thumbnailImage = document.getElementById("album-thumbnail");
    let songAlbum = document.getElementById("song-album");
    let songTable = document.getElementById("song-table");


    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const albumID = urlParams.get('id');


    let xhr = new XMLHttpRequest();
    let contents = document.getElementById("song-album");

    // [$cardOptions, $cardCurrentSong, $albumArtist, $albumName, $albumReleaseDate, $albumGenre, $albumThumbnail, $albumDuration]

    xhr.onreadystatechange = function() { 
        if (xhr.readyState == 4 && xhr.status == 200) {
            console.log(xhr.responseText);
            let result = JSON.parse(xhr.responseText);
            
            contents.innerHTML = "<option value='' disabled>Select Songs</option>";
            contents.innerHTML += "<option value='-1''> None</option>";
            if (result[0] !== "") {
                contents.innerHTML += result[0];
            }

            if(result[1] !=""){
                songTable.innerHTML += result[1];
            }

            albumArtist.value = result[2];
            albumArtist.disabled = true;
            if(result[2] !=""){
                songAlbum.value = "-1";
            } else{
                songAlbum.value = "-1";
            }

            albumTitle.value = result[3];
            releaseDate.value = result[4];
            albumGenre.value = result[5];
            thumbnailImage.src = result[6];


            for(let i=0; i<document.getElementsByClassName('error-message').length; i++){
                document.getElementsByClassName('error-message')[i].style.display = "none";
            }
            
        }
    }
    url = "/app/controllers/EditAlbumController.php/?id="+albumID;

    xhr.open("GET", url, true);
    xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
    xhr.send();
}

function toggleSideBar(){
    let sidebarActive = document.getElementsByClassName("active")[0];
    sidebarActive.classList.remove("active");
    sidebarActive.children[0].src = "/public/img/icons-"+sidebarActive.id +"-grey.png";

    let sidebar = document.getElementById("add-album");
    sidebar.classList.add("active");
    sidebar.children[0].src = "/public/img/icons-"+sidebar.id +".png";
}


function getThumbnail(event){
    document.getElementById("thumbnail-image").click();
}


function previewThumbnail(event){
    let image = document.getElementById("thumbnail-image");
    let thumbnail = document.getElementById("album-thumbnail");
    let thumbnailPath = document.getElementById("thumbnail-path");

    if(event.target.files[0].size > 2000000){
        document.getElementById("thumbnail-error").innerHTML = "Thumbnail size must be less than 2MB";
        document.getElementById("thumbnail-error").style.display = "block";
        image.value = "";
    } else{
        document.getElementById("thumbnail-error").style.display = "none";
        var input = event.target;
        var reader = new FileReader();
        reader.onload = function(){
            var dataURL = reader.result;
    
            thumbnail.src = dataURL;
            thumbnailPath.value = event.target.files[0].name;
        };

        reader.onerror = function (error) {
            image.value = "";
            console.log('Error: ', error);
        };

        reader.onabort = function (error) {
            image.value = "";
            console.log('Error: ', error);
        };

        reader.readAsDataURL(input.files[0]);
    }
}


function changeSongAlbum(event){
    let songAlbum = document.getElementById("song-album");
    let albumArtist = document.getElementById("album-artist");
    let currentSongs = document.getElementsByClassName("song-table-id")
    let songTable = document.getElementById("song-table");
    formData = new FormData();
    formData.append("songID", event.target.value);
    formData.append("album-artist", albumArtist.value);

    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const albumID = urlParams.get('id');
    formData.append("album-id", albumID);


    let songList = [];



    for(var i=0; i<currentSongs.length; i++){
        // console.log(currentSongs[i].value);
        songList.push(parseInt(currentSongs[i].value));
    }
    songList.push(parseInt(event.target.value));

    formData.append("Song[]", songList);
    formData.append("Query", true);

    for(var pair of formData.entries()) {
        console.log(pair[0]+ ', '+ pair[1]); 
    }

    if(event.target.value!=='-1'){
        let xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                console.log(xhr.responseText);
                let result = JSON.parse(xhr.responseText);
                
                songAlbum.innerHTML = "<option value='' disabled>Select Songs</option>";
                if (result[0] !== "") {
                    songAlbum.innerHTML += result[0];
                }
                if(result[1] !=""){
                    songTable.innerHTML += result[1];
                }

                if(result[2] !=""){
                    albumArtist.value = result[2];
                    albumArtist.disabled = true;
                    songAlbum.value = "-1";
                } else{
                    songAlbum.value = "-1";
                }

                for(let i=0; i<document.getElementsByClassName('error-message').length; i++){
                    document.getElementsByClassName('error-message')[i].style.display = "none";
                }
            }
        }

        url = "/app/controllers/EditAlbumController.php";

        xhr.open("POST", url, true);
        xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
        xhr.send(formData);
    }
}

function deleteCurrentSong($id){
    document.getElementById("song-table-row-"+$id).remove();

    let songAlbum = document.getElementById("song-album");
    let albumArtist = document.getElementById("album-artist");
    let currentSongs = document.getElementsByClassName("song-table-id")
    let songTable = document.getElementById("song-table");
    formData = new FormData();
    formData.append("song-id", $id);
    formData.append("album-artist", albumArtist.value);

    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const albumID = urlParams.get('id');
    formData.append("album-id", albumID);

    let songList = [];

    for(var i=0; i<currentSongs.length; i++){
        songList.push(parseInt(currentSongs[i].value));
    }

    formData.append("Song[]", songList);
    formData.append("Delete", true);

   

    if(event.target.value!=='-1'){
        let xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                console.log(xhr.responseText);
                let result = JSON.parse(xhr.responseText);
                
                if(currentSongs.length == 0){
                    albumArtist.disabled = false;
                    songAlbum.innerHTML = "<option value='' disabled>Select Songs</option>";
                    songAlbum.innerHTML += "<option value='-1' selected>None</option>";
                    if (result[0] !== "") {
                        songAlbum.innerHTML += result[0];
                    }
                    albumArtist.value = "";
                } else{
                    songAlbum.innerHTML = "<option value='' disabled>Select Songs</option>";
                    if (result[0] !== "") {
                        songAlbum.innerHTML += result[0];
                    }
                    songAlbum.value = "-1";
                }

                for(let i=0; i<document.getElementsByClassName('error-message').length; i++){
                    document.getElementsByClassName('error-message')[i].style.display = "none";
                }
            }
        }

        url = "/app/controllers/EditAlbumController.php";

        xhr.open("POST", url, true);
        xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
        xhr.send(formData);
    }

}



function submitform(event){
    event.preventDefault();
    let form = document.getElementById("add-album-form");
    let currentSongs = document.getElementsByClassName("song-table-id") || [];
    let formData = new FormData(form);

    let songList = [];

    for(var i=0; i<currentSongs.length; i++){
        songList.push(parseInt(currentSongs[i].value));
    }

    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const albumID = urlParams.get('id');
    formData.append("album-id", albumID);
    formData.append("album-artist", document.getElementById("album-artist").value);

    formData.append("Song[]", songList);
    formData.append("Update", true);


    for(var pair of formData.entries()) {
        console.log(pair[0]+ ', '+ pair[1]); 
    }

    if(validateForm(formData)){
        let xhr = new XMLHttpRequest();


        xhr.onreadystatechange = function() { 
            if (xhr.readyState == 4 && xhr.status == 200) {
                console.log(xhr.responseText);
                let result = JSON.parse(xhr.responseText);
                if(result['status'] === "success"){
                    alert(result['message']);
                    document.location.href = ".";
                } else{
                    document.getElementById(result['status']).innerHTML = result['message'];
                    document.getElementById(result['status']).style.display = "block";
                }
            }
        }

        xhr.onerror = function() {
            console.log("Error");
        }
        url = "/app/controllers/EditAlbumController.php";

        xhr.open("POST", url, true);
        xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
        xhr.send(formData);
    }
}

function validateForm(form){
    let error = false;
    let albumName = form.get("album-title");
    let albumReleaseDate = form.get("release-date");
    let thumbnail = form.get("thumbnail-image");
    let albumArtist = form.get("album-artist");


    if(albumName === ""){
        document.getElementById("album-title-error").innerHTML = "Album title is required";
        document.getElementById("album-title-error").style.display = "block";
        error = true;
    } else{
        document.getElementById("album-title-error").style.display = "none";
    }

    if(albumReleaseDate === ""){
        document.getElementById("release-date-error") .innerHTML= "Album release date is required";
        document.getElementById("release-date-error").style.display = "block";
        error = true;
    } else{
        document.getElementById("release-date-error").style.display = "none";
    }


    if(thumbnail.value === ""){
        document.getElementById("thumbnail-error").innerHTML = "Album file is required";
        document.getElementById("thumbnail-error").style.display = "block";
        error = true;
    } else{
        document.getElementById("thumbnail-error").style.display = "none";
    }

    if(albumArtist === ""){
        document.getElementById("album-artist-error").innerHTML = "Album artist is required";
        document.getElementById("album-artist-error").style.display = "block";
        error = true;
    } else{
        document.getElementById("album-artist-error").style.display = "none";
    }


    return !error;
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
