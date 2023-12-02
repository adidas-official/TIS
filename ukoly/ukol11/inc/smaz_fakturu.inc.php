<?php 

require_once("../config.php");
require_once("functions.php");

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
    try {
        $id = htmlentities($_GET["id"]);

        if (!is_numeric($id)) {
            die("ID musi byt cislo");
        }

        require_once("dbh.inc.php");

        $query = "DELETE FROM faktura WHERE id_fak = ? LIMIT 1";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt) {
            $_SESSION["status"] = "Smazano";
            header("Location: ../zakaznik.php?id=");
        } else {
            echo "error";
            $_SESSION["error"] = 41;
        }


        $stmt = null;
        $conn = null;
        die();


    } catch (Exception $e) {
        $conn = null;
        die("Chyba pri mazani z databaze: " . $e->getMessage());
    }
}
