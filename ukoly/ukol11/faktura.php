<?php 

require_once('config.php');
require_once("inc/dbh.inc.php");
require_once("inc/functions.php");

if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $objednavka = faktura($id, $conn);
} else {
    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cezar G3000 | <?php echo $objednavka[0]["id_fak"] ?></title>
</head>
<body>

    <a href=<?php echo "zakaznik.php?id=" . $objednavka[0]["zakaznik_id"] ?>>../</a>

    <h1>Faktura <?php echo $objednavka[0]["id_fak"] . " | " . $objednavka[0]["cena_fak"] ?></h1>

    <div id="faktura">
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
                <?php foreach ($objednavka as $produkt) { ?>
                <tr>
                    <td><?php echo $produkt["zbozi_id"] ?></td>
                    <td><?php echo $produkt["nazev"] ?></td>
                    <td><?php echo $produkt["cena"] ?></td>
                    <td><?php echo strval(intval($produkt["cena"]) * 1.21) . " Kč" ?></td>
                    <td><?php echo $produkt["pocet"] ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>

        <a href="<?php echo "upravobjednavku.php?id=".$objednavka[0]["id_fak"]?>">Upravit</a>
    </div>
    
</body>
</html>