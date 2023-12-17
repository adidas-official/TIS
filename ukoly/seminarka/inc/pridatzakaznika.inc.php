<?php 

require_once('../config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["pridat_zakaznika"])) {

    require_once("permissions.inc.php");

    if (!empty($_POST["jmeno"]) && !empty($_POST["email"]) ) {

        $reg = "/^[\w\.-]+@[a-zA-Z\d\.-]+\.[a-zA-Z]{2,}$/";
        $match = preg_match($reg, $_POST["email"]);

        if (!$match) {
            header("Location: ../index.php?error=11");
            die();
        }

        require_once("dbh.inc.php");
        include_once("functions.php");

        $jmeno = htmlspecialchars($_POST["jmeno"]);
        $email = htmlspecialchars($_POST["email"]);


        // konrola duplicitnich emailu
        $zakaznici = vypis_zakazniky($conn);

        foreach ($zakaznici as $zakaznik_faktura) {
            if ($email == $zakaznik_faktura["email"]) {
                header("Location: ../index.php?error=12");
                $conn = null;
                die();
            }
        }

        try {

            $query = "INSERT INTO zakaznik (jmeno, email) VALUES (:username, :email);";

            $stmt = $conn->prepare($query);
            $stmt->bindParam(":username", $jmeno);
            $stmt->bindParam(":email", $email);
            $stmt->execute();

            header("Location: ../index.php");

            $conn = null;
            $stmt = null;
            die();
            
        } catch (Exception $e) {
            $conn = null;
            die("Chyba pri vkladani do databaze: " . $e->getMessage());
        }

    }
}

header("../index.php");
