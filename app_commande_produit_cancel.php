<?php
    session_start();
    require 'fonction.php';
	//$id=$_GET['ID'];
	$id=substr($_REQUEST["id"],32);
	$id_dem=substr($_REQUEST["ids"],32);
	$sql5="DELETE FROM $tbl_appcoproduit WHERE id_dp='$id'";
    $result5=mysqli_query($link,$sql5);
    if($result5){
    }
    else {
    echo "ERROR";
    }
    ?>
<?php
$idr=md5(microtime()).$id_dem;
header("location:app_commande_produit.php?id=$idr");
?>