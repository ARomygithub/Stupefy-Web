window.onload = function(){
    toogleSideBar();
    let xhr = new XMLHttpRequest();

    xhr.onreadystatechange = function() { 
        if (xhr.readyState == 4 && xhr.status == 200) {
            let contents = document.getElementsByClassName("contents")[0];
            console.log(xhr.responseText);
            let result = JSON.parse(xhr.responseText);
        
            contents.innerHTML = "<tr> There are currently no user available </tr>";
            if (result[0] !== "") {
                contents.innerHTML = result[0];
            }
        }
    }
    url = "/app/controllers/UserController.php";

    xhr.open("GET", url, true);
    xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
    xhr.send();
}

function toogleSideBar(){
    let sidebarActive = document.getElementsByClassName("active")[0];
    sidebarActive.classList.remove("active");
    sidebarActive.children[0].src = "/public/img/icons-"+sidebarActive.id +"-grey.png";

    let sidebar = document.getElementById("users");
    sidebar.classList.add("active");
    sidebar.children[0].src = "/public/img/icons-"+sidebar.id +".png";
}