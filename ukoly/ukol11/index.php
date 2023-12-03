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
    <h2>TOOD:</h2>
    <ul>
        <li>Vyhledat zbozi</li>
        <li>Vypsat faktury</li>
        <li>Rozdelit na karty: zak|fak|zbo</li>
        <li>css</li>
    </ul>

    <a href="vyhledavac.php">Vyhledavac</a>
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
                    "</li>";
                }

                echo "</ul>";
            }

        ?>

        <h3>Pridat zakaznika</h3>
        <form action="inc/pridatzakaznika.inc.php" method="POST">
            <input type="text" name="jmeno" required placeholder="Jméno"><br>
            <input type="email" name="email" required placeholder="Email"><br>
            <button type="submit" name="pridat_zakaznika">Pridat</button>
        </form>

        <div id="zbozi">
            <h2>Zbozi</h2>
            
            <?php
            $results = vypis_zbozi($conn, $_GET["orderby"], $_GET["desc"]);
            if (empty($results)) {
                echo "<p>Nemame zadne zbozi</p>";
            } else {
                ?>

                <table>
                    <thead>
                        <tr>
                            <th>Cislo zbozi
                                <a href="index.php?orderby=id_zbozi">+</a>
                                <a href="index.php?orderby=id_zbozi&desc=true">-</a>
                            </th>
                            <th>Nazev zbozi
                                <a href="index.php?orderby=nazev">+</a>
                                <a href="index.php?orderby=nazev&desc=true">-</a>
                            </th>
                            <th>Cena zbozi
                                <a href="index.php?orderby=cena">+</a>
                                <a href="index.php?orderby=cena&desc=true">-</a>
                            </th>
                            <th>Cena zbozi s DPH</th>
                            <th>Upravit zbozi</th>
                            <th>Smazat zbozi</th>
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
                            <td> <a href=<?php echo "upravitzbozi.php?id=" . $result["id_zbozi"] ?>>*</a></td>
                            <td> <a href=<?php echo "inc/smazatzbozi.inc.php?id=". $result["id_zbozi"] ?>>X</a></td>
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
                    echo $errors[$_GET["error"]] . "<br>";
                    echo $_GET["e"];
                ?>
            </span>
        <?php
    }
    ?>

</body>
</html>