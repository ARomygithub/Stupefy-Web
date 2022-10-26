
window.onload = function() {
    let xhr = new XMLHttpRequest();
    let contents = document.getElementById("song-album");

    xhr.onreadystatechange = function() { 
        if (xhr.readyState == 4 && xhr.status == 200) {
            let result = JSON.parse(xhr.responseText);
            
            contents.innerHTML = "<option value='' disabled>Select Album</option>";
            contents.innerHTML += "<option value='-1' id='null-valued-album'> None</option>";
            if (result[0] !== "") {
                contents.innerHTML += result[0];
            }
        }
    }
    url = "/app/controllers/SongController.php";

    xhr.open("GET", url, true);
    xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
    xhr.send();
    toogleSideBar();
}

function toogleSideBar(){
    let sidebarActive = document.getElementsByClassName("active")[0];
    sidebarActive.classList.remove("active");
    sidebarActive.children[0].src = "/public/img/icons-"+sidebarActive.id +"-grey.png";

    let sidebar = document.getElementById("add-song");
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

    var input = event.target;
    var reader = new FileReader();
    reader.onload = function(){
        var dataURL = reader.result;

        thumbnail.src = dataURL;
        thumbnailPath.value = event.target.files[0].name;
    };
    reader.readAsDataURL(input.files[0]);
}



function getAlbumArtist(event){
    console.log(event.target.value);
    let xhr = new XMLHttpRequest();
    let contents = document.getElementById("song-artist");

    if(event.target.value!=='-1'){
        
        xhr.onreadystatechange = function() { 
            if (xhr.readyState == 4 && xhr.status == 200) {
                let result = JSON.parse(xhr.responseText);
                
                contents.value = result[0];
                contents.disabled = true;
            }
        }
        url = "/app/controllers/SongController.php?album=" + event.target.value;

        xhr.open("GET", url, true);
        xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
        xhr.send();
    } else{
        contents.value = "";
        contents.disabled = false;
    }
}

function getSong(event){
    document.getElementById("song-file").click();
}

function previewSong(event){
    let song = document.getElementById("song-file");
    let songPath = document.getElementById("song-path");
    let songPreview = document.getElementById("song-preview");
    let audio = document.getElementById("add-audio");

    var input = event.target;
    var reader = new FileReader();
    reader.onload = function(){
        var dataURL = reader.result;
        // console.log(dataURL);
        songPreview.src = dataURL;
        songPath.value = event.target.files[0].name;
        audio.load();
        audio.play();
    };
    reader.readAsDataURL(input.files[0]);
}

