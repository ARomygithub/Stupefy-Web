<?php
    session_start();
    require_once __DIR__ . '/../app/controllers/AuthController.php';

    if(isValidAuthCookie($_COOKIE)) {
        header('Location: /');
    }    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Stupefy</title>
    <link rel="stylesheet" href="css/login-reg.css" />
    <link rel="stylesheet" href="css/form.css" />
    <link href='https://fonts.googleapis.com/css?family=Inter' rel='stylesheet'>
    <link rel="icon" type="image/x-icon" href="/public/img/favicon.ico">
</head>
<body>
    <div id="container">
        <div id="content">
            <div id="logo">
                <img src="img/logo.png" alt="logo" id="logo-image" />
            </div>
            <div id="login">
                <form action="login.php" method="POST">
                    <div class="input">
                        <label for="username">Username</label>
                        <input type="text" name="username" id="username" placeholder="Username" />
                        <div class="error-message" id="username-error">Salah</div>
                    </div>
                    <div class="input">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" placeholder="Password"/>
                        <div class="error-message" id="password-error">Salah</div>
                    </div>
                </form>
                <div id="div-button">
                    <input type="submit" id="login-button" value="Log in"/>
                </div>
                <hr>
            </div>
            <label class="label1">Don't have an account?</label>
            <a id="signup" href="signup.php">
                Sign up
            </a>
        </div>
    </div>
</body>
<footer>
    <script src="./js/login.js"></script>
</footer>
</html>