<?php 

require_once('config.php');
require_once("inc/dbh.inc.php");
require_once("inc/functions.php");

if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $zakaznik = zakaznik($conn, $id);
    $zbozi = vypis_zbozi($conn);
} else {
    header("Location: index.php");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $zakaznik[0]["jmeno"] ?></title>
</head>
<body>

    <?php if (!$zakaznik) { echo "Chyba v databazi: no record";} ?>
    <a href="index.php">../</a>

    <h1>Zakaznik: <?php echo $zakaznik[0]["jmeno"] . " | " . $zakaznik[0]["email"] ?></h1>

    <div id="faktury">
        <h2>Faktury</h2>
        <table>
            <thead>
                <th>ID faktury</th>
                <th>Cena</th>
            </thead>
            <tbody>
            <?php 
            foreach ($zakaznik as $faktura) {
                echo "<tr>".
                        "<td>".
                        "<a href='faktura.php?id=" . $faktura["id_fak"] . "'>" .
                        $faktura["id_fak"] .
                        "</a>".
                        "</td>" .
                        "<td>". $faktura["cena"] . "</td>" .
                    "</tr>";
            }
            ?>
            </tbody>
        </table>

        <h3>Nova objednavka</h3>

        <form action="inc/objednavka.inc.php" method="POST">
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
                                    <input type="checkbox" name="nazev" value=<?php echo $produkt["id_zbozi"]; ?>>
                                    <?php echo $produkt["id_zbozi"]; ?>
                                </td>
                                <td><?php echo $produkt["nazev"] ?></td>
                                <td><?php echo $produkt["cena"] . " Kč"; ?></td>
                                <td><?php echo strval(intval($produkt["cena"]) * 1.21) . " Kč" ?></td>
                                <td><input type="number" name="ks" min=1></td>
                            </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
            <button type="submit" name="objednat">Objednat</button>
        </form>

    </div>
    
</body>
</html>