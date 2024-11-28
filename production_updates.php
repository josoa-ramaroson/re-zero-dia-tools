<?php
	require 'fonction.php';
    $link = mysqli_connect ($host,$user,$pass);
    mysqli_select_db($link, $db);

$id=addslashes($_POST['idp']);
$id_nom=addslashes($_POST['id_nom']);
$mois=addslashes($_POST['mois']);
$annee=addslashes($_POST['annee']);
$prod=addslashes($_POST['prod']);
$dist=addslashes($_POST['dist']);
$auxi=$prod-$dist;
$gazoil=addslashes($_POST['gazoil']);
$Huile=addslashes($_POST['Huile']);
$centrale=addslashes($_POST['centrale']);

$sqlp="update $tbl_production  set  id_nom='$id_nom', mois='$mois' , annee='$annee' ,  prod='$prod' , dist='$dist' ,auxi='$auxi' , gazoil='$gazoil', Huile='$Huile', centrale='$centrale' WHERE  id='$id'";
$resultp=mysqli_query($link, $sqlp);
if($resultp){
}
else {
echo "ERROR";
}
mysqli_close($link);
?>
<?php
header("location: production.php");
?>