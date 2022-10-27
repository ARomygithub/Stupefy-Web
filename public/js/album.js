window.onload = function(){
    toggleSideBar();

    let xhr = new XMLHttpRequest();

    xhr.onreadystatechange = function() { 
        if (xhr.readyState == 4 && xhr.status == 200) {
            let contents = document.getElementsByClassName("content-album")[0];
            console.log(xhr.responseText);
            let result = JSON.parse(xhr.responseText);
            contents.innerHTML = "<p>Unfortunately, there is no album for you </p>";
            if (result[0] !== "") {
                contents.innerHTML = result[0];
            }
        }
    }
    url = "/app/controllers/ListAlbumController.php";

    xhr.open("GET", url, true);
    xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
    xhr.send();
}

function toggleSideBar(){
    let sidebarActive = document.getElementsByClassName("active")[0];
    sidebarActive.classList.remove("active");
    sidebarActive.children[0].src = "/public/img/icons-"+sidebarActive.id +"-grey.png";

    let sidebar = document.getElementById("music-album");
    sidebar.classList.add("active");
    sidebar.children[0].src = "/public/img/icons-"+sidebar.id +".png";
}

function getDetailedAlbum($id){
    window.location.href = "/public/detail-album.php?id="+$id;
}