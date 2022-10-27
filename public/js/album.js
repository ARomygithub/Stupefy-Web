window.onload = function(){
    toggleSideBar();
}

function toggleSideBar(){
    let sidebarActive = document.getElementsByClassName("active")[0];
    sidebarActive.classList.remove("active");
    sidebarActive.children[0].src = "/public/img/icons-"+sidebarActive.id +"-grey.png";

    let sidebar = document.getElementById("music-album");
    sidebar.classList.add("active");
    sidebar.children[0].src = "/public/img/icons-"+sidebar.id +".png";
}