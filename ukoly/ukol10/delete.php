<?php
require("connect.php");

$oc=$_GET['oc'];
$sql = "DELETE FROM tabulka WHERE cislo = $oc";
if (mysqli_query($spojeni, $sql)) {
    echo "Záznam byl úspěšně smazán";
} else {
    echo "Chyba pri mazání: " . mysqli_error($spojeni);
}

mysqli_close($spojeni);

 ?>

<BR>
<A HREF="index.php">Prohlížení všech zaměstnanců</A>






