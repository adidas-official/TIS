<?php
require("connect.php");
    
$jmeno=$_GET['jmeno'];
$prijmeni=$_GET['prijmeni'];
$oc=$_GET['oc'];
    
    $sql = "UPDATE tabulka SET   jmeno = '$jmeno', prijmeni = '$prijmeni' WHERE cislo=$oc";


if (mysqli_query($spojeni, $sql)) {
    echo "Záznam byl úspěšně opraven";
} else {
    echo "Chyba pri opravě: " . mysqli_error($spojeni);
}

mysqli_close($spojeni);





?>
<BR>
<A HREF="index.php">Prohlížení všech zaměstnanců</A>


