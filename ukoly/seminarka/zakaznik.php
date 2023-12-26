<?php 

require_once('config.php');
require_once("inc/dbh.inc.php");
require_once("inc/functions.php");

if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $zakaznik_faktura = zakaznik_faktura($conn, $id);
    $zbozi = vypis_zbozi($conn, $_GET["orderzboziby"], $_GET["desc"]);
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
        <nav>
            <span class="navigace <?php
                if (!isset($_GET["orderzboziby"])) {echo "active";};
             ?>" data-target="faktury">Faktury</span>
            <span class="navigace <?php
                if (isset($_GET["orderzboziby"])) {echo "active";};
             ?>" data-target="nova_o">Nova objednavka</span>
        </nav>

        <main>
            <div class="karta <?php
                if (!isset($_GET["orderzboziby"])) {echo "active";};
             ?>" id="faktury">
                <div class="table-container">
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
                </div>
            </div>
            <div class="karta <?php
                if (isset($_GET["orderzboziby"])) {echo "active";};
             ?>" id="nova_o">
                <div class="table-container">
                    <form action="inc/objednavka.inc.php" id="nova_objednavka_form" method="POST">
                        <input type="hidden" name="zakaznik_faktura" value=
                            <?php
                                echo $zakaznik_faktura[0]["id_zak"]
                            ?>
                        >
                        <table class="objednavka">
                            <thead>
                                <tr>
                                    <th>Cislo
                                        <a href="zakaznik.php?id=<?php echo $id ?>&orderzboziby=id_zbozi">+</a>
                                        <a href="zakaznik.php?id=<?php echo $id ?>&orderzboziby=id_zbozi&desc=true">-</a>
                                    </th>
                                    <th>Nazev
                                        <a href="zakaznik.php?id=<?php echo $id ?>&orderzboziby=nazev">+</a>
                                        <a href="zakaznik.php?id=<?php echo $id ?>&orderzboziby=nazev&desc=true">-</a>
                                    </th>
                                    <th>Cena bez DPH
                                        <a href="zakaznik.php?id=<?php echo $id ?>&orderzboziby=cena">+</a>
                                        <a href="zakaznik.php?id=<?php echo $id ?>&orderzboziby=cena&desc=true">-</a>
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
                                        <td><span class="cena"><?php echo $produkt["cena"]?></span> Kč</td>
                                        <td><?php echo strval(intval($produkt["cena"]) * 1.21) . " Kč"; ?></td>
                                        <td>
                                            <input type="number" name="ks[<?php echo $produkt["id_zbozi"]; ?>]" min=0>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </form>
                </div>

                <div class="celkem flex-container flex-row">
                    <button type="submit" id="odeslat_objednavku" name="objednat">Objednat</button>
                    <div class="cena_container">
                        <span class="show_cena">0</span><span> Kč</span>
                    </div>
                </div>
                <!-- Submit button je mimo form -->
                <script>
                    let order_form = $("#nova_objednavka_form");
                    let submit_btn = $("#odeslat_objednavku");


                    submit_btn.click(function(e) {
                        e.preventDefault();

                        var hiddenInput = $("<input>").attr({
                            type: "hidden",
                            name: submit_btn.attr("name"),
                            value: submit_btn.val()
                        });

                        order_form.append(hiddenInput);
                        order_form.submit();
                    });
                </script>
            </div>
        </main>
    </div>
</body>
</html>