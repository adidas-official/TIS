<?php session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $status = [
        "jmeno" => "",
        "delka" => "",
        "reg" => "",
        "cislo" => "",
        ];
    $errors = [];

    if (isset($_POST["jmeno"])) {
        $name = $_POST["jmeno"];
        if (!empty($name)) {
            $status["jmeno"] = $name;
        } else {
            array_push($errors, "jmeno neni zadano");
        }
    }

    if (isset($_POST["delka"])) {
        $delka = $_POST["delka"];
        if (strlen($delka) < 8) {
            array_push($errors, "delka musi byt alespon 8");
        } else {
            $status["delka"] = $delka;
        }
    }

    if (isset($_POST["reg"])) {
        $reg = $_POST["reg"];
        $vzorec = "/[\w\d!@#$%^&*()_-+={\[\]\\;'\",./<>?`~]*";
        if (!preg_match($vzorec, $reg)) {
            array_push($errors, "vzor nesouhlasi");
        } else {
            $status["reg"] = $reg;
        }
    }

    if (isset($_POST["cislo"])) {
        $cislo = $_POST["cislo"];
        if (intval($cislo) > 0 && intval($cislo) <= 10) {
            $status["cislo"] = $cislo;
        } else {
            array_push($errors, "cislo musi byt mezi 1 a 10");
        }
    }

    $_SESSION["status"] = $status;
    $_SESSION["error"] = $errors;
    header("Location: index.php");

} else {
    header("Location: index.php");
}

