<?php 

require_once("config.php");
require_once("inc/dbh.inc.php");
require_once("inc/functions.php");;

if (!isset($_SESSION["userid"])) {
    header("Location: login.php");
    exit();
}

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
        <li>Rozdelit na karty: zak|fak|zbo</li>
        <li>css</li>
    </ul>

    <a href="inc/logout.inc.php">Odhlasit</a>

    <a href="vyhledavac.php">Vyhledavac</a>
    <a href="pdfprint.php">pdf</a>
    <div id="zakaznici">
        <h2>Zakaznici</h2>
        <?php 
            $zakaznici = vypis_zakazniky($conn);
            if (empty($zakaznici)) {
                echo "<p>Nemame zakazniky</p>";
            } else {
                echo "<ul>";

                foreach ($zakaznici as $zakaznik) {
                    echo "<li><a href='zakaznik.php?id=" . $zakaznik["id_zak"] . "'>"
                    . $zakaznik["jmeno"] .
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
            $results = vypis_zbozi($conn, $_GET["orderzboziby"], $_GET["zbozidesc"]);
            if (empty($results)) {
                echo "<p>Nemame zadne zbozi</p>";
            } else {
                ?>

                <table>
                    <thead>
                        <tr>
                            <th>Cislo zbozi
                                <a href="index.php?orderzboziby=id_zbozi">+</a>
                                <a href="index.php?orderzboziby=id_zbozi&zbozidesc=true">-</a>
                            </th>
                            <th>Nazev zbozi
                                <a href="index.php?orderzboziby=nazev">+</a>
                                <a href="index.php?orderzboziby=nazev&zbozidesc=true">-</a>
                            </th>
                            <th colspan="2">Cena zbozi
                                <a href="index.php?orderzboziby=cena">+</a>
                                <a href="index.php?orderzboziby=cena&zbozidesc=true">-</a>
                            </th>
                            <th colspan="2">Cena zbozi s DPH</th>
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
                            <td> <?php echo $result["cena"]; ?></td>
                            <td>Kc</td>
                            <td> <?php echo strval(intval($result["cena"]) * 1.21); ?></td>
                            <td>Kc</td>
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

        <div id="faktury">
            <h3>Faktury</h3>
            <?php $faktury = vypis_faktury($conn, $_GET["orderfakturyby"], $_GET["fakturydesc"]); ?>

            <table>
                <thead>
                    <tr>
                        <th>
                            Cislo faktury
                            <a href="index.php?orderfakturyby=id_fak">+</a>
                            <a href="index.php?orderfakturyby=id_fak&fakturydesc=true">-</a>
                        </th>
                        <th>
                            Zakaznik
                            <a href="index.php?orderfakturyby=jmeno">+</a>
                            <a href="index.php?orderfakturyby=jmeno&fakturydesc=true">-</a>
                        </th>
                        <th>
                            Email
                            <a href="index.php?orderfakturyby=email">+</a>
                            <a href="index.php?orderfakturyby=email&fakturydesc=true">-</a>
                        </th>
                        <th colspan="2">
                            Cena
                            <a href="index.php?orderfakturyby=cena_fak">+</a>
                            <a href="index.php?orderfakturyby=cena_fak&fakturydesc=true">-</a>
                        </th>
                        <th colspan="2">Cena s DPH</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 

                    foreach($faktury as $faktura) {
                        ?> 
                        <tr>
                            <td>
                                <a href="<?php echo "faktura.php?id=" . $faktura["id_fak"] ?>">
                                    <?php echo $faktura["id_fak"]; ?>
                                </a>
                            </td>
                            <td>
                                <a href="<?php echo "zakaznik.php?id=" . $faktura["zakaznik_id"] ?>">
                                    <?php echo $faktura["jmeno"]; ?>
                                </a>
                            </td>
                            <td>
                                <a href="<?php echo "mailto:" . $faktura["email"]; ?>">
                                    <?php echo $faktura["email"]; ?>
                                </a>
                            </td>
                            <td><?php echo $faktura["cena_fak"]; ?></td>
                            <td>Kc</td>
                            <td><?php echo strval(intval($faktura["cena_fak"]) * 1.21); ?></td>
                            <td>Kc</td>
                        </tr>
                        <?php
                    }
                    
                    ?>
                </tbody>
            </table>
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