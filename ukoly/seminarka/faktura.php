<?php 

require_once('config.php');
require_once("inc/dbh.inc.php");
require_once("inc/functions.php");

if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $objednavka = faktura($id, $conn, $_GET["orderby"], $_GET["desc"]);
} else {
    header("Location: index.php");
}

$user_permissions = permissions($_SESSION["role"]);

include_once("public/templates/header.html");
?>

<body>
    <div class="container">

        <a href=<?php echo "zakaznik.php?id=" . $objednavka[0]["zakaznik_id"] ?>>../</a>

        <h1>Faktura <?php echo $objednavka[0]["id_fak"] . " | " . $objednavka[0]["cena_fak"] ?></h1>
        <?php if ($user_permissions == "all") { ?>
        <a href="<?php echo "upravobjednavku.php?id=".$objednavka[0]["id_fak"]?>">Upravit</a> | 
        <?php } ?>
        <a href="<?php echo "pdfprint.php?id_fak=".$objednavka[0]["id_fak"]."&id_zak=".$objednavka[0]["zakaznik_id"]?>" target="blank">Tisk PDF</a>

        <div id="faktura" class="full-container">
            <table>
                <thead>
                    <tr>
                        <th>Cislo zbozi
                            <a href="faktura.php?id=<?php echo $id ?>&orderby=zbozi_id">+</a>
                            <a href="faktura.php?id=<?php echo $id ?>&orderby=zbozi_id&desc=true">-</a>
                        </th>
                        <th>Nazev zbozi
                            <a href="faktura.php?id=<?php echo $id ?>&orderby=nazev">+</a>
                            <a href="faktura.php?id=<?php echo $id ?>&orderby=nazev&desc=true">-</a>
                        </th>
                        <th>Cena bez DPH
                            <a href="faktura.php?id=<?php echo $id ?>&orderby=cena">+</a>
                            <a href="faktura.php?id=<?php echo $id ?>&orderby=cena&desc=true">-</a>
                        </th>
                        <th>Cena s DPH</th>
                        <th>Pocet
                            <a href="faktura.php?id=<?php echo $id ?>&orderby=pocet">+</a>
                            <a href="faktura.php?id=<?php echo $id ?>&orderby=pocet&desc=true">-</a>
                        </th>
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

        </div>
    </div>
</body>
</html>