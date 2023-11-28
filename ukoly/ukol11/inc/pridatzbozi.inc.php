<?php 

require_once('../config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["pridat_zbozi"])) {

    if (!empty($_POST["nazev"]) && !empty($_POST["cena"]) ) {

        require_once("dbh.inc.php");
        include_once("functions.php");

        $nazev = htmlspecialchars($_POST["nazev"]);
        $cena = htmlspecialchars($_POST["cena"]);


        // konrola duplicitnich emailu
        $zbozi = vypis_zbozi($conn);

        foreach ($zbozi as $produkt) {
            if ($nazev == $produkt["nazev"]) {
                header("Location: ../index.php?error=20");
                $conn = null;
                die();
            }
        }

        try {

            $query = "INSERT INTO zbozi (nazev, cena) VALUES (:nazev, :cena);";

            $stmt = $conn->prepare($query);
            $stmt->bindParam(":nazev", $nazev);
            $stmt->bindParam(":cena", $cena);
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
