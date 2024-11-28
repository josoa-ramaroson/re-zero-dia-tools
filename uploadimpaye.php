 <?php
$csv = new SplFileObject('impayee.csv', 'r');
$csv->setFlags(SplFileObject::READ_CSV);
$csv->setCsvControl(';', '"', '"');
 
require 'fonction.php';
$link = mysqli_connect ($host,$user,$pass);
mysqli_select_db($link, $db);

?>
<?php
//foreach($csv as $ligne)
foreach(new LimitIterator($csv, 1) as $ligne)
{
?>  
<table width="100%" border="0" cellspacing="1" cellpadding="1">
  <tr>
    <td width="14%"><?php $Police=addslashes($ligne[0]);  //echo $ligne[0];?> </td>
    <td width="26%"><?php $impayee=addslashes($ligne[1]);      //echo $ligne[2];?></td>
  </tr>
</table>

<?php

$valeur_existant = "SELECT COUNT(*) AS nb FROM billing  WHERE Police='$Police'";
$sqLvaleur = mysqli_query($link, $valeur_existant)or exit(mysqli_error($link));
$nb = mysqli_fetch_assoc($sqLvaleur);

if($nb['nb'] == 1)
{ 	
$sRequete ="update billing  SET   impayee='$impayee', totalnet='$impayee' ,  report='$impayee',  ci='ci' , st='E' , fannee='2015',nserie='7' , nfacture='impN2'  WHERE Police='$Police'";
	$sresult1=mysqli_query($link, $sRequete);
}
else 
{
echo "$Police" ;
}
}
?>
