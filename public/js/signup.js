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

checkUsername = function() {
    const username = this.value;
    const regex = /^[a-zA-Z0-9_]+$/;
    // apus error yang udh muncul
    if (isUsernameValid === false) {
        this.parentElement.removeChild(this.parentElement.lastChild);
    }
    isValid = regex.test(username);

    if (!isValid) {
        isUsernameValid = false;
        this.style.border = "1px solid #FF0000";
        if (this !== this.parentElement.last)
            var err = document.createElement("p");
        err.innerHTML = "Username can only be letters, numbers, and underscores";
        err.style.placeSelf = "start";
        err.style.margin = 0;
        err.style.color = "#FF0000";
        this.parentElement.appendChild(err);
    } else {
        // cek username unik dengan ajax
        isUsernameValid = true;
        usernameInput.style.border = "1px solid #00FF00";
    }
};
usernameInput = document.getElementById("field-Username");
usernameInput.addEventListener("keyup", debounce(checkUsername, 3000));


function checkEmail() {
    email = this.value;
    if (isEmailValid === false) {
        this.parentElement.removeChild(this.parentElement.lastChild);
    }
    const regex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
    if (!regex.test(email)) {
        isEmailValid = false;
        this.style.border = "1px solid #FF0000";
        var err = document.createElement("p");
        err.innerHTML = "Email is not valid";
        err.style.placeSelf = "start";
        err.style.margin = 0;
        err.style.color = "#FF0000";
        this.parentElement.appendChild(err);
    } else {
        // cek email unik dengan ajax
        isEmailValid = true;
        this.style.border = "1px solid #00FF00";
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
