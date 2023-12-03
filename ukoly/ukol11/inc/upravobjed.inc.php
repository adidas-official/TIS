
<?php 

require_once("../config.php");
require_once("functions.php");

if ($_SERVER["REQUEST_METHOD"] != "POST" || !isset($_POST["uprav"])) {
    header("Location: ../index.php");
    exit();
}

if (isset($_POST["id_zbozi"]) && isset($_POST["ks"]) && isset($_POST["id_fak"])) {
    require_once("dbh.inc.php");

    // zkontrolovat, jestli souhlasi ks a id
    $faktura_id = htmlentities($_POST["id_fak"]);
    $pocet_ks = $_POST["ks"];
    $id_zbozi = $_POST["id_zbozi"];

    $query = "SELECT zakaznik_id FROM faktura WHERE id_fak=:id_fak LIMIT 1";
    $stmt = $conn->prepare($query);
    $stmt->bindParam("id_fak", $faktura_id);
    $stmt->execute();
    $zakaznik_id = $stmt->fetchColumn();
    echo $zakaznik_id;

    echo "id:ks<br>";
    echo "<pre>" . print_r($pocet_ks, true) . "</pre>";

    $query = "SELECT id_zbozi, cena FROM zbozi WHERE ";
    $counter = 0;

    for ($i = 1; $i <= count($pocet_ks); $i++) {
        if (isset($id_zbozi[$i])) {
            $counter += 1;
            echo "ID: " . $id_zbozi[$i] . "<br>";
            echo "Pocet ks: " . $pocet_ks[$i] . "<br>";
            $query .= "id_zbozi = '$id_zbozi[$i]'";
            if ($counter != count($id_zbozi)) {
                $query .= " OR ";
            }
        }
    }
    $query .= ";";
    echo $query;

    // select vsechno zbozi se zadanymi id
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $results = $stmt->fetchall(PDO::FETCH_ASSOC);
    $faktura_cena = 0;

    echo "<pre>" . print_r($results, true) . "</pre>";

    // Vypocet celkove ceny na fakturu
    for ($i = 0; $i < count($results); $i++) {
        $id = $results[$i]["id_zbozi"];
        $cena_za_ks = $results[$i]["cena"];
        $ks = $pocet_ks[$id];

        $celkem = intval($cena_za_ks) * intval($ks);
        $faktura_cena += $celkem;

    }

    // Nova faktura
    try {

        $query = "UPDATE faktura SET cena_fak=:cena_fak WHERE id_fak=:id_fak";
        $stmt = $conn->prepare($query);
        $stmt->bindParam("id_fak", $faktura_id);
        $stmt->bindParam("cena_fak", $faktura_cena);
        $stmt->execute();


    } catch (Exception $e) {
        $conn = null;
        die("Chyba 1 pri vkladani do databaze: " . $e->getMessage());
    }

    // Upravena faktura_zbozi pro kazdy predmet na fakture

    $query = "DELETE FROM faktura_zbozi WHERE faktura_id=:id_fak;";
    $stmt = $conn->prepare($query);
    $stmt->bindParam("id_fak", $faktura_id);
    $stmt->execute();

    for ($i = 0; $i < count($results); $i++) {
        try {
            $id = $results[$i]["id_zbozi"];
            $ks = $pocet_ks[$id];

            $query = "INSERT INTO faktura_zbozi (faktura_id, zbozi_id, pocet)
                        VALUES (:id_fak, :zbozi, :pocet)";

            $stmt = $conn->prepare($query);
            $stmt->bindParam("id_fak", $faktura_id);
            $stmt->bindParam("zbozi", $id);
            $stmt->bindParam("pocet", $ks);
            $stmt->execute();
        } catch (Exception $e) {
            $conn = null;
            die("Chyba 2 pri vkladani do databaze: " . $e->getMessage());
        }


    } 

    $stmt = null;
    $conn = null;

    header("Location: ../zakaznik.php?id=$zakaznik_id");
    die();


} //
