<?php 

require_once("config.php");

if (isset($_SESSION["userid"])) {
    header("Location: index.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cezar G3000 | Login</title>
</head>
<body>
    <section class="register">
    <h2>Registrace</h2>
    <form action="inc/register.inc.php" method="post">
        <input type="text" name="username" id="username" placeholder="Prihlasovaci jmeno">
        <br>
        <input type="password" name="reg_password" id="reg_password" placeholder="Heslo">
        <br>
        <input type="password" name="repeat_password" id="repeat_password" placeholder="Heslo znovu">
        <br>
        <button type="submit" name="register">Registrovat</button>
    </form>

    <section class="login">
        <h2>Prihlaseni</h2>
        <form action="inc/login.inc.php" method="post">
            <input type="username" name="login_username" id="login_username" placeholder="Prihlasovaci jmeno">
            <br>
            <input type="password" name="login_password" id="login_password" placeholder="Heslo">
            <br>
            <button type="submit" name="login">Prihlasit</button>
        </form>
    </section>

    <?php if (isset($_GET["error"])) { ?>
            <span class="error">
                <?php
                    include_once("errors.php");
                    echo $errors[$_GET["error"]] . "<br>";
                    echo $_GET["e"];
                ?>
            </span>
        <?php
    }
    ?>
</body>
</html>