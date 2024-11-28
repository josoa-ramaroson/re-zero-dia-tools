<?php 
$_POST['m1']=$_SESSION['u_login'];
require 'fonction.php';
$link = mysqli_connect ($host,$user,$pass);
mysqli_select_db($link, $db);
$sql="SELECT * FROM $tbl_utilisateur WHERE u_login LIKE '$_POST[m1]'";

$resultat=mysqli_query($link, $sql) or die("Invalid query");
while($u_utilisateur=mysqli_fetch_array($resultat))
{
$id_user=$u_utilisateur['id_u'];
$nom=$u_utilisateur['u_nom'];
$prenom=$u_utilisateur['u_prenom'];
$u_niveau=$u_utilisateur['u_niveau'];
$id_agence=$u_utilisateur['agence'];
$id_nom=$u_utilisateur['u_login'];
$_SESSION['id_nom']=$id_nom;
$_SESSION['u_niveau']=$u_niveau;

require 'fonction_niveau_save.php';
	  
echo " Bienvenu (e)   $nom  $prenom ($type) </br>";
}
?>
