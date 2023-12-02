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

$faktura = najdi_zbozi_podle_id($id_fak, $conn);

if (!$faktura) {
    header("Location: index.php?error=22");
    exit();
}
echo "<pre>" .print_r($faktura, true) . "</pre>"; 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Uprava zbozi <?php echo $id_fak ?></title>
</head>
<body>
    
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
                    <td><?php echo $faktura["id_zbozi"]; ?>
                        <input type="hidden" name="id_zbozi" value='<?php echo $faktura["id_zbozi"]; ?>'>
                    </td>
                    <td>
                        <input type="text" name="nazev" value='<?php echo $faktura["nazev"]; ?>' required>
                    </td>
                    <td>
                        <input type="number" name="cena" value='<?php echo $faktura["cena"] ?>' min=1 required>
                    </td>
                    <td>
                        <a href=<?php echo "inc/smazatzbozi.inc.php?id=".$faktura["id_zbozi"]; ?>>X</a>
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

