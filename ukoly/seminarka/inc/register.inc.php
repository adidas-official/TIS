<?php

// uzivatel je prihlasen nebo sem prisel pomoci get nebo neodeslal formular
if (isset($_SESSION["userid"]) || $_SERVER["REQUEST_METHOD"] != "POST" || !isset($_POST["register"])) {
    header("Location: ../index.php");
    exit();
}

// uzivatelke jmeno nebylo vyplneno
if (!isset($_POST["username"]) || empty($_POST["username"])) {
    header("Location: ../login.php?error=40");
    exit();
}

// heslo jmeno nebylo vyplneno
if (!isset($_POST["reg_password"]) || empty($_POST["reg_password"])) {
    header("Location: ../login.php?error=41");
    exit();
}

// heslo pro kontrolu nebylo vyplneno
if (!isset($_POST["repeat_password"]) || empty($_POST["repeat_password"])) {
    header("Location: ../login.php?error=42");
    exit();
}

$password = htmlentities($_POST["reg_password"]);
$repassword = htmlentities($_POST["repeat_password"]);

// hesla se neshoduji
$hashed_pwd = password_hash($password, PASSWORD_DEFAULT);
if (!password_verify($repassword, $hashed_pwd)) {
    header("Location: ../login.php?error=43");
    exit();
}

$passw_pattern = '/(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[~`!@#$%^&*()_+\-={\[\]}|\\\\:;\"\'<,>.?\/])[a-zA-Z\d~`!@#$%^&*()_+\-={\[\]}|\\\\:;\"\'<,>.?\/]+$/';
$result = preg_match($passw_pattern, $password);

if (!$result) {
    header("Location: ../login.php?error=44");
    exit();
}


try {

    require_once("dbh.inc.php");
    require_once("functions.php");

    $username = htmlentities($_POST["username"]);
    $user = uzivatel_podle_jmena($username, $conn);

    // Uzivatel uz existuje
    if ($user) {
        header("Location: ../login.php?error=45");
        $conn = null;
        exit();
    }

    $query = "INSERT INTO users (role, username, password) VALUES (0, :username, :password);";
    $stmt = $conn->prepare($query);
    $stmt->bindParam("username", $username, PDO::PARAM_STR);
    $stmt->bindParam("password", $hashed_pwd, PDO::PARAM_STR);
    $stmt->execute();

    if ($stmt->rowCount()) {
        $_SESSION["userid"] = $conn->lastInsertId();
        header("Location: ../index.php?status=0");
    } else {
        header("Location: ../index.php?status=1");
    }

    $conn = null;
    $stmt = null;

    exit();
    

} catch (Exception $e) {
    echo "Nastala chyba: ". $e->getMessage();
}



