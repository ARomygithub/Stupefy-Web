function logout(){
    let xhr = new XMLHttpRequest();
    formData = new FormData();
    formData.append("logout", true);
    xhr.onreadystatechange = function() { 
        if (xhr.readyState == 4 && xhr.status == 200) {
            document.location.href = ".";
        }
    }
    url = "/app/controllers/AuthController.php";

    xhr.open("POST", url, true);
    xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
    xhr.send(formData);
}

let searchInput = document.getElementById("search-input");
searchInput.addEventListener("keydown", function(event){
    if(event.key === "Enter"){
        event.preventDefault();
        location.href = "/public/search.php?search=" + this.value;
    }
});
