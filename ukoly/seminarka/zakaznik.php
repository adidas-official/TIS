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

$user_permissions = permissions($_SESSION["role"]);

include_once("public/templates/header.html");
?>

<body>
    <div class="container">

        <?php if (!$zakaznik_faktura) { echo "Chyba v databazi: no record";} ?>
        <a href="index.php">../</a>

        <h1>Zakaznik: <?php echo $zakaznik_faktura[0]["jmeno"] . " | " . $zakaznik_faktura[0]["email"] ?></h1>

        <?php if ($user_permissions == "all") { ?>
        <a href=<?php echo "upravzakaznika.php?id=$id" ?>>Upravit zakaznika</a>
        <?php } ?>

        <div id="faktury">
            <h2>Faktury</h2>
            <?php 
                if (!empty($zakaznik_faktura[0]["id_fak"])) {
                    ?>
                <table>
                    <thead>
                        <th>ID faktury</th>
                        <th>Cena</th>
                        <th>Smazat</th>
                    </thead>
                    <tbody>
                    <?php 

                        foreach ($zakaznik_faktura as $objednavka) {
                            ?>
                            <tr>
                                <td>
                                    <a href='faktura.php?id=<?php echo $objednavka["id_fak"] ?>'>
                                        <?php echo $objednavka["id_fak"] ?>
                                    </a>
                                </td>
                                <td> <?php echo $objednavka["cena_fak"] ?></td>
                                <?php if ($user_permissions == "all") { ?>
                                <td><a href='inc/smaz_fakturu.inc.php?id=<?php echo $objednavka["id_fak"] . "&id_z=" . $zakaznik_faktura[0]["id_zak"] ?> '>X</a></td>
                                <?php } ?>
                            </tr>
                        <?php } ?>
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
                <table class="objednavka">
                    <thead>
                        <tr>
                            <th>Cislo
                                <a href="zakaznik.php?id=<?php echo $id ?>&orderby=id_zbozi">+</a>
                                <a href="zakaznik.php?id=<?php echo $id ?>&orderby=id_zbozi&desc=true">-</a>
                            </th>
                            <th>Nazev
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
    </div>
</body>
</html>