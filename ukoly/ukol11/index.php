<?php 

require_once("config.php");
require_once("inc/dbh.inc.php");
require_once("inc/functions.php");;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cezar G3000</title>
</head>
<body>

    <h1>Evidence CEZAR G3000</h1>

    <div id="zakaznici">
        <h2>Zakaznici</h2>
        <?php 
            $results = vypis_zakazniky($conn);
            if (empty($results)) {
                echo "<p>Nemame zakazniky</p>";
            } else {
                echo "<ul>";

                foreach ($results as $result) {
                    echo "<li><a href='zakaznik.php?id=" . $result["id_zak"] . "'>"
                    . $result["jmeno"] .
                    "</a>".
                    "<a href='smazatzakaznika.php?id=". $result["id_zak"] ."'>X</a>".
                    "</li>";
                }

                echo "</ul>";
            }

        ?>

        <h3>Vyhledavani</h3>
        <form action="inc/najdijmeno.inc.php" method="POST">
            <input type="text" name="jmeno" required placeholder="Jmeno ..."><br>
            <button type="submit">Vyhledej</button>
        </form>

        <h3>Pridat zakaznika</h3>
        <form action="inc/pridatzakaznika.inc.php" method="POST">
            <input type="text" name="jmeno" required placeholder="Jméno"><br>
            <input type="email" name="email" required placeholder="Email"><br>
            <button type="submit" name="pridat_zakaznika">Pridat</button>
        </form>

        <div id="zbozi">
            <h2>Zbozi</h2>
            
            <?php
            $results = vypis_zbozi($conn);
            if (empty($results)) {
                echo "<p>Nemame zadne zbozi</p>";
            } else {
                ?>

                <table>
                    <thead>
                        <tr>
                            <th>Cislo zbozi</th>
                            <th>Nazev zbozi</th>
                            <th>Cena zbozi</th>
                            <th>Cena zbozi s DPH</th>
                        </tr>
                    </thead>
                <tbody>

                <?php

                foreach ($results as $result) {
                    ?>
                        <tr>
                            <td> <?php echo $result["id_zbozi"]; ?></td>
                            <td> <?php echo $result["nazev"]; ?></td>
                            <td> <?php echo $result["cena"] . " Kč"; ?></td>
                            <td> <?php echo strval(intval($result["cena"]) * 1.21) . " Kč" ?></td>
                        </tr>

                    <?php
                }

            }
            ?>
                </tbody>
            </table>

            <h2>Nove zbozi</h2>
            <form action="inc/pridatzbozi.inc.php" method="POST">

                <input type="text" name="nazev" id="nazev" required placeholder="Nazev zbozi"><br>
                <input type="number" name="cena" id="cena" step="0.1" required placeholder="Cena zbozi"><br>
                <button type="submit" name="pridat_zbozi">Pridat</button>

            </form>
        </div>
    </div>

    <?php if (isset($_GET["error"])) { ?>
            <span class="error">
                <?php
                    include_once("errors.php");
                    echo $errors[$_GET["error"]]
                ?>
            </span>
        <?php
    }
    ?>

</body>
</html>