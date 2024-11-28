<?php
require 'fonction.php';
$link = mysqli_connect ($host,$user,$pass);
mysqli_select_db($link, $db);

//IDENTIFICATION CODE QUARTIER """""""""""""""""""""""""""""""""
$RefQuartier=addslashes($_POST['quartier']);
$refville=addslashes($_POST['refville']);

$sql1 = "SELECT * FROM quartier where id_quartier=$RefQuartier";
$result1 = mysqli_query($link, $sql1);
while ($row1 = mysqli_fetch_assoc($result1)) {
$bquartier=$row1['quartier'];
}  

$sql2 = "SELECT * FROM ville where refville=$refville";
$result2 = mysqli_query($link, $sql2);
while ($row2 = mysqli_fetch_assoc($result2)) {
$bville=$row2['ville'];
} 

$blogin=addslashes($_POST['blogin']);

$valeur_existant = "SELECT COUNT(*) AS nb FROM $tbl_saisie  WHERE blogin='$blogin' ";
$sqLvaleur = mysqli_query($link, $valeur_existant)or exit(mysqli_error($link));
$nb = mysqli_fetch_assoc($sqLvaleur);

if($nb['nb'] == 1)
{
$sqlp="update  $tbl_saisie  set  bquartier='$bquartier' , bville='$bville'  WHERE blogin='$blogin' ";
$resultp=mysqli_query($link, $sqlp);
header("location: bsaisie.php");
}
else 
{

$sqlp="INSERT INTO $tbl_saisie  ( blogin  , bville , bquartier)
                    VALUES      ('$blogin','$bville', '$bquartier')";								
$r=mysqli_query($link, $sqlp)
or die(mysqli_error($link));
mysql_close($link);
header("location: bsaisie.php");
}
?>