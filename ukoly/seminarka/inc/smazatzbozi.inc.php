<?php 

if (empty($_GET["id"])) {
    header("Location: ../index.php?error=23");
    exit();
}

require_once("permissions.inc.php");

$id = htmlentities($_GET["id"]);

if (!is_numeric($id)) {
    header("../index.php?error=80");
    exit();
}

try {
    require_once("dbh.inc.php");
    $query = "DELETE FROM zbozi WHERE id_zbozi = :id_zbozi LIMIT 1";
    $stmt = $conn->prepare($query);
    $stmt->bindParam("id_zbozi", $id);
    $stmt->execute();

    $rowCount = $stmt->rowCount();
    
    if ($rowCount > 0) {
        header("Location: ../index.php?status=0");
        die();
    } else {
        header ("Location: ../index.php?error=22");
    }

} catch (Exception $e) {
    header("Location: ../index.php?error=24&e=$e");
    die("Error during delete operation: $e");
}