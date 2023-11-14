<?php
require("connect.php");
?>

<HTML>
<HEAD>
<META http-equiv=Content-Type content="text/html; charset=utf-8">
<TITLE>Evidence</TITLE>
</HEAD>
<BODY>
<H1>Evidence zaměstnanců</H1>
<A HREF="pridat.php">přidání nového zaměstnance</A>
<HR>
<?php
$sql = "select * from tabulka";
 

$vysledek = mysqli_query($spojeni, $sql);

     
$i=0;
// zahlavi tabulky pro vysledky

echo "<TABLE BORDER=0  >";
echo "<TR BGCOLOR=aqua VALIGN=TOP>";
echo "<TH >Číslo</TH>";
echo "<TH >Jméno</TH>";
echo "<TH >Příjmeni</TH>";
echo "<TH></TH><TH></TH></TR>";
echo "<TR>";

if (mysqli_num_rows($vysledek) > 0) 
{

 while ($radek = mysqli_fetch_assoc($vysledek)):

if (($i%2)==1)    // sude aliche radky maji jinou platnost
       echo "<TR VALIGN=TOP BGCOLOR=SILVER>";
else
       echo "<TR VALIGN=TOP>";
          
$oc=$radek["cislo"];
echo "<TD  ALIGN=CENTER>".$radek["cislo"]. "</TD>";
echo "<TD  ALIGN=CENTER>".$radek["jmeno"]. "</TD>";
echo "<TD  ALIGN=CENTER>".$radek["prijmeni"]. "</TD>";

echo "<TD ALIGN=CENTER>".   //odkaz pro smazani zaznamu
  "<A HREF='smazat.php?oc=$oc'>Smazat</A></TD>";

echo "<TD ALIGN=CENTER>".
 "<A HREF='upravit.php?oc=$oc'>Upravit</A></TD>";
echo "<TR VALIGN=TOP>";

$i=$i+1;
endwhile;
   } else {
    echo "0 nalezených záznamů";
}



  echo"</TABLE>";

mysqli_close($spojeni);
?>
</BODY>
</HTML>