const debounce = (func, delay) => {
    let debounceTimer;
    return function() {
        const context = this;
        const args = arguments;
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => func.apply(context, args), delay);
    }
};

let loginButton = document.getElementById("login-button");
loginButton.addEventListener("click", debounce(function() {
    console.log("login button clicked");
    let xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            console.log(xhr.responseText);
            if (xhr.responseText === "login success") {
                document.location.href = ".";
            } else {
                alert("Wrong username or password");
            }
        }
    }
    let username = document.getElementById("username").value;
    let password = document.getElementById("password").value;
    url = "/app/controllers/AuthController.php";
    data = new FormData();
    data.set("login", "true");
    data.set("username", username);
    data.set("password", password);
    xhr.open("POST", url, true);
    xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
    xhr.send(data);
}));