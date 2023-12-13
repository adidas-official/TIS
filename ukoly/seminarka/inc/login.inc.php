<?php

require_once("../config.php");

// uzivatel je prihlasen nebo sem prisel pomoci get nebo neodeslal formular
if (isset($_SESSION["userid"]) || $_SERVER["REQUEST_METHOD"] != "POST" || !isset($_POST["login"])) {
    header("Location: ../index.php");
    exit();
}

// uzivatelke jmeno nebylo vyplneno
if (!isset($_POST["login_username"]) || empty($_POST["login_username"])) {
    header("Location: ../login.php?error=40");
    exit();
}

// heslo jmeno nebylo vyplneno
if (!isset($_POST["login_password"]) || empty($_POST["login_password"])) {
    header("Location: ../login.php?error=41");
    exit();
}

try {

    $password = htmlentities($_POST["login_password"]);
    $username = htmlentities($_POST["login_username"]);

    require_once("dbh.inc.php");
    require_once("functions.php");

    $user = uzivatel_prihlasen($username, $password, $conn);
    if ($user) {
        $_SESSION["userid"] = $user["id"];
        header("Location: ../index.php?status=0");
    } else {
        header("Location: ../login.php?error=50");
    }


} catch (Exception $e) {
    echo "Nastala chyba: ". $e->getMessage();
}
