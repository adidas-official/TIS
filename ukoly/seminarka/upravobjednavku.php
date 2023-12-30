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

$objednane_zbozi = array_map(
    function ($a) {
        return $a['zbozi_id'];
    }, $objednavka);

$counter = 0;

include_once("public/templates/header.html");
?>

<body>
    <div class="container">
        <a href=<?php echo "faktura.php?id=" . $id_fak ?>>../</a>

        <h3>Uprava faktury <?php echo $id_fak ?></h3>
        
        <div class="table-container full-container">
            <form action="inc/upravobjed.inc.php" id="uprav_objednavku_form" method="POST">
                <input type="hidden" name="id_fak" value=<?php echo $id_fak?>>
                    <table class="objednavka">
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
                                <tr class="<?php if (in_array($produkt["id_zbozi"], $objednane_zbozi)) {echo "oznacene";}; ?>">
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
                                    <td><span class="cena"><?php echo $produkt["cena"]; ?></span> Kč</td>
                                    <td><?php echo strval(intval($produkt["cena"]) * 1.21) . " Kč"; ?></td>
                                    <td>
                                        <input
                                        type="number"
                                        name="ks[<?php echo $produkt["id_zbozi"]; ?>]"
                                        min=0
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

            </form>
        </div>

        <div class="celkem flex-container flex-row">
            <button type="submit" id="uprav_objednavku" name="uprav">Ulozit zmeny</button>
            <div class="cena_container">
                <span class="show_cena">0</span><span> Kč</span>
            </div>
        </div>
        <!-- Submit button je mimo form -->
        <script>

            let order_form = $("#uprav_objednavku_form");
            let submit_btn = $("#uprav_objednavku");

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
    </div>
<script>$(".show_cena").html(celkem());</script>
</body>
</html>

