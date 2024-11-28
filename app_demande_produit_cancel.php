<?php
    session_start();
    require 'fonction.php';
    $link = mysqli_connect ($host,$user,$pass);
    mysqli_select_db($link, $db);

	//$id=$_GET['ID'];
	$id=substr($_REQUEST["id"],32);
	$id_dem=substr($_REQUEST["ids"],32);
	$sql5="DELETE FROM $tbl_appdeproduit WHERE id_dp='$id'";
    $result5=mysqli_query($link, $sql5);
    if($result5){
    }
    else {
    echo "ERROR";
    }
    ?>
<?php
$idr=md5(microtime()).$id_dem;
header("location:app_demande_produit.php?id=$idr");
?>