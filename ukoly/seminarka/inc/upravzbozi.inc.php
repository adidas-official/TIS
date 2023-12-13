<?php 

if ($_SERVER["REQUEST_METHOD"] != "POST" || empty($_POST["id_zbozi"])) {
    header("Location: ../index.php?error=24");
    exit();
}

$id = $_POST["id_zbozi"];
if (!is_numeric($id)) {
    header("Location: ../index.php?error=80");
    exit();
}

if (empty($_POST["nazev"]) || empty($_POST["cena"])) {
    header("Location: ../upravitzbozi.php?id=$id&error=23");
    exit();
}

require_once("dbh.inc.php");

$jmeno = htmlentities($_POST["nazev"]);
$email = htmlentities($_POST["cena"]);

try {
    $query = "UPDATE zbozi SET nazev =:nazev, cena =:cena WHERE id_zbozi = $id LIMIT 1";
    $stmt = $conn->prepare($query);
    $stmt->bindParam("nazev", $jmeno);
    $stmt->bindParam("cena", $email);
    $stmt->execute();

    $conn = null;
    $stmt = null;

    header("Location: ../upravitzbozi.php?id=$id&status=0");
    die();

} catch (Exception $e) {
    die("Behem upravy dat se stala chyba");
}