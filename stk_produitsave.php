<?php
    require 'fonction.php';
    $link = mysqli_connect ($host,$user,$pass);
    mysqli_select_db($link, $db);
	
$id_nom=addslashes($_POST['id_nom']);	
$titre=addslashes($_POST['titre']);
$type=addslashes($_POST['type']);
//echo "$titre <BR>";
if(empty($titre)) 
{ 
exit(); 
}
#---------------------------------------------------3 
$prix=addslashes($_POST['prix']);

$sqlp="INSERT INTO $tbl_produit (titre , prix ,id_nom, type ) VALUES ('$titre','$prix','$id_nom', '$type' )";
$resultp=mysqli_query($link, $sqlp);
if($resultp){
}
else {
echo "ERROR";
}
header("location: stk_produit.php");
?>