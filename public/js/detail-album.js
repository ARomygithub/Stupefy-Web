window.onload = function(){
    toogleSideBar();

    let xhr = new XMLHttpRequest();

    xhr.onreadystatechange = function() { 
        if (xhr.readyState == 4 && xhr.status == 200) {
            let contents = document.getElementsByClassName("contents")[0];
            console.log(xhr.responseText);
            let result = JSON.parse(xhr.responseText);
            contents.innerHTML = "<div class> Unfortunately, there is no song for you </tr>";
            if (result[0] !== "") {
                contents.innerHTML = result[0];
            }
        }
    }
    url = "/app/controllers/HomeController.php";

    xhr.open("GET", url, true);
    xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
    xhr.send();
}