<?php 

require_once('../config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["pridat_zbozi"])) {

    require_once("permissions.inc.php");

    if (!empty($_POST["nazev"]) && !empty($_POST["cena"]) ) {

        require_once("dbh.inc.php");
        include_once("functions.php");

        $jmeno = htmlspecialchars($_POST["nazev"]);
        $cena_za_ks = htmlspecialchars($_POST["cena"]);


        // konrola duplicitnich emailu
        $objednavka = vypis_zbozi($conn);

        foreach ($objednavka as $produkt) {
            if ($jmeno == $produkt["nazev"]) {
                header("Location: ../index.php?error=20");
                $conn = null;
                die();
            }
        }

        try {

            $query = "INSERT INTO zbozi (nazev, cena) VALUES (:nazev, :cena);";

            $stmt = $conn->prepare($query);
            $stmt->bindParam(":nazev", $jmeno);
            $stmt->bindParam(":cena", $cena_za_ks);
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
