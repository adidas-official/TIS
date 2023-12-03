<?php 

require_once('config.php');
require_once("inc/functions.php");

if (isset($_GET["search"])) {
    $kde = htmlentities(key($_GET["search"]));
    $co = htmlentities(current($_GET["search"]));
    $co = "%" . $co . "%";

    require_once("inc/dbh.inc.php");

    switch ($kde) {
        case "zakaznik":
            $query = "SELECT id_zak, jmeno, email, id_fak, cena_fak
            FROM zakaznik JOIN faktura ON id_zak = zakaznik_id WHERE jmeno LIKE :zakaznik";
            $stmt = $conn->prepare($query);
            $stmt->bindParam("zakaznik", $co);
    
            break;
        case "email":
            $query = "SELECT id_zak, jmeno, email, id_fak, cena_fak
            FROM zakaznik JOIN faktura ON id_zak = zakaznik_id WHERE email LIKE :email";
            $stmt = $conn->prepare($query);
            $stmt->bindParam("email", $co);        
    
            break;
        case "zbozi":
            $query = "SELECT *
            FROM zbozi WHERE nazev LIKE :zbozi";
            $stmt = $conn->prepare($query);
            $stmt->bindParam("zbozi", $co);
            break;
        case "faktura":
            $query = "SELECT *
            FROM faktura WHERE id_fak LIKE :faktura";
            $stmt = $conn->prepare($query);
            $stmt->bindParam("faktura", $co);
            break;
        default:
            break;
    }

    echo $query;
    try {
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($results) {
            echo "<pre>" . print_r($results, true) . "</pre>";
        } else {
            echo "No match found.";
        }
    } catch (Exception $e) {
        die("Chyba pri vyhledavani: " . $e->getMessage());
    }

};

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cezar G3000 | Vyhledavani</title>
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            let containers = document.querySelectorAll(".input-container");

            containers.forEach(function(container, index) {
                container.addEventListener("click", function() {
                    containers.forEach(function(otherContainer) {
                        otherContainer.querySelector("input").disabled = true;
                        otherContainer.querySelector("input").value = "";
                    });
                    this.querySelector("input").disabled = false;
                    this.querySelector("input").focus();
                });
            });
        });
    </script>

    <style>

        input {
            margin: 0;
            height: 22px;
        }

        .input-container::before {
            content: "";
            background: #000;
            display: inline-block;
            width: 16px;
            height: 16px;
            margin-right: 12px;
            vertical-align: middle;
        }

    </style>
</head>
<body>
    
<h3>Vyhledavac</h3>

<form action="" method="GET">
    <div class="input-container">
        <input type="text" name="search[zakaznik]" placeholder="Zakaznik"><br>
    </div>
    <div class="input-container">
        <input type="text" name="search[email]" disabled placeholder="Email"><br>
    </div>
    <div class="input-container">
        <input type="text" name="search[zbozi]" disabled placeholder="Zbozi"><br>
    </div>
    <div class="input-container">
        <input type="text" name="search[faktura]" disabled placeholder="Faktura"><br>
    </div>
    <button type="submit" value="hledat">Hledat</button>
</form>

<div id="results">

</div>

</body>
</html>