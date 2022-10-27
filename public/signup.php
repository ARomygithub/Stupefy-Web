<?php
    session_start();
    require_once __DIR__ . '/../app/controllers/AuthController.php';

    if(isValidAuthCookie($_COOKIE)) {
        header('Location: /');
    }

    function echo_field($name, $type, $placeholder, $value = ""){
        $html = <<<"EOT"
            <div class="field">
                <label for="$name">$name</label>
                <input type="$type" id="field-$name" name="$name" placeholder="$placeholder" value="$value" />
            </div>
        EOT;

        echo $html;
    }
?>

<!DOCTYPE html>
<hmtl lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Stupefy</title>
    <link rel="stylesheet" href="css/login-reg.css" />
    <link href='https://fonts.googleapis.com/css?family=Inter' rel='stylesheet'>
</head>
<body>
    <div id="container">
        <div id="content">
            <div id="logo">
                <img src="img/logo.png" alt="logo" />
            </div>
            <div id="signup-form">
                <form>
                    <?php echo_field("Name", "text", "Your name"); ?>
                    <?php echo_field("Username", "text", "Username"); ?>
                    <?php echo_field("Email", "email", "Email"); ?>
                    <?php echo_field("Password", "password", "Password"); ?>
                    <?php echo_field("Confirm Password", "password", "Confirm Password"); ?>
                    <p class="to-term">By clicking on sign-up, you agree to <a href="tes.php">Stupefy's Terms and Conditions of Use</a></p>
                </form>
                    <button id="signup-button">SIGN UP</button>
            </div>
            <label class="to-login">Have an account? <a href="login.php">Log in</a></label>
        </div>
    </div>
</body>
<footer>
    <script src="./js/signup.js"></script>
</footer>
</hmtl>