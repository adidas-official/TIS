<?php 

require_once('config.php');
require_once("inc/functions.php");

function find($co, $kde) {

    $co = strtolower($co);
    require_once("inc/dbh.inc.php");

    switch ($kde) {
        case "zakaznik":
            $query = "SELECT id_zak, jmeno, email, id_fak, cena_fak
            FROM zakaznik JOIN faktura ON id_zak = zakaznik_id WHERE LOWER(jmeno) LIKE :zakaznik";
            $stmt = $conn->prepare($query);
            $stmt->bindParam("zakaznik", $co);
    
            break;
        case "email":
            $query = "SELECT id_zak, jmeno, email, id_fak, cena_fak
            FROM zakaznik JOIN faktura ON id_zak = zakaznik_id WHERE LOWER(email) LIKE :email";
            $stmt = $conn->prepare($query);
            $stmt->bindParam("email", $co);        
    
            break;
        case "zbozi":
            $query = "SELECT *
            FROM zbozi WHERE LOWER(nazev) LIKE :zbozi";
            $stmt = $conn->prepare($query);
            $stmt->bindParam("zbozi", $co);
            break;
        case "faktura":
            $query = "SELECT id_fak, zakaznik_id, jmeno, email, cena_fak
            FROM faktura JOIN zakaznik ON zakaznik_id = id_zak WHERE id_fak LIKE :faktura";
            $stmt = $conn->prepare($query);
            $stmt->bindParam("faktura", $co);
            break;
        default:
            break;
    }

    try {
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($results) {
            // echo "<pre>" . print_r($results, true) . "</pre>";
            return $results;
        }

        return false;

    } catch (Exception $e) {
        die("Chyba pri vyhledavani: " . $e->getMessage());
    }

}

function print_zak($results) {

    foreach($results as $radek) {
        echo "<tr>";
            echo "<td>" . $radek["id_zak"] . "</td>";
            ?>
            <td>
                <a href="<?php echo "zakaznik.php?id=" . $radek["id_zak"];?>">
                    <?php echo $radek["jmeno"]; ?>
                </a>
            </td>
            <td>
                <a href="<?php echo "mailto:" . $radek["email"]; ?>">
                    <?php echo $radek["email"]; ?>
                </a>
            </td>
            <td>
                <a href="<?php echo "faktura.php?id=". $radek["id_fak"]; ?>">
                    <?php echo $radek["id_fak"]; ?>
                </a>
            </td>
            <?php
            echo "<td>" . $radek["cena_fak"] . "</td>";
        echo "</tr>";
    }
}

function print_zbozi($results) {

    foreach($results as $radek) {
        echo "<tr>";
            echo "<td>" . $radek["id_zbozi"] . "</td>";
            echo "<td>" . $radek["nazev"] . "</td>";
            echo "<td>" . $radek["cena"] . "</td>";
        echo "</tr>";
    }
}

function print_fak($results) {

            // $query = "SELECT id_fak, zakaznik_id, jmeno, email, cena_fak
    foreach($results as $radek) {
        echo "<tr>";
            ?>
            <td>
                <a href="<?php echo "faktura.php?id=" . $radek["id_fak"];?>">
                    <?php echo $radek["id_fak"]; ?>
                </a>
            </td>
            <td>
                <?php echo $radek["zakaznik_id"]; ?>
            </td>
            <td>
                <a href="<?php echo "zakaznik.php?id=" . $radek["zakaznik_id"]; ?>">
                    <?php echo $radek["jmeno"]; ?>
                </a>
            </td>
            <td>
                <a href="<?php echo "mailto:" . $radek["email"]; ?>">
                    <?php echo $radek["email"]; ?>
                </a>
            </td>
            <?php
            echo "<td>" . $radek["cena_fak"] . "</td>";
        echo "</tr>";
    }
}

if (isset($_GET["search"])) {
    $kde = htmlentities(key($_GET["search"]));
    $co = htmlentities(current($_GET["search"]));
    $co = "%" . $co . "%";

    $results = find($co, $kde);
}

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
    
<a href="index.php">../</a>
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
        <input type="text" name="search[faktura]" disabled placeholder="Cislo faktury"><br>
    </div>
    <button type="submit" value="hledat">Hledat</button>
</form>

<div id="results">
    <?php 
        $sloupce = array_keys($results[0]);
        $pocet_sloupcu = count($sloupce);
    ?>
        <table>
            <thead>
                <tr>
                    <?php foreach($sloupce as $sloupec) {
                        echo "<th>" . $sloupec . "</th>";
                    } ?>
                </tr>
            </thead>
            <tbody>
                <?php 
                
                switch ($kde) {
                    case "zakaznik":
                        print_zak($results);
                        break;
                    case "email":
                        print_zak($results);
                        break;
                    case "zbozi":
                        print_zbozi($results);
                        break;
                    case "faktura":
                        print_fak($results);
                        break;
                }


                ?>
            </tbody>
        </table>

</div>

</body>
</html>