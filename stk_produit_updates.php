<?php
    require 'fonction.php';
    $link = mysqli_connect ($host,$user,$pass);
    mysqli_select_db($link, $db);
	
$idproduit=addslashes($_POST['idp']);
//echo "$idproduit <BR>";	
$titre=addslashes($_POST['mproduit']);
//echo "$titre <BR>";
if(empty($titre)) 
{ 
exit(); 
}
#---------------------------------------------------3 
$prix=addslashes($_POST['prix']);

$type=addslashes($_POST['type']);

$id_nom='';
$sqlp="update  $tbl_produit set titre='$titre' , idproduit='$idproduit', prix='$prix' , id_nom='$id_nom' , type='$type' 
WHERE  idproduit='$idproduit'";
$resultp=mysqli_query($link, $sqlp);
if($resultp){
}
else {
echo "ERROR";
}
mysqli_close($link);
header("location: stk_produit.php");
?>