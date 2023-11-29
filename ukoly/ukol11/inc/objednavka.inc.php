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
    $id_zbozi = $_POST["id_zbozi"];
    $pocet_ks = $_POST["ks"];

    echo "id:ks<br>";
    echo "<pre>" . print_r($pocet_ks, true) . "</pre>";

    $query = "SELECT id_zbozi, cena FROM zbozi WHERE ";
    $counter = 0;

    for ($i = 1; $i <= count($pocet_ks); $i++) {
        if (isset($id_zbozi[$i])) {
            $counter += 1;
            // echo "ID: " . $id_zbozi[$i] . "<br>";
            // echo "Pocet ks: " . $pocet_ks[$i] . "<br>";
            $query .= "id_zbozi = '$id_zbozi[$i]'";
            if ($counter != count($id_zbozi)) {
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


    // Debug 
    echo "z db<br>";
    echo "<pre>" . print_r($results, true) . "</pre>";


    echo "<ul>";
    for ($i = 0; $i < count($results); $i++) {
        $id = $results[$i]["id_zbozi"];
        $cena_za_ks = $results[$i]["cena"];
        $ks = $pocet_ks[$id];

        $celkem = intval($cena_za_ks) * intval($ks);
        echo "<li>" . $id. ": " . $ks . " * " . $cena_za_ks . " = " . $celkem . "</li>";
        $faktura_cena += $celkem;

    }
    echo "</ul>";

    // End debug

    $zakaznik = htmlentities($_POST["zakaznik"]);
    $now = time();

    $query = "INSERT INTO
                faktura (zakaznik_id, cena_fak, datum)
                VALUES (:zakaznik, :cena_fak, :datum)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam("zakaznik", $zakaznik);
    $stmt->bindParam("cena_fak", $faktura_cena);
    $stmt->bindParam("datum", $now);
    // $stmt->execute();

    // $faktura_id = $conn->lastInsertId();

    $query = "INSERT INTO faktura_zbozi";

    for ($i = 0; $i < count($results); $i++) {
        $id = $results[$i]["id_zbozi"];
        $cena_za_ks = $results[$i]["cena"];
        $ks = $pocet_ks[$id];

        $celkem = intval($cena_za_ks) * intval($ks);
        echo "<li>" . $id. ": " . $ks . " * " . $cena_za_ks . " = " . $celkem . "</li>";
        $faktura_cena += $celkem;

    }
    // $query = "INSERT INTO
    //             faktura_zbozi"

    // $stmt = null;
    // $conn = null;


} //
