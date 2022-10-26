window.onload = function(){
    console.log("Hello World");
    let xhr = new XMLHttpRequest();

    xhr.onreadystatechange = function() { 
        if (xhr.readyState == 4 && xhr.status == 200) {
            let card_container = document.getElementsByClassName("contents")[0];
            // console.log(card_container.innerHTML);
            console.log(xhr.responseText);
            let result = JSON.parse(xhr.responseText);
        
            card_container.innerHTML = "<tr> Unfortunately, there is no song for you </tr>";
            if (result[0] !== "") {
                card_container.innerHTML = result[0];
            }
        }
    }
    url = "/app/controllers/HomeController.php";

    xhr.open("GET", url, true);
    xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
    xhr.send();
}

