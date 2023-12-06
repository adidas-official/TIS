<?php

require_once("config.php");
require_once("inc/functions.php");


if (!isset($_GET["id"])) {
    header("Location: index.php");
    exit();
}

$id_zbozi = htmlentities($_GET["id"]);


if (!is_numeric($id_zbozi)) {
    header("Location: index.php?error=80");
    exit();
}


// Kontrola jestli zbozi je v db
require_once("inc/dbh.inc.php");

$objednavka = najdi_zbozi_podle_id($id_zbozi, $conn);

if (!$objednavka) {
    header("Location: index.php?error=22");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Uprava zbozi <?php echo $id_zbozi ?></title>
</head>
<body>
    <a href="index.php">../</a>
    
    <form action="inc/upravzbozi.inc.php" method="POST">

        <table>
            <thead>
                <tr>
                    <th>Cislo zbozi</th>
                    <th>Nazev zbozi</th>
                    <th>Cena zbozi</th>
                    <th>Smazat</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?php echo $objednavka["id_zbozi"]; ?>
                        <input type="hidden" name="id_zbozi" value='<?php echo $objednavka["id_zbozi"]; ?>'>
                    </td>
                    <td>
                        <input type="text" name="nazev" value='<?php echo $objednavka["nazev"]; ?>' required>
                    </td>
                    <td>
                        <input type="number" name="cena" value='<?php echo $objednavka["cena"] ?>' min=1 required>
                    </td>
                    <td>
                        <a href=<?php echo "inc/smazatzbozi.inc.php?id=".$objednavka["id_zbozi"]; ?>>X</a>
                    </td>
                </tr>
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

