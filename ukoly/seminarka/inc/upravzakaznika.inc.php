<?php 

if ($_SERVER["REQUEST_METHOD"] != "POST" || empty($_POST["id_zak"])) {
    header("Location: ../upravitzakaznika.php?id=$id&error=82");
    exit();
}

require_once("permissions.inc.php");

$id = $_POST["id_zak"];
if (!is_numeric($id)) {
    header("Location: ../upravitzakaznika.php?id=$id&error=80");
    exit();
}

if (empty($_POST["jmeno"]) || empty($_POST["email"])) {
    header("Location: ../upravitzakaznika.php?id=$id&error=83");
    exit();
}

require_once("dbh.inc.php");

$jmeno = htmlentities($_POST["jmeno"]);
$email = htmlentities($_POST["email"]);

$reg = "/^[\w\.-]+@[a-zA-Z\d\.-]+\.[a-zA-Z]{2,}$/";
$match = preg_match($reg, $_POST["email"]);

if (!$match) {
    header("Location: ../upravzakaznika.php?id=$id&error=11");
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
        header("Location: ../upravzakaznika.php?id=$id&error=12");
        $conn = null;
        die();
    }
}

try {
    $query = "UPDATE zakaznik SET jmeno =:jmeno, email =:email WHERE id_zak = $id LIMIT 1";
    $stmt = $conn->prepare($query);
    $stmt->bindParam("jmeno", $jmeno);
    $stmt->bindParam("email", $email);
    $stmt->execute();

    $conn = null;
    $stmt = null;

    header("Location: ../upravzakaznika.php?id=$id&status=0");
    die();

} catch (Exception $e) {
    die("Behem upravy dat se stala chyba");
}