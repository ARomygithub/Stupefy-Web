window.onload = function() {
    toggleSideBar();

    let songTitle = document.getElementById("song-title");
    let songArtist = document.getElementById("song-artist");
    let releaseDate = document.getElementById("release-date");
    let songGenre = document.getElementById("song-genre");
    let thumbnailImage = document.getElementById("song-thumbnail");
    let songAlbum = document.getElementById("song-album");
    let songPath = document.getElementById("song-path");


    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const albumID = urlParams.get('id');

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
    let thumbnail = document.getElementById("song-thumbnail");
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


function submitform(event){
    event.preventDefault();
    let form = document.getElementById("add-song-form");
    let formData = new FormData(form);

    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const songID = urlParams.get('id');
    formData.append("song-id", songID);
    formData.append("song-artist", document.getElementById("song-artist").value);

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
        url = "/app/controllers/EditSongController.php";

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
        document.getElementById("song-title-error").innerHTML = "Album title is required";
        document.getElementById("song-title-error").style.display = "block";
        error = true;
    } else{
        document.getElementById("song-title-error").style.display = "none";
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
        document.getElementById("song-artist-error").innerHTML = "Album artist is required";
        document.getElementById("song-artist-error").style.display = "block";
        error = true;
    } else{
        document.getElementById("song-artist-error").style.display = "none";
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
