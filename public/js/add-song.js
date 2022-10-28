
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

            for(let i=0; i<document.getElementsByClassName('error-message').length; i++){
                document.getElementsByClassName('error-message')[i].style.display = "none";
            }
            
        }
    }
    url = "/app/controllers/SongController.php";

    xhr.open("GET", url, true);
    xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
    xhr.send();
    toggleSideBar();
}

function toggleSideBar(){
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

    if(event.target.files[0].size > 10000000){
        document.getElementById("song-file-error").innerHTML = "Song size must be less than 10MB";
        document.getElementById("song-file-error").style.display = "block";
        song.value = "";
    } else{
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

        reader.onerror = function (error) {
            song.value = "";
            console.log('Error: ', error);
        };

        reader.onabort = function (error) {
            song.value = "";
            console.log('Error: ', error);
        };

        reader.readAsDataURL(input.files[0]);
    }

    
}

function submitform(event){
    event.preventDefault();
    let form = document.getElementById("add-song-form");
    let audio = document.getElementById("add-audio");
    let formData = new FormData(form);

    if(!formData['song-artist']){
        formData.append('song-artist', document.getElementById("song-artist").value);
    }

    if(validateForm(formData)){
        formData.append("duration", audio.duration);
        formData.append("add-song-form", true);



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
        url = "/app/controllers/SongController.php";

        xhr.open("POST", url, true);
        xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
        xhr.send(formData);
    }

    
}

function validateForm(form){
    let error = false;
    let songName = form.get("song-title");
    let songReleaseDate = form.get("release-date");
    let songFile = form.get("song-file");


    if(songName === ""){
        document.getElementById("song-title-error").innerHTML = "Song title is required";
        document.getElementById("song-title-error").style.display = "block";
        error = true;
    } else{
        document.getElementById("song-title-error").style.display = "none";
    }

    if(songReleaseDate === ""){
        document.getElementById("release-date-error") .innerHTML= "Song release date is required";
        document.getElementById("release-date-error").style.display = "block";
        error = true;
    } else{
        document.getElementById("release-date-error").style.display = "none";
    }

    if(songFile.value === ""){
        document.getElementById("song-file-error").innerHTML = "Song file is required";
        document.getElementById("song-file-error").style.display = "block";
        error = true;
    } else{
        document.getElementById("song-file-error").style.display = "none";
    }

    return !error;
}
