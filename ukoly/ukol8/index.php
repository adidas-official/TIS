<?php 
    $prekladac = Array(
        "mys" => "mouse",
        "zakladova deska" => "motherboard",
        "procesor" => "processor",
        "sitova karta" => "network card",
        "klavesnice" => "keyboard",
    );

    function autobus($km) {
        $cena = 0;
        if ($km <= 2 && $km > 0) {
            $cena = "4Kč";
        } elseif ($km <= 5 && $km > 2) {
            $cena = "6Kč";
        } elseif ($km <= 10 && $km > 5) {
            $cena = "10Kč";
        } elseif ($km <= 20 && $km > 10) {
            $cena = "15Kč";
        } else {
            $cena = "Tak daleko nejedu";
        }
        return $cena;
    }

    function obvod($r) {
        return 2 * 3.14159 * intval($r);
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ukol 8</title>
    <style>
        ul {
            list-style: none;
            padding: 0
        }
        ul::after {
            content: "";
            clear: both;
            display: table;
        }
        li {
            float: left;
            margin-left: 2ch;
        }
        section form{
            display: block;
            width: 50%;
            float:left;
        }
        section::after {
            content: "";
            clear: both;
            display: table;
        }
        .sloupec_s_vysledky {
            width: 50%;
            float: left;
        }
        .sloupec_s_vysledky span {
            width: 20ch;
            display: inline-block;
        }
    </style>
</head>
<body>
    <h1><?php echo $_SERVER["REMOTE_ADDR"] ?></h1>
    <main>
        <section>
            <h2>Ukol 1 - prekladac</h2>
            <div>
                <p>Preklada z cz do en tyto slova:</p>
                <ul>
                    <li>Mys</li>
                    <li>Zakladova deska</li>
                    <li>Procesor</li>
                    <li>Sitova karta</li>
                    <li>Klavesnice</li>
                </ul>
                <form action="#" method="GET">
                    <input type="hidden" name="ip" value="<?php echo $_SERVER["REMOTE_ADDR"] ?>">
                    <select name="translator" id="translator">
                        <option value="mys">Mys</option>
                        <option value="zakladova deska">Zakladova deska</option>
                        <option value="procesor">Procesor</option>
                        <option value="sitova karta">Sitova karta</option>
                        <option value="klavesnice">Klavesnice</option>
                    </select>
                    <input type="submit" value="prelozit">
                </form>
                <div class="sloupec_s_vysledky">
                    <span id="cz">CZ:
                        <?php 
                            if(isset($_GET["translator"])) {
                                echo $_GET["translator"];
                            };
                        ?>
                    </span>
                    <span id="en">EN:
                        <?php 
                            if(isset($_GET["translator"])) {
                                echo $prekladac[$_GET["translator"]];
                            };
                        ?>
                    </span>
                </div>
            </div>
        </section>
        <section>
            <h2>Ukol 2 - obvod kruhu</h2>
            <div>
                <form action="#" method="GET">
                    <input type="hidden" name="ip">
                    <input type="number" name="obvod" id="obvod" min="0" placeholder="zadejte polomer r" step="0.01">
                    <input type="submit" value="spocitat">
                </form>
                <span id="result">
                    <?php 
                        if(isset($_GET["obvod"])) {
                            echo obvod($_GET["obvod"]);
                        }
                    ?>
                </span>
            </div>
        </section>
        <section>
            <h2>Ukol 3</h2>
            <div>
                <form action="#" method="GET">
                    <input type="hidden" name="ip">
                    <input type="number" name="vzdalenost" id="vzdalenost" min="0" step="0.01" placeholder="vzdalenost v km">
                    <input type="submit" value="spocitat">
                </form>
                <span id="jizdne">
                    <?php 
                        if(isset($_GET["vzdalenost"])) {
                            echo autobus($_GET["vzdalenost"]);
                        }
                    ?>
                </span>
            </div>
        </section>
    </main>
    
</body>
</html>