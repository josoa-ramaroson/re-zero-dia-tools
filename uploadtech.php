 <?php
$csv = new SplFileObject('tech.csv', 'r');
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
    <td width="20%"><?php $typecompteur=addslashes($ligne[1]);   //echo $ligne[1];?></td>
    <td width="26%"><?php $phase=addslashes($ligne[2]);      //echo $ligne[2];?></td>
    <td width="18%"><?php $Tarif=addslashes($ligne[3]);       //echo $ligne[3];?></td>
    <td width="22%"><?php $amperage=addslashes($ligne[4]);      //echo $ligne[4];?></td>
  </tr>
</table>

<?php

$ncompteur=addslashes($ligne[5]);
$Indexinitial=addslashes($ligne[6]);
$datepose=addslashes($ligne[7]);

$valeur_existant = "SELECT COUNT(*) AS nb FROM clienteda  WHERE Police='$Police'";
$sqLvaleur = mysqli_query($link, $valeur_existant)or exit(mysqli_error($link));
$nb = mysqli_fetch_assoc($sqLvaleur);

if($nb['nb'] == 1)
{ 	
$sRequete ="update clienteda  SET   typecompteur='$typecompteur', phase='$phase' , Tarif='$Tarif' , amperage='$amperage' , ncompteur='$ncompteur' , Indexinitial='$Indexinitial' , datepose='$datepose' WHERE Police='$Police'";
	$sresult1=mysqli_query($link, $sRequete);
}
else 
{
echo "$Police  $nom  $commune  $ville  $quartier " ;
}
}
?>
