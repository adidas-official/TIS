<?php 

require_once("../config.php");
require_once("functions.php");

if ($_SERVER["REQUEST_METHOD"] != "POST" || !isset($_POST["objednat"])) {
    header("Location: ../index.php");
    exit();
}

if (isset($_POST["id_zbozi"]) && isset($_POST["ks"]) && isset($_POST["zakaznik"])) {

    require_once("dbh.inc.php");

    // zkontrolovat, jestli souhlasi ks a id
    $id_fak = $_POST["id_zbozi"];
    $pocet_ks = $_POST["ks"];

    echo "id:ks<br>";
    echo "<pre>" . print_r($pocet_ks, true) . "</pre>";

    $query = "SELECT id_zbozi, cena FROM zbozi WHERE ";
    $counter = 0;

    for ($i = 1; $i <= count($pocet_ks); $i++) {
        if (isset($id_fak[$i])) {
            $counter += 1;
            // echo "ID: " . $id_zbozi[$i] . "<br>";
            // echo "Pocet ks: " . $pocet_ks[$i] . "<br>";
            $query .= "id_zbozi = '$id_fak[$i]'";
            if ($counter != count($id_fak)) {
                $query .= " OR ";
            }
        }
    }
    $query .= ";";

    // select vsechno zbozi se zadanymi id
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $results = $stmt->fetchall(PDO::FETCH_ASSOC);
    $faktura_cena = 0;

    // Vypocet celkove ceny na fakturu
    for ($i = 0; $i < count($results); $i++) {
        $id = $results[$i]["id_zbozi"];
        $cena_za_ks = $results[$i]["cena"];
        $ks = $pocet_ks[$id];

        $celkem = intval($cena_za_ks) * intval($ks);
        $faktura_cena += $celkem;

    }

    $zakaznik_faktura = htmlentities($_POST["zakaznik"]);
    $now = time();

    // Nova faktura
    try {

        $query = "INSERT INTO
                    faktura (zakaznik_id, cena_fak, datum)
                    VALUES (:zakaznik, :cena_fak, :datum)";
        $stmt = $conn->prepare($query);
        $stmt->bindParam("zakaznik", $zakaznik_faktura);
        $stmt->bindParam("cena_fak", $faktura_cena);
        $stmt->bindParam("datum", $now);
        $stmt->execute();

        $faktura_id = $conn->lastInsertId();

    } catch (Exception $e) {
        $conn = null;
        die("Chyba pri vkladani do databaze: " . $e->getMessage());
    }

    // Nova faktura_zbozi pro kazdy predmet na fakture
    for ($i = 0; $i < count($results); $i++) {
        try {
            $id = $results[$i]["id_zbozi"];
            $ks = $pocet_ks[$id];

            $query = "INSERT INTO faktura_zbozi (faktura_id, zbozi_id, pocet)
                        VALUES (:last_fak, :zbozi, :pocet)";

            $stmt = $conn->prepare($query);
            $stmt->bindParam("last_fak", $faktura_id);
            $stmt->bindParam("zbozi", $id);
            $stmt->bindParam("pocet", $ks);
            $stmt->execute();
        } catch (Exception $e) {
            $conn = null;
            die("Chyba pri vkladani do databaze: " . $e->getMessage());
        }


    }

    $stmt = null;
    $conn = null;

    header("Location: ../zakaznik.php?id=$zakaznik_faktura");
    die();


} //
