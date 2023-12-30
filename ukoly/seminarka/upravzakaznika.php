<?php 

require_once("config.php");
require_once("inc/functions.php");


if (!isset($_GET["id"])) {
    header("Location: index.php");
    exit();
}

$id_zbozi = htmlentities($_GET["id"]);

if (!is_numeric($id_zbozi)) {
    header("Location: index.php?error=80");
    exit();
}

require_once("inc/dbh.inc.php");

$zakaznik = zakaznik_podle_id($id_zbozi, $conn);

// echo "<pre>" . print_r($zakaznik, true) . "</pre>";

if (!$zakaznik) {
    header("Location: index.php?error=31");
    exit();
}

include_once("public/templates/header.html");
?>

<body>
    
    <div class="container">
        <a href=<?php echo "zakaznik.php?id=" . $id_zbozi ?>>../</a>

        <h3>Uprava zakaznika <?php echo $id_zbozi ?></h3>

        <form action="inc/upravzakaznika.inc.php" method="POST">
            <input type="hidden" name="id_zak" value=<?php echo $zakaznik["id_zak"];?>>
            <input type="text" name="jmeno" value="<?php echo $zakaznik["jmeno"];?>"><br>
            <input type="email" name="email" value="<?php echo $zakaznik["email"];?>"><br>
            <button type="submit" name="upravit">Ulozit</button>
        </form>
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

</body>
</html>