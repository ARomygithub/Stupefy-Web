const debounce = (func, delay) => {
    let debounceTimer;
    return function() {
        const context = this;
        const args = arguments;
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => func.apply(context, args), delay);
    }
};

let isUsernameValid;
let isEmailValid;
let iscPassValid;

console.log("hello from signup.js");

checkUsername = function() {
    unameInput = document.getElementById("field-Username");
    const username = unameInput.value;
    const regex = /^[a-zA-Z0-9_]+$/;
    // apus error yang udh muncul
    if (isUsernameValid === false) {
        unameInput.parentElement.removeChild(unameInput.parentElement.lastChild);
    }
    isValid = regex.test(username);

    if (!isValid) {
        isUsernameValid = false;
        unameInput.style.border = "1px solid #FF0000";
        if (unameInput !== unameInput.parentElement.last)
            var err = document.createElement("p");
        err.innerHTML = "Username can only be letters, numbers, and underscores";
        err.style.placeSelf = "start";
        err.style.margin = 0;
        err.style.color = "#FF0000";
        unameInput.parentElement.appendChild(err);
    } else {
        // cek username unik dengan ajax
        let xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if(xhr.readyState==4 && xhr.status==200) {
                console.log(xhr.responseText);
                if (xhr.responseText === "username unique") {
                    isUsernameValid = true;
                    unameInput.style.border = "1px solid #00FF00";
                } else {
                    isUsernameValid = false;
                    unameInput.style.border = "1px solid #FF0000";
                    var err = document.createElement("p");
                    err.innerHTML = "Username is already taken";
                    err.style.placeSelf = "start";
                    err.style.margin = 0;
                    err.style.color = "#FF0000";
                    unameInput.parentElement.appendChild(err);
                }
            }
        };
        url = "/app/controllers/SignupController.php?username=" + username;
        xhr.open("GET", url, true);
        xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
        xhr.send();
        isUsernameValid = true;
        usernameInput.style.border = "1px solid #00FF00";
    }
};
usernameInput = document.getElementById("field-Username");
usernameInput.addEventListener("keyup", debounce(checkUsername, 3000));


function checkEmail() {
    emailInput = document.getElementById("field-Email");
    email = emailInput.value;
    if (isEmailValid === false) {
        emailInput.parentElement.removeChild(emailInput.parentElement.lastChild);
    }
    const regex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
    if (!regex.test(email)) {
        isEmailValid = false;
        emailInput.style.border = "1px solid #FF0000";
        var err = document.createElement("p");
        err.innerHTML = "Email is not valid";
        err.style.placeSelf = "start";
        err.style.margin = 0;
        err.style.color = "#FF0000";
        emailInput.parentElement.appendChild(err);
    } else {
        // cek email unik dengan ajax
        let xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if(xhr.readyState==4 && xhr.status==200) {
                console.log(xhr.responseText);
                if (xhr.responseText === "email unique") {
                    isEmailValid = true;
                    emailInput.style.border = "1px solid #00FF00";
                } else {
                    isEmailValid = false;
                    emailInput.style.border = "1px solid #FF0000";
                    var err = document.createElement("p");
                    err.innerHTML = "Email is already taken";
                    err.style.placeSelf = "start";
                    err.style.margin = 0;
                    err.style.color = "#FF0000";
                    emailInput.parentElement.appendChild(err);
                }
            }
        };
        url = "/app/controllers/SignupController.php?email=" + email;
        xhr.open("GET", url, true);
        xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
        xhr.send();
    }
}
emailInput = document.getElementById("field-Email");
emailInput.addEventListener("keyup", debounce(checkEmail, 3000));

// cek password dan confirm password
function checkPassword() {
    cPass = this.value;
    pass = document.getElementById("field-Password").value;
    if (iscPassValid === false) {
        this.parentElement.removeChild(this.parentElement.lastChild);
    }
    if (cPass !== pass) {
        iscPassValid = false;
        this.style.border = "1px solid #FF0000";
        var err = document.createElement("p");
        err.innerHTML = "Password doesn't match";
        err.style.placeSelf = "start";
        err.style.margin = 0;
        err.style.color = "#FF0000";
        this.parentElement.appendChild(err);
    } else {
        iscPassValid = true;
        this.style.border = "1px solid #00FF00";
    }
}

cPassInput = document.getElementById("field-Confirm Password");
cPassInput.addEventListener("keyup", debounce(checkPassword, 3000));

signupButton = document.getElementById("signup-button");
signupButton.addEventListener("click", debounce(function() {
    console.log("clicknya masuk");
    if (isUsernameValid && isEmailValid && iscPassValid) {
        let err = false;
        signupFields = document.getElementsByTagName("input");
        // console.log(signupFields);
        for(let i=0;i<signupFields.length;i++) {
            field = signupFields[i];
            console.log(field);
            if(field.value ==="") {
                err = true;
                field.style.border = "1px solid #FF0000";
            }
        }
        console.log("otw kirim http");
        if(!err) {
            let xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    console.log(xhr.responseText);
                    if(xhr.responseText === "signup success") {
                        document.location.href = ".";
                    }
                        // } else {
                        // alert("Signup failed");
                    // }
                }
            };
            url = "/app/controllers/SignupController.php";
            data = new FormData();
            data.set("signup", "true");
            data.set("username", usernameInput.value);
            data.set("email", emailInput.value);
            data.set("password", cPassInput.value);
            data.set("name", document.getElementById("field-Name").value);
            xhr.open("POST", url, true);
            xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
            xhr.send(data);
        }
    }
},3000));
