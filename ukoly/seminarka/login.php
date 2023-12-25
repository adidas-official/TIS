<?php 

require_once("config.php");

if (isset($_SESSION["userid"])) {
    header("Location: index.php");
    exit();
}

include_once("public/templates/header.html");
?>
<body>
    
<main class="middle center">
    <section class="vyber" id="register">
        <div class="flex-container flex-col">
            <div class="inputs">
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
            </div>

            <div class="interaction">
                <p>Mate zalozen ucet?</p>
                <a href="#" class="reg-log">Prihlasit</a>
            </div>
        </div>
    </section>

    <section class="vyber" id="login">
        <div class="flex-container flex-col">
            <div class="inputs">
                <h2>Prihlaseni</h2>
                <form action="inc/login.inc.php" method="post">
                    <input type="username" name="login_username" id="login_username" placeholder="Prihlasovaci jmeno">
                    <br>
                    <input type="password" name="login_password" id="login_password" placeholder="Heslo">
                    <br>
                    <button type="submit" name="login">Prihlasit</button>
                </form>
            </div>
            <div class="interactions">
                <p>Nemate ucet?</p>
                <a href="#" class="reg-log">Registrovat</a>
            </div>
        </div>
    </section>
</main>

    <?php if (isset($_GET["error"])) { ?>
            <span class="error center">
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