<?php 

define("SERVERNAME", "localhost");
define("USERNAME", "frydryn");
define("PASSWORD", "Tis2023*671279");

try {
    $conn = new PDO("mysql:host=" . SERVERNAME . ";dbname=cezar", USERNAME, PASSWORD);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Spojeni uspesne";
} catch(PDOException $e) {
    echo "Spojeni selhalo: " . $e->getMessage();
}