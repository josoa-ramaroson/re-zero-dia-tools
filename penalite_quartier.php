<?php
	require 'fonction.php';
	require 'configuration.php';
    $link = mysqli_connect ($host,$user,$pass);
    mysqli_select_db($link, $db);

$RefQuartier=addslashes($_POST['quartier']);
$refville=addslashes($_POST['refville']);

$sql1 = "SELECT * FROM quartier where id_quartier=$RefQuartier";
$result1 = mysqli_query($link, $sql1);
while ($row1 = mysqli_fetch_assoc($result1)) {
$quartier=$row1['quartier'];
}  

$sql2 = "SELECT * FROM ville where refville=$refville";
$result2 = mysqli_query($link, $sql2);
while ($row2 = mysqli_fetch_assoc($result2)) {
$ville=$row2['ville'];
} 

    $m1v=$ville;
	$m2q=$quartier;
	
$sql1 = "SELECT * FROM $tbl_fact f, $tbl_contact c  where Pre!='1000' and (etat='facture' or etat='accompte') and st='E' and c.id=f.id and c.ville='$m1v' and  c.quartier='$m2q' and f.report > 1000 and nserie='$cserie' and f.fannee='$anneec'";
$result1 = mysqli_query($link, $sql1);
while ($row1 = mysqli_fetch_assoc($result1)) {
$totalneti=$row1['totalnet'];
$reporti=$row1['report'];
$idfi=$row1['idf'];
 

$Pre='1000';
$totalnet=$totalneti+$Pre;
$report=$reporti+$Pre;

#---------------------------------------------------3 
$sqlp="update  $tbl_fact f , $tbl_contact c   set   bstatut='retard' , Pre='$Pre' , totalnet='$totalnet' , report='$report' WHERE   Pre!='1000' and (etat='facture' or etat='accompte') and st='E' and c.ville='$m1v' and  c.quartier='$m2q' and idf='$idfi' ";
$resultp=mysqli_query($link, $sqlp);

}
mysqli_close($link);
header("location: penalite.php?a=1");
?>