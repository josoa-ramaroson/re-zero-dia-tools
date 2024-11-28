<?php
    session_start();
    require 'fonction.php';
    $link = mysqli_connect ($host,$user,$pass);
    mysqli_select_db($link, $db);
	
	$idproduit=$_GET['ID'];
	
	$sql5="DELETE FROM $tbl_produit WHERE idproduit='$idproduit'";
    $result5=mysqli_query($link, $sql5);
    if($result5){
    //echo " cancel ";
    }
    else {
    echo "ERROR";
    }
header("location: stk_produit.php");
?>