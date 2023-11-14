<?php
require("connect.php");

$sql = "INSERT INTO tabulka (jmeno, prijmeni)
values('$_GET[jmeno]','$_GET[prijmeni]')";

     

if (mysqli_query($spojeni, $sql)) {
    echo "Záznam byl úspešně přidán";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($spojeni);
}
mysqli_close($spojeni);

?>

<BR>
<A HREF="index.php">Prohlíženi všech zaměstnanců</A>






