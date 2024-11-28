<?php
require 'fonction.php';
$link = mysqli_connect ($host,$user,$pass);
mysqli_select_db($link, $db);

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
				 
$r=mysqli_query($link, $sqlp);
mysql_close($link);
?>
<?php
header("location: production.php");
?>