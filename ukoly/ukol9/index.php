<?php session_start(); 

    function jmeno() {
        if (isset($_SESSION["status"])) {
            $status = $_SESSION["status"];
            return $status;
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cviceni 9</title>
</head>
<body>

    <main>
        <form action="proces.php" method="POST">

            <input type="text" name="jmeno" id="jmeno" placeholder="zadejte jmeno">
            <input type="text" name="delka" id="delka" placeholder="zadejte text > 8 znaku">
            <input type="text" name="reg" id="reg" placeholder="zadejte znak, cislo, spec.">
            <input type="text" name="cislo" id="cislo" placeholder="zadejte cele cislo mezi 1 a 10">
            <input type="file" name="upload" id="upload">

            <input type="submit" value="Odeslat">
        </form>

        <div class="result">
            <span id="res-jmeno">
                <ul>
                <?php 
                    if (isset($_SESSION["status"])) {
                        $status = $_SESSION["status"];
                        foreach ($status as $stat) {
                            echo "<li>" . $stat . "</li>";
                        }
                    }
                ?></ul>
            </span>
            <span id="res-delka"></span>
            <span id="res-reg"></span>
            <span id="res-cislo"></span>
        </div>
    </main>
    
</body>
</html>