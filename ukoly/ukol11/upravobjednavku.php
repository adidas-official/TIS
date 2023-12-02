<?php

require_once("config.php");
require_once("inc/functions.php");


if (!isset($_GET["id"])) {
    header("Location: index.php");
    exit();
}

$id_fak = htmlentities($_GET["id"]);

if (!is_numeric($id_fak)) {
    header("Location: index.php?error=80");
    exit();
}


// Kontrola jestli zbozi je v db
require_once("inc/dbh.inc.php");

$faktura = najdi_fakturu_podle_id($id_fak, $conn);

if (!$faktura) {
    header("Location: index.php?error=32");
    exit();
}
echo "<pre>" .print_r($faktura, true) . "</pre>"; 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Uprava faktury <?php echo $id_fak ?></title>
</head>
<body>
    
    <form action="inc/upravobjed.inc.php" method="POST">
        <table>
            <thead>
                <tr>
                    <th>Cislo zbozi</th>
                    <th>Nazev zbozi</th>
                    <th>Cena bez DPH</th>
                    <th>Cena s DPH</th>
                    <th>Pocet</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($faktura as $produkt) { ?>
                <tr>
                    <td>
                        <input type="hidden" name="zbozi_id" value=<?php echo $produkt["zbozi_id"] ?>>
                        <?php echo $produkt["zbozi_id"] ?>
                    </td>
                    <td>
                        <input type="text" name="nazev[]" id=""><?php echo $produkt["nazev"] ?></td>
                    <td><?php echo $produkt["cena"] ?></td>
                    <td><?php echo strval(intval($produkt["cena"]) * 1.21) . " Kč" ?></td>
                    <td><?php echo $produkt["pocet"] ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>

        <button type="submit" name="uprav">Ulozit zmeny</button>

    </form>

    <?php if (isset($_GET["error"])) { ?>
        <span class="error">
            <?php
                echo $errors[$_GET["error"]]
            ?>
        </span>
    <?php
        }
    ?>
    <?php if (isset($_GET["status"])) { ?>
        <span class="status">
            <?php
                echo $status[$_GET["status"]]
            ?>
        </span>
    <?php
        }
    ?>
</body>
</html>

