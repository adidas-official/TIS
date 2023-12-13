<?php 

require_once('config.php');
require_once("inc/dbh.inc.php");
require_once("inc/functions.php");

if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $zakaznik_faktura = zakaznik_faktura($conn, $id);
    $zbozi = vypis_zbozi($conn, $_GET["orderby"], $_GET["desc"]);
} else {
    header("Location: index.php");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $zakaznik_faktura[0]["jmeno"] ?></title>
</head>
<body>

    <?php if (!$zakaznik_faktura) { echo "Chyba v databazi: no record";} ?>
    <a href="index.php">../</a>

    <h1>Zakaznik: <?php echo $zakaznik_faktura[0]["jmeno"] . " | " . $zakaznik_faktura[0]["email"] ?></h1>

    <a href=<?php echo "upravzakaznika.php?id=$id" ?>>Upravit zakaznika</a>

    <div id="faktury">
        <h2>Faktury</h2>
        <?php 
            if (!empty($zakaznik_faktura[0]["id_fak"])) {
                ?>
            <table>
                <thead>
                    <th>ID faktury</th>
                    <th>Cena</th>
                </thead>
                <tbody>
                <?php 

                    foreach ($zakaznik_faktura as $objednavka) {
                        echo "<tr>".
                                "<td>".
                                "<a href='faktura.php?id=" . $objednavka["id_fak"] . "'>" .
                                $objednavka["id_fak"] .
                                "</a>
                                </td>" .
                                "<td>". $objednavka["cena_fak"] .
                                "<a href='inc/smaz_fakturu.inc.php?id=" . $objednavka["id_fak"] . "&id_z=" . $zakaznik_faktura[0]["id_zak"]. "'>X</a></td>" .
                            "</tr>";
                    }
                ?>
                </tbody>
            </table>
            <?php 
                } else {
                    echo "Zakaznik nema zadne faktury";
                }
            ?>

        <h3>Nova objednavka</h3>

        <form action="inc/objednavka.inc.php" method="POST">
            <input type="hidden" name="zakaznik_faktura" value=
                <?php
                    echo $zakaznik_faktura[0]["id_zak"]
                ?>
            >
            <table>
                <thead>
                    <tr>
                        <th>Cislo zbozi
                            <a href="zakaznik.php?id=<?php echo $id ?>&orderby=id_zbozi">+</a>
                            <a href="zakaznik.php?id=<?php echo $id ?>&orderby=id_zbozi&desc=true">-</a>
                        </th>
                        <th>Nazev zbozi
                            <a href="zakaznik.php?id=<?php echo $id ?>&orderby=nazev">+</a>
                            <a href="zakaznik.php?id=<?php echo $id ?>&orderby=nazev&desc=true">-</a>
                        </th>
                        <th>Cena bez DPH
                            <a href="zakaznik.php?id=<?php echo $id ?>&orderby=cena">+</a>
                            <a href="zakaznik.php?id=<?php echo $id ?>&orderby=cena&desc=true">-</a>
                        </th>
                        <th>Cena s DPH</th>
                        <th>Pocet</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($zbozi as $produkt) {
                        ?>
                        <tr>
                            <td>
                                <input type="checkbox" name="id_zbozi[<?php echo $produkt["id_zbozi"]; ?>]" value=<?php echo $produkt["id_zbozi"]; ?>>
                                <?php echo $produkt["id_zbozi"]; ?>
                            </td>
                            <td><?php echo $produkt["nazev"] ?></td>
                            <td><?php echo $produkt["cena"] . " Kč"; ?></td>
                            <td><?php echo strval(intval($produkt["cena"]) * 1.21) . " Kč"; ?></td>
                            <td>
                                <input type="number" name="ks[<?php echo $produkt["id_zbozi"]; ?>]" min=1>
                            </td>
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