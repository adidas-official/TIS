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


// Kontrola jestli faktura je v db
require_once("inc/dbh.inc.php");

$objednavka = vypis_objednavku($id_fak, $conn);

if (!$objednavka) {
    header("Location: index.php?error=32");
    exit();
}

$zbozi = vypis_zbozi($conn);

// echo "<pre>" .print_r($objednavka, true) . "</pre>"; 
// echo "<pre>" .print_r($zbozi, true) . "</pre>"; 

$objednane_zbozi = array_map(
    function ($a) {
        return $a['zbozi_id'];
    }, $objednavka);

$counter = 0;

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Uprava faktury <?php echo $id_fak ?></title>
</head>
<body>
    <a href=<?php echo "faktura.php?id=" . $id_fak ?>>../</a>

    <h3>Uprava faktury <?php echo $id_fak ?></h3>
    
    <form action="inc/upravobjed.inc.php" method="POST">
        <input type="hidden" name="id_fak" value=<?php echo $id_fak?>>
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
                    <?php foreach ($zbozi as $produkt) {
                        ?>
                        <tr>
                            <td>
                                <input
                                type="checkbox"
                                name="id_zbozi[<?php echo $produkt["id_zbozi"]; ?>]"
                                value=<?php echo $produkt["id_zbozi"]; ?>
                                <?php if (in_array($produkt["id_zbozi"], $objednane_zbozi)) {echo "checked";}; ?>
                                >
                                <?php echo $produkt["id_zbozi"]; ?>
                            </td>
                            <td><?php echo $produkt["nazev"] ?></td>
                            <td><?php echo $produkt["cena"] . " Kč"; ?></td>
                            <td><?php echo strval(intval($produkt["cena"]) * 1.21) . " Kč"; ?></td>
                            <td>
                                <input
                                type="number"
                                name="ks[<?php echo $produkt["id_zbozi"]; ?>]"
                                min=1
                                <?php
                                    if(in_array($produkt["id_zbozi"], $objednane_zbozi)) {
                                        echo "value='" . $objednavka[$counter]["pocet"] . "'";
                                        $counter+=1;
                                    }; ?>
                                >
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
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

