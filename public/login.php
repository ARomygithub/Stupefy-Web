
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Stupefy</title>
    <link rel="stylesheet" href="css/login-reg.css" />
</head>
<body>
    <div id="container">
        <div id="content">
            <div id="logo">
                <img src="img/logo.png" alt="logo" />
            </div>
            <div id="login">
                <form action="login.php" method="POST">
                    <div class="input">
                        <label for="username">Username</label>
                        <input type="text" name="username" id="username" placeholder="Username" />
                    </div>
                    <div class="input">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" placeholder="Password"/>
                    </div>
                    <div id="div-button">
                        <button id="login-button">
                            <p>LOG IN</p>
                        </button>
                    </div>
                    <hr>
                </form>
            </div>
            <label class="label1">Don't have an account?</label>
            <div id="register" href="register.php">
                <label>SIGN UP</label>
            </div>
        </div>
    </div>
</body>
