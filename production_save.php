<?php
require 'fonction.php';

$id_nom=addslashes($_POST['id_nom']);
$mois=addslashes($_POST['mois']);
$annee=addslashes($_POST['annee']);
$prod=addslashes($_POST['prod']);
$dist=addslashes($_POST['dist']);
$auxi=$prod-$dist;
$gazoil=addslashes($_POST['gazoil']);
$Huile=addslashes($_POST['Huile']);
$centrale=addslashes($_POST['centrale']);
	  
$sqlp="INSERT INTO $tbl_production ( id_nom   , mois   ,annee, prod, dist, auxi, gazoil , Huile, centrale )

 VALUES ('$id_nom' ,'$mois','$annee',  '$prod', '$dist', '$auxi', '$gazoil' ,'$Huile' , '$centrale')";
				 
$r=mysqli_query($linki,$sqlp);
mysqli_close($linki);
?>
<?php
header("location: production.php");
?>