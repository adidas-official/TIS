<HTML>
<HEAD>
<TITLE>Úprava údaju</TITLE>
</HEAD>

<BODY>


<H1>Úprava údaju</H1>
<?php
  require("connect.php");

  $oc= $_GET['oc'];

   $sql = "select * from tabulka WHERE cislo=$oc";      

$vysledek = mysqli_query($spojeni, $sql);
 
$radek = mysqli_fetch_assoc($vysledek);

$oc = $radek['cislo'];
echo "číslo pracovnika: ".$oc;

mysqli_close($spojeni);
?>

<!-- vypsani polozek zaznamu do formulare pro upravy -->

<FORM ACTION="update.php" METHOD="GET">

<TABLE>

<TR><TD>Jmeno: <TD><INPUT NAME="jmeno" VALUE="<?php echo $radek['jmeno'] ?>"SIZE=11>
<TR><TD>Prijmeni: <TD><INPUT NAME=prijmeni VALUE="<?php echo $radek['prijmeni'] ?>"SIZE=20>



</TABLE>

<INPUT type="hidden"  NAME="oc" VALUE="<?php echo $oc ?>"SIZE=11>


<P><INPUT TYPE=SUBMIT VALUE="Zapiš změny">
</FORM>
<?php

?>
<FORM ACTION="index.php" method=GET>
<INPUT TYPE=SUBMIT VALUE="Zpět">
</FORM>

</BODY>
</HTML>
