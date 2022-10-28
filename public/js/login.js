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
                document.getElementById("username-error").style.display = "None";


                document.getElementById("password-error").innerHTML = "Wrong username or password";
                document.getElementById("password-error").style.display = "block";
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
    if (!validateForm(data)) {
        xhr.open("POST", url, true);
        xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
        xhr.send(data);
    }
}));

function validateForm(formData){
    let error = false;
    let username = formData.get("username");
    let password = formData.get("password");
    if(username === ""){
        document.getElementById("username-error").innerHTML = "Username is required";
        document.getElementById("username-error").style.display = "block";
        error = true;
    } else{
        document.getElementById("username-error").style.display = "none";
    }
    if(password === ""){
        document.getElementById("password-error").innerHTML = "Password is required";
        document.getElementById("password-error").style.display = "block";
        error = true;
    } else{
        document.getElementById("password-error").style.display = "none";
    }
    return error;
}