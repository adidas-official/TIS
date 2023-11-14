<HTML>
<HEAD>
<TITLE>Potvrzení smazání</TITLE>
</HEAD>
<BODY>
<H1>Potvrzení smazání</H1>
<?php
  require("connect.php");

$oc=$_GET['oc'];
  $sql = "select * from tabulka WHERE cislo=$oc";      

$vysledek = mysqli_query($spojeni, $sql);
 
$radek = mysqli_fetch_assoc($vysledek);
  

echo "Chcete tento záznam opravdu smazat<BR>";

echo " Číslo:".$radek['cislo'].",  ";
echo "Jméno:        ". $radek['jmeno'].", ";
echo "Příjmení:        ". $radek['prijmeni']."<BR><BR>";
  mysqli_close($spojeni);
?>
<FORM ACTION="delete.php" method="GET">
<INPUT TYPE="HIDDEN" NAME="oc" VALUE="<?php echo $oc ?>">
<INPUT TYPE="SUBMIT" VALUE="Ano">
</FORM>



<FORM ACTION=index.php>
<INPUT TYPE=SUBMIT VALUE="Zpět">
</FORM>

</BODY>
</HTML>
